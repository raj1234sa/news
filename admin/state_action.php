<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."CountryMaster.php");
require_once(DIR_WS_MODEL."StateMaster.php");

$dataState = new StateData();
$objStateMaster = new StateMaster();
$objCountryMaster = new CountryMaster();

$submit = initPostValue('submit_btn');
$state_id = initGetValue('state_id');

$pageTitle = empty($state_id) ? COMMON_ADD_STATE : COMMON_EDIT_STATE;

if(!empty($submit)) {
    $state_name = initPostValue('state_name');
    $status = initPostValue('status');
    $country_id = initPostValue('country_id');

    $dataState->state_name = $state_name;
    $dataState->status = empty($status) ? '0' : '1';
    $dataState->country_id = $country_id;
    if(!empty($state_id)) {
        $dataState->state_id = $state_id;
        if($objStateMaster->editState($dataState)) {
            set_flash_message(RECORD_UPDATE_SUCCESS, 'success');
            $insertId = $state_id;
        } else {
            set_flash_message(RECORD_UPDATE_ERROR, 'fail');
        }
    } else {
        $insertId = $objStateMaster->addState($dataState);
        if($insertId > 0) {
            set_flash_message(RECORD_ADD_SUCCESS, 'success');
        } else {
            set_flash_message(RECORD_ADD_ERROR, 'fail');
        }
    }

    if($submit == COMMON_SAVE) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_STATE_EDIT.'?state_id='.$insertId);
    } elseif ($submit == COMMON_SAVE_AND_BACK) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_STATES);
    }
}

if(!empty($state_id)) {
    $form_data = $objStateMaster->getState($state_id);
    if(empty($form_data)) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_STATES);
    }
    $form_data = $form_data[0];
}

$countryList = $objCountryMaster->getCountry();
$countryList = objectToArray($countryList);

$breadcrumbs[] = array(
    'title' => COMMON_ADD_STATE,
    'active' => true
);

require_once(ADMIN_FILE_MAIN_INTERFACE);