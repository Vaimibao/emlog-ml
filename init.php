<?php

/**
 * init.
 * @package EMLOG
 * @link https://www.emlog.net
 */

if (!isset($_SESSION)) {
    session_start();
}
ob_start();
header('Content-Type: text/html; charset=UTF-8');

const EMLOG_ROOT = __DIR__;

require_once EMLOG_ROOT . '/config.php';
require_once EMLOG_ROOT . '/include/lib/common.php';

//Set Interface language
$url = $_SERVER['REQUEST_URI'];
if (isset($_GET['language'])) {
    $url = removeParam('language', $url);
    $_SESSION['LANG'] = $_GET['language'];
    emDirect($url);
}

if (empty($_SESSION['LANG'])) {
    $_SESSION['LANG'] = DEFAULT_LANG;
}
define('LANG', $_SESSION['LANG']);

spl_autoload_register("emAutoload");

if (Util::isDevEnv()) {
    error_reporting(E_ALL);
} else {
    error_reporting(1);
}

if (extension_loaded('mbstring')) {
    mb_internal_encoding('UTF-8');
}

//Blog language direction
const LANG_DIR = LANG_LIST[LANG]['dir'];

//Load the core Lang File
load_language('core');

$CACHE = Cache::getInstance();

$userData = [];

define('ISLOGIN', LoginAuth::isLogin());
date_default_timezone_set(Option::get('timezone'));

const ROLE_ADMIN = 'admin';
const ROLE_EDITOR = 'editor';
const ROLE_WRITER = 'writer';
const ROLE_VISITOR = 'visitor';

define('ROLE', ISLOGIN === true ? $userData['role'] : User::ROLE_VISITOR);
define('UID', ISLOGIN === true ? (int)$userData['uid'] : 0);

//Site address
define('BLOG_URL', Option::get('blogurl'));

//Templates Library URL
const TPLS_URL = BLOG_URL . 'content/templates/';

//Templates Library Path
const TPLS_PATH = EMLOG_ROOT . '/content/templates/';

//Plugins Library URL
const PLUGIN_URL = BLOG_URL . 'content/plugins/';

//Plugins Library Path
const PLUGIN_PATH = EMLOG_ROOT . '/content/plugins/';

//Resolve the front domain for ajax
define('DYNAMIC_BLOGURL', Option::get('blogurl'));

//Front template URL
define('TEMPLATE_URL', TPLS_URL . Option::get('nonce_templet') . '/');

//Admin Template Path
define('ADMIN_TEMPLATE_PATH', EMLOG_ROOT . '/admin/views/');

//Front template Path
define('TEMPLATE_PATH', TPLS_PATH . Option::get('nonce_templet') . '/');

//Error code
const MSGCODE_EMKEY_INVALID = 1001;
const MSGCODE_NO_UPUPDATE = 1002;
const MSGCODE_SUCCESS = 200;

$active_plugins = Option::get('active_plugins');
$emHooks = [];
if ($active_plugins && is_array($active_plugins)) {
    foreach ($active_plugins as $plugin) {
        if (true === checkPlugin($plugin)) {
            include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
        }
    }
}

//The system call file for loading templates
define('TEMPLATE_HOOK_PATH', TEMPLATE_PATH . 'plugins.php');
if (file_exists(TEMPLATE_HOOK_PATH)) {
    include_once(TEMPLATE_HOOK_PATH);
}

User::updateUserActivity();
