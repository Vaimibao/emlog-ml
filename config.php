<?php
header("location: ./install.php");
exit;
//MySQL database host
const DB_HOST = 'localhost';
//MySQL database username
const DB_USER = 'root';
//MySQL database user password
const DB_PASSWD = '';
//Database name
const DB_NAME = 'emlog';
//Database table prefix
const DB_PREFIX = 'emlog_';
//Auth key
const AUTH_KEY = 'emlog-key';
//Cookie name
const AUTH_COOKIE_NAME = 'emlog-cookie';
// Default blog language
const DEFAULT_LANG = 'en'; //'en', 'ru', 'zh-CN', 'zh-TW', 'pt-BR', etc.
// Enabled language list
const LANG_LIST = [
    'zh-CN' => [
        'name'=>'简体中文',
        'title'=>'Simplified Chinese',
        'dir' => 'ltr',
    ],
    'en' => [
        'name'=>'English',
        'title'=>'English',
        'dir' => 'ltr',
    ],
];
