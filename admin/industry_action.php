<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL.'IndustryMaster.php');

$objIndustryMaster = new IndustryMaster();
$dataIndustry = new IndustryData();

$submit = initPostValue('submit_btn');
$industry_id = initGetValue('industry_id');

$pageTitle = empty($industry_id) ? COMMON_ADD_INDUSTRY : COMMON_EDIT_INDUSTRY;

if(!empty($submit)) {
    $industry_name = initPostValue('industry_name');
    $sort_order = initPostValue('sort_order');
    $status = initPostValue('status');

    $validation = array();
    $validation['industry_name'] = empty($industry_name) ? THIS_FIELD_IS_REQUIRED : '';

    $objIndustryMaster->setWhere("AND industry_name = :industry_name", $industry_name, 'string');
    $oldIndustryData = $objIndustryMaster->getIndustry();
    if(!empty($oldIndustryData)) {
        $validation['industry_name'] = THIS_FIELD_IS_UNIQUE;
    }
    $form_data['industry_name'] = $industry_name;
    $form_data['sort_order'] = $sort_order;
    $form_data['status'] = $status;

    $Svalidation = true;
    foreach ($validation as $value) {
        if(!empty($value)) {
            $Svalidation = false;
            break;
        }
    }

    if($Svalidation) {
        $dataIndustry->industry_name = $industry_name;
        $dataIndustry->sort_order = $sort_order;
        $dataIndustry->status = empty($status) ? '0' : '1';
        if(!empty($industry_id)) {
            $dataIndustry->industry_id = $industry_id;
            if($objIndustryMaster->editIndustry($dataIndustry)) {
                set_flash_message(RECORD_UPDATE_SUCCESS, 'success');
                $insertId = $industry_id;
            } else {
                set_flash_message(RECORD_UPDATE_ERROR, 'fail');
            }
        } else {
            $insertId = $objIndustryMaster->addIndustry($dataIndustry);
            if($insertId > 0) {
                set_flash_message(RECORD_ADD_SUCCESS, 'success');
            } else {
                set_flash_message(RECORD_ADD_ERROR, 'fail');
            }
        }

        if($submit == COMMON_SAVE) {
            show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_INDUSTRY_EDIT.'?industry_id='.$insertId);
        } elseif ($submit == COMMON_SAVE_AND_BACK) {
            show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_INDUSTRIES);
        }
    }
}

if(!empty($industry_id)) {
    $form_data = $objIndustryMaster->getIndustry($industry_id);
    if(empty($form_data)) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_INDUSTRIES);
    }
    $form_data = $form_data[0];
}

$breadcrumbs[] = array(
    'title' => COMMON_ADD_INDUSTRY,
    'active' => true
);

require_once(ADMIN_FILE_MAIN_INTERFACE);