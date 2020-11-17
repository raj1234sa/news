<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."CountryMaster.php");
require_once(DIR_WS_MODEL."CityMaster.php");
require_once(DIR_WS_MODEL."StateMaster.php");
require_once(DIR_WS_MODEL."IndustryMaster.php");
require_once(DIR_WS_MODEL."NewsMaster.php");

$objCityMaster = new CityMaster();
$objCountryMaster = new CountryMaster();
$objStateMaster = new StateMaster();
$objIndustryMaster = new IndustryMaster();
$dataNews = new NewsData();
$objNewsMaster = new NewsMaster();

$submit = initPostValue('submit_btn');
$news_id = initGetValue('news_id');
$action = initRequestValue('action');

$pageTitle = empty($news_id) ? COMMON_ADD_NEWS : COMMON_EDIT_NEWS;

if($action == "get_country_states") {
    $cnt_id = initPostValue('cid');
    $selected_state = initPostValue('selected_state');
    $objStateMaster->setWhere("AND country_id = :country_id", $cnt_id, 'int');
    $stateList = $objStateMaster->getState();

    $html = draw_options($stateList, 'state_id', 'state_name', $selected_state, "<option value=''>Select State</option>");
    echo $html;
    exit;
}

if($action == "get_state_cities") {
    $st_id = initPostValue('sid');
    $selected_city = initPostValue('selected_city');
    $objCityMaster->setWhere("AND state_id = :state_id", $st_id, 'int');
    $cityList = $objCityMaster->getCity();

    $html = draw_options($cityList, 'city_id', 'city_name', $selected_city, "<option value=''>Select City</option>");
    echo $html;
    exit;
}

if(!empty($submit)) {
    $news_title = initPostValue('news_title');
    $industry_id = initPostValue('industry_id');
    $short_desc = initPostValue('short_desc');
    $long_desc = initPostValue('long_desc');
    $small_image = initFileValue('small_image');
    $large_image = initFileValue('large_image');
    $country_id = initPostValue('country_id');
    $state_id = initPostValue('state_id');
    $city_id = initPostValue('city_id');
    $news_date = initPostValue('news_date');
    $status = initPostValue('status');

    $dataNews->news_title = $news_title;
    $dataNews->industry_id = $industry_id;
    $dataNews->short_desc = $short_desc;
    $dataNews->long_desc = $long_desc;
    $dataNews->country_id = $country_id;
    $dataNews->state_id = $state_id;
    $dataNews->city_id = $city_id;
    $dataNews->news_date = date('Y-m-d H:i:s', strtotime($news_date));
    $dataNews->status = empty($status) ? '0' : '1';
    if(!empty($news_id)) {
        $dataNews->news_id = $news_id;
        if(!empty($small_image)) {
            $dataNews->small_image = $small_image;
        }
        if(!empty($large_image)) {
            $dataNews->large_image = $large_image;
        }
        if($objNewsMaster->editNews($dataNews)) {
            set_flash_message(RECORD_UPDATE_SUCCESS, 'success');
            $insertId = $news_id;
        } else {
            set_flash_message(RECORD_UPDATE_ERROR, 'fail');
        }
    } else {
        $dataNews->small_image = $small_image;
        $dataNews->large_image = $large_image;
        $insertId = $objNewsMaster->addNews($dataNews);
        if($insertId > 0) {
            set_flash_message(RECORD_ADD_SUCCESS, 'success');
        } else {
            set_flash_message(RECORD_ADD_ERROR, 'fail');
        }
    }
    uploadFiles(DIR_WS_IMAGES_NEWS.$insertId, 'small_image');
    uploadFiles(DIR_WS_IMAGES_NEWS.$insertId, 'large_image');

    if($submit == COMMON_SAVE) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_NEWS_EDIT.'?news_id='.$insertId);
    } elseif ($submit == COMMON_SAVE_AND_BACK) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_NEWS);
    }
}

if(!empty($news_id)) {
    $form_data = $objNewsMaster->getNews($news_id);
    if(empty($form_data)) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_NEWS);
    }
    $form_data = $form_data[0];
}

$countryList = $objCountryMaster->getCountry();
$countryList = objectToArray($countryList);

$industryList = $objIndustryMaster->getIndustry();
$industryList = objectToArray($industryList);

$breadcrumbs[] = array(
    'title' => COMMON_NEWS,
    'active' => false,
    'route' => DIR_HTTP_ADMIN.ADMIN_FILE_NEWS
);

$breadcrumbs[] = array(
    'title' => COMMON_ADD_NEWS,
    'active' => true
);

require_once(ADMIN_FILE_MAIN_INTERFACE);