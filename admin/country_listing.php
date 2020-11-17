<?php

require_once("../lib/common.php");
require_once(DIR_WS_MODEL."CountryMaster.php");

$dataCountry = new CountryData();
$objCountryMaster = new CountryMaster();

$pageTitle = COMMON_COUNTRIES;

$listing_data = initPostValue('listing_data');
$export = initRequestValue('export');
$action = initRequestValue('action');

if($action == 'change_status') {
    $status_code = initPostValue('status_code');
    $status = initPostValue('status');
    $id = initPostValue('id');
    if($status_code == 'status') {
        $dataCountry->status = ($status == '1') ? '1' : '0';
        $dataCountry->country_id = $id;
        $objCountryMaster->editCountry($dataCountry);
    }
    echo 'success';
    exit;
}

if($action == 'delete') {
    $id = initGetValue('country_id');
    if(!empty($id)) {
        $objCountryMaster->deleteCountry($id);
        echo 'success';
    } else {
        echo 'Cannot delete record.';
    }
    exit;
}

if($is_ajax_request && ($listing_data || $export)) {
    $search = extract_search_fields();
    $objCountryMaster->setLimit($search['start'], $search['length']);
    $objCountryMaster->setOrderBy($objCountryMaster->fieldArr[$search['column']].' '.$search['dir']);

    if($export) {
        $objCountryMaster->setSelect("*, IF(country.status = '1', 'Enabled', 'Disabled') as status");
    }

    $objCountryMaster->setFoundRows();
    $countryDetails = $objCountryMaster->getCountry();

    if($export) {
        $countryDetails = objectToArray($countryDetails);
        $export_structure = array();
        $export_structure[] = array('country_id'=>array('name'=>'country_id', 'title'=>COMMON_ID));
        $export_structure[] = array('country_name'=>array('name'=>'country_name', 'title'=>COMMON_COUNTRY_NAME));
        $export_structure[] = array('status'=>array('name'=>'status', 'title'=>COMMON_STATUS));

        $sheetTitle = "Country Report";
        $headerDate = "All";
        $spreadsheet = export_file_generate($export_structure, $countryDetails);
        echo json_encode(export_report($spreadsheet, 'export_country.xlsx'));
        exit;
    }

    $countires = array();
    $totalRec = 0;
    if(!empty($countryDetails)) {
        $totalRec = $countryDetails->FoundRows();
        $sr = $search['start'] + 1;
        foreach ($countryDetails as $cnt) {
            $rec = array();
            $rec['DT_RowId'] = "country:".$cnt['country_id'];
            $rec[] = $sr++;
            $rec[] = $cnt['country_name'];
            $rec[] = form_switchbutton('status', $cnt['status'], array('class'=>'ajax change_status'));
            $action_buttons = array();
            $action_buttons[COMMON_EDIT] = array(
                'link' => DIR_HTTP_ADMIN.ADMIN_FILE_COUNTRY_EDIT.'?country_id='.$cnt['country_id'],
                'icon' => 'far fa-edit',
            );
            $action_buttons[COMMON_DELETE] = array(
                'link' => DIR_HTTP_ADMIN.ADMIN_FILE_COUNTRIES.'?action=delete&country_id='.$cnt['country_id'],
                'icon' => 'far fa-trash-alt',
                'class' => 'label-danger ajax delete',
                'compact_class' => 'btn-danger ajax delete',
            );
            $rec[] = draw_action_menu($action_buttons);
            $countires[] = $rec;
        }
    }
    $result = array(
        'data' => $countires,
        'recordsTotal' => $totalRec,
        'recordsFiltered' => $totalRec,
        'draw' => initRequestValue('draw'),
    );
    echo json_encode($result);
    exit;
}

$breadcrumbs[] = array(
    'title' => COMMON_COUNTRIES,
    'active' => false,
    'route' => DIR_HTTP_ADMIN.ADMIN_FILE_COUNTRIES
);

$breadcrumbs[] = array(
    'title' => COMMON_COUNTRIES,
    'active' => true
);

$action_buttons = array();
$action_buttons[COMMON_IMPORT_COUNTRY] = array(
    'class' => 'btn btn-grey',
    'link' => 'import-service',
    'icon' => 'fa fa-upload',
);
$action_buttons[COMMON_ADD_COUNTRY] = array(
    'class' => 'btn btn-success',
    'link' => DIR_HTTP_ADMIN.ADMIN_FILE_COUNTRY_EDIT,
    'icon' => 'fa fa-plus',
);

require_once(ADMIN_FILE_MAIN_INTERFACE);