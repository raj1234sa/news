<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

function get_leftbar_links()
{
    $links = array(
        array(
            'title' => COMMON_DASHBOARD,
            'icon' => 'menu-icon fas fa-tachometer-alt',
            'route' => DIR_HTTP_ADMIN.ADMIN_FILE_DASHBOARD
        ),
        array(
            'title' => COMMON_INDUSTRY,
            'icon' => 'menu-icon fa fa-list',
            'route' => '',
            'children' => array(
                array(
                    'title' => COMMON_INDUSTRY,
                    'route' => DIR_HTTP_ADMIN.ADMIN_FILE_INDUSTRIES,
                    'activeLink' => array(ADMIN_FILE_INDUSTRY_EDIT),
                ),
            ),
        ),
        array(
            'title' => COMMON_MANAGE_ZONE,
            'icon' => 'menu-icon fas fa-map-marker-alt',
            'route' => '',
            'children' => array(
                array(
                    'title' => COMMON_COUNTRY,
                    'route' => DIR_HTTP_ADMIN.ADMIN_FILE_COUNTRIES,
                    'activeLink' => array(ADMIN_FILE_COUNTRY_EDIT),
                ),
                array(
                    'title' => COMMON_STATE,
                    'route' => DIR_HTTP_ADMIN.ADMIN_FILE_STATES,
                    'activeLink' => array(ADMIN_FILE_STATE_EDIT),
                ),
                array(
                    'title' => COMMON_CITY,
                    'route' => DIR_HTTP_ADMIN.ADMIN_FILE_CITIES,
                    'activeLink' => array(ADMIN_FILE_CITY_EDIT),
                ),
            ),
        ),
        array(
            'title' => COMMON_MANAGE_NEWS,
            'icon' => 'menu-icon fa fa-list',
            'route' => '',
            'children' => array(
                array(
                    'title' => COMMON_NEWS,
                    'route' => DIR_HTTP_ADMIN.ADMIN_FILE_NEWS,
                    'activeLink' => array(ADMIN_FILE_NEWS_EDIT),
                ),
            ),
        ),
    );
    return $links;
}

function initRequestValue($name, $default='') {
    return (isset($_REQUEST[$name]) && !empty($_REQUEST[$name])) ? $_REQUEST[$name] : $default;
}

function initGetValue($name, $default='') {
    return (isset($_GET[$name]) && !empty($_GET[$name])) ? $_GET[$name] : $default;
}

function initPostValue($name, $default='') {
    return (isset($_POST[$name]) && !empty($_POST[$name])) ? $_POST[$name] : $default;
}

function initFileValue($name, $default='') {
    return (isset($_FILES[$name]) && !empty($_FILES[$name])) ? $_FILES[$name]['name'] : $default;
}

function extract_search_fields($prefix = '') {
    $search_data = initRequestValue('data');
    parse_str($search_data, $result_search);
    $result_search['start'] = initRequestValue('start');
    $result_search['length'] = initRequestValue('length');
    $result_search['column'] = initRequestValue('order')[0]['column'];
    $result_search['dir'] = initRequestValue('order')[0]['dir'];
    return $result_search;
}

function export_report($spreadsheet, $fileName = 'download.xlsx')
{
    ob_start();
    IOFactory::createWriter($spreadsheet, 'Xlsx')->save('php://output');
    $pdfData = ob_get_contents();
    ob_end_clean();
    return array(
        'op' => 'ok',
        'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($pdfData),
        'fileName' => $fileName,
    );
}

