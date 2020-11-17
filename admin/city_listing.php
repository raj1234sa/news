<?php

require_once("../lib/common.php");
require_once(DIR_WS_MODEL."CityMaster.php");

$dataCity = new CityData();
$objCityMaster = new CityMaster();

$pageTitle = COMMON_CITIES;

$listing_data = initPostValue('listing_data');
$export = initRequestValue('export');
$action = initRequestValue('action');

if($action == 'change_status') {
    $status_code = initPostValue('status_code');
    $status = initPostValue('status');
    $id = initPostValue('id');
    if($status_code == 'status') {
        $dataCity->status = ($status == '1') ? '1' : '0';
        $dataCity->city_id = $id;
        $objCityMaster->editCity($dataCity);
        echo 'success';
    }
    exit;
}

if($action == 'delete') {
    $id = initGetValue('city_id');
    if(!empty($id)) {
        $objCityMaster->deleteCity($id);
        echo 'success';
    } else {
        echo 'Cannot delete record.';
    }
    exit;
}

if($is_ajax_request && ($listing_data || $export)) {
    $search = extract_search_fields();

    $fieldArr = array(
        "state.state_name",
        "country.country_name",
        "city.*",
    );
    $objCityMaster->setLimit($search['start'], $search['length']);
    $objCityMaster->setOrderBy($objCityMaster->fieldArr[$search['column']].' '.$search['dir']);
    $objCityMaster->setSelect($fieldArr);

    if($export) {
        $objCityMaster->setSelect("IF(state.status = '1', 'Enabled', 'Disabled') as status");
    }
    $objCityMaster->setJoin("LEFT JOIN country ON country.country_id = city.country_id");
    $objCityMaster->setJoin("LEFT JOIN state ON state.state_id = city.state_id");

    $objCityMaster->setFoundRows();
    $cityDetails = $objCityMaster->getCity();

    if($export) {
        $cityDetails = objectToArray($cityDetails);
        $export_structure = array();
        $export_structure[] = array('city_id'=>array('name'=>'city_id', 'title'=>COMMON_ID));
        $export_structure[] = array('city_name'=>array('name'=>'city_name', 'title'=>COMMON_STATE_NAME));
        $export_structure[] = array('state_name'=>array('name'=>'state_name', 'title'=>COMMON_STATE_NAME));
        $export_structure[] = array('country_name'=>array('name'=>'country_name', 'title'=>COMMON_COUNTRY_NAME));
        $export_structure[] = array('status'=>array('name'=>'status', 'title'=>COMMON_STATUS));

        $sheetTitle = "City Report";
        $headerDate = "All";
        $spreadsheet = export_file_generate($export_structure, $cityDetails);
        echo json_encode(export_report($spreadsheet, 'export_city.xlsx'));
        exit;
    }

    $cities = array();
    $totalRec = 0;
    if(!empty($cityDetails)) {
        $totalRec = $cityDetails->FoundRows();
        $sr = $search['start'] + 1;
        foreach ($cityDetails as $state) {
            $rec = array();
            $rec['DT_RowId'] = "city:".$state['city_id'];
            $rec[] = $sr++;
            $rec[] = $state['city_name'];
            $rec[] = $state['state_name'];
            $rec[] = $state['country_name'];
            $rec[] = form_switchbutton('status', $state['status'], array('class'=>'ajax change_status'));
            $action_buttons = array();
            $action_buttons[COMMON_EDIT] = array(
                'link' => DIR_HTTP_ADMIN.ADMIN_FILE_CITY_EDIT.'?city_id='.$state['city_id'],
                'icon' => 'far fa-edit',
            );
            $action_buttons[COMMON_DELETE] = array(
                'link' => DIR_HTTP_ADMIN.ADMIN_FILE_CITIES.'?action=delete&city_id='.$state['city_id'],
                'icon' => 'far fa-trash-alt',
                'class' => 'label-danger ajax delete',
                'compact_class' => 'btn-danger ajax delete',
            );
            $rec[] = draw_action_menu($action_buttons);
            $cities[] = $rec;
        }
    }
    $result = array(
        'data' => $cities,
        'recordsTotal' => $totalRec,
        'recordsFiltered' => $totalRec,
        'draw' => initRequestValue('draw'),
    );
    echo json_encode($result);
    exit;
}

$breadcrumbs[] = array(
    'title' => COMMON_CITIES,
    'active' => true
);

$action_buttons = array();
$action_buttons[COMMON_IMPORT_CITY] = array(
    'class' => 'btn btn-grey',
    'link' => 'import-service',
    'icon' => 'fa fa-upload',
);
$action_buttons[COMMON_ADD_CITY] = array(
    'class' => 'btn btn-success',
    'link' => DIR_HTTP_ADMIN.ADMIN_FILE_CITY_EDIT,
    'icon' => 'fa fa-plus',
);

require_once(ADMIN_FILE_MAIN_INTERFACE);