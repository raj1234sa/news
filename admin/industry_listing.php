<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL.'IndustryMaster.php');

$objIndustryMaster = new IndustryMaster();
$dataIndustry = new IndustryData();

$pageTitle = COMMON_INDUSTRY;

$listing_data = initPostValue('listing_data');
$export = initRequestValue('export');
$action = initRequestValue('action');

if($action == 'change_status') {
    $status_code = initPostValue('status_code');
    $status = initPostValue('status');
    $id = initPostValue('id');
    if($status_code == 'status') {
        $dataIndustry->status = ($status == '1') ? '1' : '0';
        $dataIndustry->industry_id = $id;
        $objIndustryMaster->editIndustry($dataIndustry);
    }
    echo 'success';
    exit;
}

if($action == 'delete') {
    $id = initGetValue('industry_id');
    if(!empty($id)) {
        $objIndustryMaster->deleteIndustry($id);
        echo 'success';
    } else {
        echo 'Cannot delete record.';
    }
    exit;
}

if($is_ajax_request && ($listing_data || $export)) {
    $search = extract_search_fields();
    $objIndustryMaster->setLimit($search['start'], $search['length']);
    $objIndustryMaster->setOrderBy($objIndustryMaster->fieldArr[$search['column']].' '.$search['dir']);

    if($export) {
        $objIndustryMaster->setSelect("*, IF(industry.status = '1', 'Enabled', 'Disabled') as status");
    }

    $objIndustryMaster->setFoundRows();
    $industryDetails = $objIndustryMaster->getIndustry();

    if($export) {
        $industryDetails = objectToArray($industryDetails);
        $export_structure = array();
        $export_structure[] = array('industry_id'=>array('name'=>'industry_id', 'title'=>COMMON_ID));
        $export_structure[] = array('industry_name'=>array('name'=>'industry_name', 'title'=>COMMON_INDUSTRY_NAME));
        $export_structure[] = array('sort_order'=>array('name'=>'sort_order', 'title'=>COMMON_SORT_ORDER));
        $export_structure[] = array('status'=>array('name'=>'status', 'title'=>COMMON_STATUS));
        $export_structure[] = array('created_date'=>array('name'=>'created_date', 'title'=>COMMON_CREATED_DATE));
        $export_structure[] = array('updated_date'=>array('name'=>'updated_date', 'title'=>COMMON_UPDATED_DATE));

        $sheetTitle = "Industry Report";
        $headerDate = "All";
        $spreadsheet = export_file_generate($export_structure, $industryDetails);
        echo json_encode(export_report($spreadsheet, 'export_industry.xlsx'));
        exit;
    }

    $industries = array();
    $totalRec = 0;
    if(!empty($industryDetails)) {
        $sr = $search['start'] + 1;
        foreach ($industryDetails as $indus) {
            $rec = array();
            $rec['DT_RowId'] = "industry:".$indus['industry_id'];
            $rec[] = $sr++;
            $rec[] = $indus['industry_name'];
            $rec[] = $indus['sort_order'];
            $rec[] = form_switchbutton('status', $indus['status'], array('class'=>'ajax change_status'));
            $rec[] = $indus['created_date'];
            $rec[] = $indus['updated_date'];
            $action_buttons = array();
            $action_buttons[COMMON_EDIT] = array(
                'link' => DIR_HTTP_ADMIN.ADMIN_FILE_INDUSTRY_EDIT.'?industry_id='.$indus['industry_id'],
                'icon' => 'far fa-edit',
            );
            $action_buttons[COMMON_DELETE] = array(
                'link' => DIR_HTTP_ADMIN.ADMIN_FILE_INDUSTRIES.'?action=delete&industry_id='.$indus['industry_id'],
                'icon' => 'far fa-trash-alt',
                'class' => 'label-danger ajax delete',
                'compact_class' => 'btn-danger ajax delete',
            );
            $rec[] = draw_action_menu($action_buttons);
            $industries[] = $rec;
        }
    }
    $totalRec = $industryDetails->FoundRows();
    $result = array(
        'data' => $industries,
        'recordsTotal' => $totalRec,
        'recordsFiltered' => $totalRec,
        'draw' => initRequestValue('draw'),
    );
    echo json_encode($result);
    exit;
}

$breadcrumbs[] = array(
    'title' => COMMON_INDUSTRY,
    'active' => true
);

$action_buttons = array();
$action_buttons[COMMON_IMPORT_INDUSTRY] = array(
    'class' => 'btn btn-grey',
    'link' => 'import-service',
    'icon' => 'fa fa-upload',
);
$action_buttons[COMMON_ADD_INDUSTRY] = array(
    'class' => 'btn btn-success',
    'link' => DIR_HTTP_ADMIN.ADMIN_FILE_INDUSTRY_EDIT,
    'icon' => 'fa fa-plus',
);

require_once(ADMIN_FILE_MAIN_INTERFACE);

?>