function export_file_generate($export_data_structure, $export_data, $extra = array())
{
    if (!empty($export_data)) {
        $rowIndex = 0;
        $colIndex = 0;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        global $sheetTitle;
        $sheet->setTitle((!empty($extra['sheetTitle']) ? $extra['sheetTitle'] : $sheetTitle));

        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => "ffffff"
                ]
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startColor' => [
                    'rgb' => '4659d4',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
        ];

        $styleUrlArray = [
            'font' => [
                'underline' => true,
                'color' => [
                    'rgb' => "1a58c7"
                ]
            ],
        ];
        $headerCells = array();
        foreach ($export_data_structure as $key => $value) {
            foreach ($value as $value1) {
                $header[] = $value1['title'];
                $sheet->setCellValue(chr(65 + $key) . '1', $value1['title']);
                $sheet->getStyle(chr(65 + $key) . '1')->applyFromArray($styleArray);
                $sheet->getColumnDimension(chr(65 + $key))->setAutoSize(true);
            }
            $headerCells[] = chr(65 + $key) . '1';
        }
        $rowIndex++;

        $sheet->insertNewRowBefore(1, 2);
        $rowIndex += 2;
        $sheet->mergeCells($headerCells[0] . ":" . $headerCells[count($headerCells) - 1]);
        global $headerDate;
        $headerDate = !empty($extra['headerDate']) ? $extra['headerDate'] : $headerDate;
        $sheet->setCellValue("A1", "Report $headerDate");
        $sheet->getStyle("A1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getRowDimension(1)->setRowHeight(30);
        $cellvalue = array();
        foreach ($export_data as $rowcount => $value) {
            $value = objectToArray($value);
            $rowcount += $rowIndex;
            foreach ($export_data_structure as $colcount => $value1) {
                $cellHeight = 15;
                $value1 = array_values($value1)[0];
                if(isset($value1['call_func']) && !empty($value1['call_func'])) {
                    $func_param = array();
                    foreach ($value1['func_param'] as $param) {
                        if(in_array($param, array_keys($value))) {
                            $func_param[] = $value[$param];
                        } else {
                            $func_param[] = $param;
                        }
                    }
                    $value[$value1['name']] = call_user_func_array($value1['call_func'], $func_param);
                }
                if (is_array($value[$value1['name']])) {
                    $cellHeight = count($value[$value1['name']]) * 15;
                    $value[$value1['name']] = implode("\n", $value[$value1['name']]);
                }

                if (isset($value1['datatype'])) {
                    switch ($value1['datatype']) {
                        case 'email':
                            $sheet->getCell(chr(65 + $colcount) . ($rowcount + 1))->getHyperlink()->setUrl("mailto:" . $value[$value1['name']]);
                            $sheet->getStyle(chr(65 + $colcount) . ($rowcount + 1))->applyFromArray($styleUrlArray);
                            break;

                        case 'date':
                            $sheet->getStyle(chr(65 + $colcount) . ($rowcount + 1))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $value[$value1['name']] = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($value[$value1['name']]);
                            break;

                        case 'currency':
                            $sheet->getStyle(chr(65 + $colcount) . ($rowcount + 1))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
                            break;

                        default:
                            break;
                    }
                }
                if (isset($value1['total'])) {
                    if ($value1['total'] == TRUE) {
                        $cellvalue[chr(65 + $colcount)][] = chr(65 + $colcount) . ($rowcount + 1);
                        $cellvalue[chr(65 + $colcount)]['lastcell'] = chr(65 + $colcount) . ($rowcount + 1 + 2);
                    }
                }
                $sheet->setCellValue(chr(65 + $colcount) . ($rowcount + 1), $value[$value1['name']]);

                $sheet->getStyle(chr(65 + $colcount) . ($rowcount + 1))->getAlignment()->setWrapText(true);
                $sheet->getRowDimension($rowcount + 1)->setRowHeight($cellHeight);
                $colIndextemp = $colcount + 1;
            }
            $colIndex += $colIndextemp;
            $rowIndextemp = $rowcount;
        }
        $rowIndex += $rowIndextemp;

        foreach ($cellvalue as $key => $value) {
            $sheet->setCellValue($value['lastcell'], "=SUM({$cellvalue[$key][0]}:" . array_pop($cellvalue[$key]) . ")");
        }
        foreach ($headerCells as $key => $value) {
            $sheet->getStyle(chr(65 + $key) . $rowIndex)->applyFromArray($styleArray);
        }
        return $spreadsheet;
    }
}

function uploadFiles($destination, $element) {
    if(!empty($element)) {
        if(!empty($_FILES[$element])) {
            $target_dir = $destination;
            $target_file = $target_dir . basename($_FILES[$element]["name"]);
            if (move_uploaded_file($_FILES[$element]["tmp_name"], $target_file)) {
                return false;
            } else {
                return true;
            }
        }
    }
    return false;
}