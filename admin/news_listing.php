<?php

require_once("../lib/common.php");
require_once(DIR_WS_MODEL."StateMaster.php");

$dataState = new StateData();
$objStateMaster = new StateMaster();

$pageTitle = COMMON_NEWS;

$listing_data = initPostValue('listing_data');
$export = initRequestValue('export');
$action = initRequestValue('action');

if($action == 'change_status') {
    $status_code = initPostValue('status_code');
    $status = initPostValue('status');
    $id = initPostValue('id');
    if($status_code == 'status') {
        $dataState->status = ($status == '1') ? '1' : '0';
        $dataState->state_id = $id;
        $objStateMaster->editState($dataState);
        echo 'success';
    }
    exit;
}

if($action == 'delete') {
    $id = initGetValue('state_id');
    if(!empty($id)) {
        $objStateMaster->deleteState($id);
        echo 'success';
    } else {
        echo 'Cannot delete record.';
    }
    exit;
}

if($is_ajax_request && ($listing_data || $export)) {
    $search = extract_search_fields();

    $fieldArr = array(
        "state.*",
        "country.country_name",
    );
    $objStateMaster->setLimit($search['start'], $search['length']);
    $objStateMaster->setOrderBy($objStateMaster->fieldArr[$search['column']].' '.$search['dir']);
    $objStateMaster->setSelect($fieldArr);

    if($export) {
        $objStateMaster->setSelect("IF(state.status = '1', 'Enabled', 'Disabled') as status");
    }
    $objStateMaster->setJoin("LEFT JOIN country ON country.country_id = state.country_id");

    $objStateMaster->setFoundRows();
    $stateDetails = $objStateMaster->getState();

    if($export) {
        $stateDetails = objectToArray($stateDetails);
        $export_structure = array();
        $export_structure[] = array('state_id'=>array('name'=>'state_id', 'title'=>COMMON_ID));
        $export_structure[] = array('state_name'=>array('name'=>'state_name', 'title'=>COMMON_STATE_NAME));
        $export_structure[] = array('country_name'=>array('name'=>'country_name', 'title'=>COMMON_COUNTRY_NAME));
        $export_structure[] = array('status'=>array('name'=>'status', 'title'=>COMMON_STATUS));

        $sheetTitle = "State Report";
        $headerDate = "All";
        $spreadsheet = export_file_generate($export_structure, $stateDetails);
        echo json_encode(export_report($spreadsheet, 'export_state.xlsx'));
        exit;
    }

    $states = array();
    $totalRec = 0;
    if(!empty($stateDetails)) {
        $totalRec = $stateDetails->FoundRows();
        $sr = $search['start'] + 1;
        foreach ($stateDetails as $state) {
            $rec = array();
            $rec['DT_RowId'] = "state:".$state['state_id'];
            $rec[] = $sr++;
            $rec[] = $state['state_name'];
            $rec[] = $state['country_name'];
            $rec[] = form_switchbutton('status', $state['status'], array('class'=>'ajax change_status'));
            $action_buttons = array();
            $action_buttons[COMMON_EDIT] = array(
                'link' => DIR_HTTP_ADMIN.ADMIN_FILE_STATE_EDIT.'?state_id='.$state['state_id'],
                'icon' => 'far fa-edit',
            );
            $action_buttons[COMMON_DELETE] = array(
                'link' => DIR_HTTP_ADMIN.ADMIN_FILE_STATES.'?action=delete&state_id='.$state['state_id'],
                'icon' => 'far fa-trash-alt',
                'class' => 'label-danger ajax delete',
                'compact_class' => 'btn-danger ajax delete',
            );
            $rec[] = draw_action_menu($action_buttons);
            $states[] = $rec;
        }
    }
    $result = array(
        'data' => $states,
        'recordsTotal' => $totalRec,
        'recordsFiltered' => $totalRec,
        'draw' => initRequestValue('draw'),
    );
    echo json_encode($result);
    exit;
}

$breadcrumbs[] = array(
    'title' => COMMON_NEWS,
    'active' => true
);

$action_buttons = array();
$action_buttons[COMMON_IMPORT_NEWS] = array(
    'class' => 'btn btn-grey',
    'link' => 'import-service',
    'icon' => 'fa fa-upload',
);
$action_buttons[COMMON_ADD_NEWS] = array(
    'class' => 'btn btn-success',
    'link' => DIR_HTTP_ADMIN.ADMIN_FILE_NEWS_EDIT,
    'icon' => 'fa fa-plus',
);

require_once(ADMIN_FILE_MAIN_INTERFACE);