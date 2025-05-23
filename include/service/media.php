<?php

/**
 * Service: Media
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Media
{

    static function checkUpload($attach)
    {
        if (!$attach) {
            return lang('media_upload_failed');
        }
        $fileName = $attach['name'];
        $errorNum = $attach['error'];
        $fileSize = $attach['size'];
        $extension = getFileSuffix($fileName);

        if ($errorNum == 1) {
            return lang('file_size_exceeds') . ini_get('upload_max_filesize') . lang('file_size_limit');
        }

        if ($errorNum > 1) {
            return lang('upload_failed_error_code') . $errorNum;
        }

        // 检查类型和大小限制
        $attType = User::haveEditPermission() ? Option::getAdminAttType() : Option::getAttType();
        $maxSize = User::haveEditPermission() ? Option::getAdminAttMaxSize() : Option::getAttMaxSize();
        if (!in_array($extension, $attType)) {
            return lang('file_cannot_be_uploaded');
        }
        if ($fileSize > $maxSize) {
            return lang('file_is_too_large') . changeFileSize($maxSize);
        }
        return true;
    }

    static function uploadRespond($ret, $isEditor, $isSuccess = false)
    {
        if ($isEditor) {
            exit(json_encode($ret));
        } else {
            if ($isSuccess) {
                header("HTTP/1.0 200 OK");
                exit($ret['message']);
            }
            header("HTTP/1.0 400 Bad Request");
            exit($ret['message']);
        }
    }
}
