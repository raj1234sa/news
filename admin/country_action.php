<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."CountryMaster.php");

$dataCountry = new CountryData();
$objCountryMaster = new CountryMaster();

$submit = initPostValue('submit_btn');
$country_id = initGetValue('country_id');

$pageTitle = empty($country_id) ? COMMON_ADD_COUNTRY : COMMON_EDIT_COUNTRY;

if(!empty($submit)) {
    $country_name = initPostValue('country_name');
    $status = initPostValue('status');

    $dataCountry->country_name = $country_name;
    $dataCountry->status = empty($status) ? '0' : '1';
    if(!empty($country_id)) {
        $dataCountry->country_id = $country_id;
        if($objCountryMaster->editCountry($dataCountry)) {
            set_flash_message(RECORD_UPDATE_SUCCESS, 'success');
            $insertId = $country_id;
        } else {
            set_flash_message(RECORD_UPDATE_ERROR, 'fail');
        }
    } else {
        $insertId = $objCountryMaster->addCountry($dataCountry);
        if($insertId > 0) {
            set_flash_message(RECORD_ADD_SUCCESS, 'success');
        } else {
            set_flash_message(RECORD_ADD_ERROR, 'fail');
        }
    }

    if($submit == COMMON_SAVE) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_COUNTRY_EDIT.'?country_id='.$insertId);
    } elseif ($submit == COMMON_SAVE_AND_BACK) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_COUNTRIES);
    }
}

if(!empty($country_id)) {
    $form_data = $objCountryMaster->getCountry($country_id);
    if(empty($form_data)) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_COUNTRIES);
    }
    $form_data = $form_data[0];
}

$breadcrumbs[] = array(
    'title' => COMMON_ADD_COUNTRY,
    'active' => true
);

require_once(ADMIN_FILE_MAIN_INTERFACE);