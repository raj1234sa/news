<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."CountryMaster.php");
require_once(DIR_WS_MODEL."CityMaster.php");
require_once(DIR_WS_MODEL."StateMaster.php");

$dataCity = new CityData();
$objCityMaster = new CityMaster();
$objCountryMaster = new CountryMaster();
$objStateMaster = new StateMaster();

$submit = initPostValue('submit_btn');
$city_id = initGetValue('city_id');
$action = initRequestValue('action');

$pageTitle = empty($city_id) ? COMMON_ADD_CITY : COMMON_EDIT_CITY;

if($action == "get_country_states") {
    $cnt_id = initPostValue('cid');
    $selected_state = initPostValue('selected_state');
    $objStateMaster->setWhere("AND country_id = :country_id", $cnt_id, 'int');
    $stateList = $objStateMaster->getState();

    $html = draw_options($stateList, 'state_id', 'state_name', $selected_state, "<option value=''>Select State</option>");
    echo $html;
    exit;
}

if(!empty($submit)) {
    $city_name = initPostValue('city_name');
    $status = initPostValue('status');
    $country_id = initPostValue('country_id');
    $state_id = initPostValue('state_id');

    $dataCity->city_name = $city_name;
    $dataCity->status = empty($status) ? '0' : '1';
    $dataCity->country_id = $country_id;
    $dataCity->state_id = $state_id;
    if(!empty($city_id)) {
        $dataCity->city_id = $city_id;
        if($objCityMaster->editCity($dataCity)) {
            set_flash_message(RECORD_UPDATE_SUCCESS, 'success');
            $insertId = $city_id;
        } else {
            set_flash_message(RECORD_UPDATE_ERROR, 'fail');
        }
    } else {
        $insertId = $objCityMaster->addCity($dataCity);
        if($insertId > 0) {
            set_flash_message(RECORD_ADD_SUCCESS, 'success');
        } else {
            set_flash_message(RECORD_ADD_ERROR, 'fail');
        }
    }

    if($submit == COMMON_SAVE) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_CITY_EDIT.'?city_id='.$insertId);
    } elseif ($submit == COMMON_SAVE_AND_BACK) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_CITIES);
    }
}

if(!empty($city_id)) {
    $form_data = $objCityMaster->getCity($city_id);
    if(empty($form_data)) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_CITIES);
    }
    $form_data = $form_data[0];
}

$countryList = $objCountryMaster->getCountry();
$countryList = objectToArray($countryList);

$breadcrumbs[] = array(
    'title' => COMMON_CITIES,
    'active' => false,
    'route' => DIR_HTTP_ADMIN.ADMIN_FILE_CITIES
);

$breadcrumbs[] = array(
    'title' => COMMON_ADD_CITY,
    'active' => true
);

require_once(ADMIN_FILE_MAIN_INTERFACE);