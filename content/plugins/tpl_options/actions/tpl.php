<?php
/*
 * Author: Vaimibao
 * Description: Template options plugin AJAX processing.
*/

require_once '../../../../init.php';

load_language('plugins/tpl_options');

if (!User::isAdmin()) {
    echo lang('no_permission');
    exit;
}

//AJAX action
$action = Input::postStrVar('action', '');
if (!isset($action)) {
    echo lang('operation_failed');
    exit;
}

//Handling AJAX requests
if ($action === 'tpl_upload') {
    $origin_image = Input::postStrVar('origin_image', '');
    $ret = uploadCropImg();
    $file_path = $ret['file_info']['file_path'];
    $abs_file_path = '';
    $abs_file_path = strstr($file_path, 'content/uploadfile/');
    if ($abs_file_path === false) {
        echo '{"code":"error","data":"'. lang('upload_error') .'"}';
        exit;
    }
    $abs_file_path = BLOG_URL . $abs_file_path;

    //Delete old image
    if (!empty(trim($origin_image)) && strpos($origin_image, 'uploadfile') !== false) {
        $path = '../../../../' . str_replace(BLOG_URL, '', $origin_image);
        if (file_exists($path)) {
            unlink($path);
        }
    }

    if (empty($ret['success'])) {
        echo '{"code":"error","data":"' . $ret['message'] . '"}';
        exit;
    }

    if ($file_path) {
        echo '{"code":"success","data":"' . $abs_file_path . '"}';
        exit;
    }
}