<?php

/**
 * install
 * @package EMLOG
 * @link https://www.emlog.net
 */
if (!isset($_SESSION)) {
    session_start();
}

const EMLOG_ROOT = __DIR__;
const LANG_DIR = 'ltr';       //ltr, rtl
const LANG_LIST_INSTALL = [
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

require_once EMLOG_ROOT . '/include/lib/common.php';

//Set Interface language
$url = $_SERVER['REQUEST_URI'];
if (isset($_GET['language'])) {
    define('LANG', $_GET['language']);
    $url = removeParam('language', $url);
    $_SESSION['LANG'] = $_GET['language'];
    emDirect($url);
} else {
    if (empty($_SESSION['LANG'])) {
        define('LANG', 'en'); //zh-CN, en, ru, etc.
        $_SESSION['LANG'] = 'en';
    } else {
        define('LANG', $_SESSION['LANG']);
    }
}

load_language('install');
load_language('core');

header('Content-Type: text/html; charset=UTF-8');
spl_autoload_register("emAutoload");

if (PHP_VERSION < '5.6') {
    emMsg(lang('php_required'));
}

$act = Input::getStrVar('action');

$bt_db_host = 'localhost';
$bt_db_username = 'BT_DB_USERNAME';
$bt_db_password = 'BT_DB_PASSWORD';
$bt_db_name = 'BT_DB_NAME';

$env_emlog_env = getenv('EMLOG_ENV');
$env_db_host = getenv('EMLOG_DB_HOST');
$env_db_name = getenv('EMLOG_DB_NAME');
$env_db_user = getenv('EMLOG_DB_USER');
$env_db_password = getenv('EMLOG_DB_PASSWORD');

if (!$act) {
?>
    <!doctype html>
    <html dir="<?= LANG_DIR ?>" lang="<?= LANG ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="applicable-device" content="pc,mobile">
        <title>emlog</title>
        <style>
            body {
                background-color: #F7F7F7;
                font-family: Arial, sans-serif;
                font-size: 12px;
                line-height: 150%;
            }

            hr {
                margin: 1rem 0;
                color: inherit;
                border: 0;
                border-top: 1px solid;
                opacity: .25;
            }

            .mb10 {
                margin-bottom: 10px;
            }

            .mb20 {
                margin-bottom: 20px;
            }

            .main {
                position: relative;
                background-color: #FFFFFF;
                font-size: 12px;
                color: #666666;
                width: 750px;
                margin: 30px auto;
                padding: 50px;
                list-style: none;
                border: #DFDFDF 1px solid;
                border-radius: 4px;
            }

            .logo {
                background: url(admin/views/images/logo.png) no-repeat center;
                padding: 50px 0 50px 0;
                margin: 0 0;
            }

            .title {
                text-align: center;
                font-size: 14px;
            }

            .input-group {
                position: relative;
                display: flex;
                flex-wrap: wrap;
                align-items: stretch;
                width: 100%;
                margin-top: 30px;
            }

            .input-group-text {
                display: flex;
                align-items: center;
                padding: 0.375rem 0.75rem;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.5;
                color: #5e5e5e;
                text-align: center;
                white-space: nowrap;
                background-color: #fff;
                border: 1px solid #dee2e6;
                border-radius: 0.375rem 0 0 0.375rem;
                width: 80px;
            }

            .form-control {
                display: block;
                padding: 0.375rem 0.75rem;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.5;
                color: #5e5e5e;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #dee2e6;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                position: relative;
                flex: 1 1 auto;
                width: 1%;
                min-width: 0;
                border-radius: 0 0.375rem 0.375rem 0;
                margin-left: calc(1px * -1);
                transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            }

            .form-label {
                margin-bottom: 0.5rem;
            }

            .btn {
                cursor: pointer;
                color: #008cff;
                letter-spacing: .5px;
                padding-right: 3rem !important;
                padding-left: 3rem !important;
                display: inline-block;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                text-align: center;
                text-decoration: none;
                vertical-align: middle;
                user-select: none;
                border: 1px solid #008cff;
                border-radius: 5px;
                background-color: transparent;
                transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            }

            .btn:hover {
                color: #fff;
                background-color: #008cff;
                border-color: #008cff;
            }

            .care {
                color: rgb(128, 128, 128);
            }

            .install-title {
                margin-top: 50px;
                margin-bottom: 0;
                font-size: 18px;
                font-weight: normal;
            }

            .next_btn {
                margin: 50px 0 10px 0;
                text-align: center;
            }

            .footer {
                margin: 20px 0 30px 0;
                text-align: center;
            }

            @media (max-width: 768px) {
                .main {
                    width: unset;
                }
            }
            .dropdown {
                position: relative;
            }
            .dropdown-toggle {
                white-space: nowrap;
            }
            .language-box .nav-link {
                position: relative;
            }
            .language-box .nav-link {
                color: #4a4a4a;
                display: flex;
                align-items: center;
                padding: 10px;
                gap: 6px;
                border-radius: 8px;
                box-shadow: 0px 1px 6px 1px rgba(44, 44, 44, 0.1);
            }
            .dropdown-menu {
                position: absolute;
                width: auto;
                right: 0;
                z-index: 1000;
                float: left;
                min-width: fit-content;
                margin: 0.125rem 0 0;
                font-size: 0.85rem;
                text-align: left;
                list-style: none;
                opacity: 0;
                visibility: hidden;
                display: unset;
                transform: translateY(6px);
                transition: .4s;
                border-radius: 8px;
                box-shadow: 0px 1px 6px 1px rgba(44, 44, 44, 0.1);
                background: rgba(255, 255, 255, 0.9);
                will-change: transform;
                backdrop-filter: saturate(180%) blur(20px);
            }
            .dropdown-item {
                display: flex;
                gap: 6px;
                align-items: center;
                padding: 6px;
                clear: both;
                font-weight: 400;
                color: #3a3b45;
                text-align: inherit;
                white-space: nowrap;
                background-color: transparent;
                border: 0;
            }
            .dropdown:hover .dropdown-menu {
                opacity: 1;
                transform: translateY(0);
                visibility: unset;
            }
            .lang-flag {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                object-fit: cover;
                vertical-align: middle;
            }
            .language-box {
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .language-box a {
                font-size: 0.85rem;
                text-decoration: none;
                transition: all .2s;
            }
            .language-box a:hover {
                background: #f3f3f3;
                border-radius: 8px;
            }
        </style>
    </head>

    <body>
        <form name="form1" method="post" action="install.php?action=install">
            <div class="main">
                <p class="logo"></p>
                <p class="title mb20">emlog <?= Option::EMLOG_VERSION ?></p>
                <!-- Change Language -->
                <div class="language-box">
                    <div class="dropdown">
                        <span class="nav-link dropdown-toggle" data-toggle="dropdown"><span><img class="lang-flag" src="http://<?= $_SERVER['HTTP_HOST'] ?>/lang/<?= LANG ?>/flag.svg"></span><?= LANG_LIST_INSTALL[$_SESSION['LANG']]['name'] ?></span>
                        <div class="dropdown-menu"><!-- RIGHT -->
                            <?php
                            foreach(LANG_LIST_INSTALL as $l => $lng) {
                                $selected = ($_SESSION['LANG'] == $l) ? 'selected="selected"' : '';
                                ?>
                                <a class="dropdown-item flex alc gap6" href="?language=<?= $l ?>" title="<?= LANG_LIST_INSTALL[$l]['title'] ?>"><img class="lang-flag" src="http://<?= $_SERVER['HTTP_HOST'] ?>/lang/<?= $l ?>/flag.svg"> <?= LANG_LIST_INSTALL[$l]['name'] ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php if ($env_db_user): ?>
                    <div class="b">
                        <input name="hostname" type="hidden" value="<?= $env_db_host ?>">
                        <input name="dbuser" type="hidden" value="<?= $env_db_user ?>">
                        <input name="dbpasswd" type="hidden" value="<?= $env_db_password ?>">
                        <input name="dbname" type="hidden" value="<?= $env_db_name ?>">
                        <input name="dbprefix" type="hidden" value="emlog_">
                    </div>
                <?php elseif (strpos($bt_db_username, 'BT_DB_') === false): ?>
                    <div class="b">
                        <input name="hostname" type="hidden" value="<?= $bt_db_host ?>">
                        <input name="dbuser" type="hidden" value="<?= $bt_db_username ?>">
                        <input name="dbpasswd" type="hidden" value="<?= $bt_db_password ?>">
                        <input name="dbname" type="hidden" value="<?= $bt_db_name ?>">
                        <input name="dbprefix" type="hidden" value="emlog_">
                    </div>
                <?php else: ?>
                    <div class="b mb20">
                        <p class="install-title"><?= lang('mysql_settings') ?></p>
                        <div class="input-group mb10">
                            <label class="input-group-text"><?= lang('db_hostname') ?></label>
                            <input name="hostname" type="text" class="form-control" value="localhost" required>
                        </div>
                        <div class="mb10">
                            <label class="form-label care"><?= lang('db_hostname_info') ?></label>
                        </div>
                        <div class="input-group mb10">
                            <span class="input-group-text"><?= lang('db_user') ?></span>
                            <input name="dbuser" type="text" class="form-control" value="" required>
                        </div>
                        <div class="input-group mb10">
                            <span class="input-group-text"><?= lang('db_password') ?></span>
                            <input name="dbpasswd" type="password" class="form-control" value="">
                        </div>
                        <div class="input-group mb10">
                            <span class="input-group-text"><?= lang('db_name') ?></span>
                            <input name="dbname" type="text" class="form-control" value="" required>
                        </div>
                        <div class="mb10">
                            <label class="form-label care"><?= lang('db_name_info') ?></label>
                        </div>
                        <div class="input-group mb10">
                            <span class="input-group-text"><?= lang('db_prefix') ?></span>
                            <input name="dbprefix" type="text" class="form-control" value="emlog_">
                        </div>
                        <div class="mb10">
                            <label class="form-label care"><?= lang('db_prefix_info') ?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="c">
                    <p class="install-title"><?= lang('admin_settings') ?></p>
                    <div class="input-group mb10">
                        <span class="input-group-text"><?= lang('admin_name') ?></span>
                        <input name="username" type="text" class="form-control" required>
                    </div>
                    <div class="input-group mb10">
                        <span class="input-group-text"><?= lang('admin_password') ?></span>
                        <input name="password" type="password" class="form-control" placeholder="<?= lang('admin_password_info') ?>" required>
                    </div>
                    <div class="input-group mb10">
                        <span class="input-group-text"><?= lang('admin_password_repeat') ?></span>
                        <input name="repassword" type="password" class="form-control" required>
                    </div>
                    <div class="input-group mb10">
                        <span class="input-group-text"><?= lang('email') ?></span>
                        <input name="email" type="text" class="form-control">
                    </div>
                </div>
                <div class="next_btn">
                    <button type="submit" class="btn"><?= lang('install_emlog') ?></button>
                </div>
            </div>
        </form>
        <div class="footer">Powered by <a href="http://www.emlog.net">emlog</a></div>
    </body>

    </html>
<?php
}
if ($act == 'install' || $act == 'reinstall') {
    $db_host = Input::postStrVar('hostname');
    $db_user = Input::postStrVar('dbuser');
    $db_pw = Input::postStrVar('dbpasswd');
    $db_name = Input::postStrVar('dbname');
    $db_prefix = Input::postStrVar('dbprefix');
    $username = Input::postStrVar('username');
    $password = Input::postStrVar('password');
    $repassword = Input::postStrVar('repassword');
    $email = Input::postStrVar('email');

    if ($db_prefix === '') {
        emMsg(lang('db_prefix_empty'));
    } elseif (!preg_match("/^[\w_]+_$/", $db_prefix)) {
        emMsg(lang('db_prefix_empty'));
    } elseif (!$username || !$password) {
        emMsg(lang('username_password_empty'));
    } elseif (strlen($password) < 6) {
        emMsg(lang('password_short'));
    } elseif ($password != $repassword) {
        emMsg(lang('password_not_equal'));
    }

    //Initialize the database class
    define('DB_HOST', $db_host);
    define('DB_USER', $db_user);
    define('DB_PASSWD', $db_pw);
    define('DB_NAME', $db_name);
    define('DB_PREFIX', $db_prefix);

    $DB = Database::getInstance();
    $CACHE = Cache::getInstance();

    if ($act != 'reinstall' && $DB->num_rows($DB->query("SHOW TABLES LIKE '{$db_prefix}blog'")) == 1) {
        $installed = lang('already_installed');
        $continue = lang('continue');
        $return_back = lang('return');
        echo <<<EOT
<html>
<head>
<meta charset="utf-8">
<title>emlog</title>
<style>
body {background-color:#F7F7F7;font-family: Arial;font-size: 12px;line-height:150%;}
.main {background-color:#FFFFFF;font-size: 12px;color: #666666;width:750px;margin:10px auto;padding:10px;list-style:none;border:#DFDFDF 1px solid;}
.main p {line-height: 18px;margin: 5px 20px;}
</style>
</head><body>
<form name="form1" method="post" action="install.php?action=reinstall">
<div class="main">
    <input name="hostname" type="hidden" class="input" value="$db_host">
    <input name="dbuser" type="hidden" class="input" value="$db_user">
    <input name="dbpasswd" type="hidden" class="input" value="$db_pw">
    <input name="dbname" type="hidden" class="input" value="$db_name">
    <input name="dbprefix" type="hidden" class="input" value="$db_prefix">
    <input name="username" type="hidden" class="input" value="$username">
    <input name="password" type="hidden" class="input" value="$password">
    <input name="repassword" type="hidden" class="input" value="$repassword">
    <input name="email" type="hidden" class="input" value="$email">
<p>
          {$installed}
          <input type="submit" value="{$continue}">
</p>
          <p><a href="javascript:history.back(-1);">{$return_back}</a></p>
</div>
</form>
</body>
</html>
EOT;
        exit;
    }

    if (!is_writable('config.php')) {
        emMsg(lang('config_not_writable'));
    }
    if (!is_writable(EMLOG_ROOT . '/content/cache')) {
        emMsg(lang('cache_not_writable'));
    }

    $PHPASS = new PasswordHash(8, true);

    $config = "<?php\n"
        . "//MySQL database host\n"
        . "const DB_HOST = '$db_host';"
        . "\n//Database username\n"
        . "const DB_USER = '$db_user';"
        . "\n//Database user password\n"
        . "const DB_PASSWD = '$db_pw';"
        . "\n//Database name\n"
        . "const DB_NAME = '$db_name';"
        . "\n//Database Table Prefix\n"
        . "const DB_PREFIX = '$db_prefix';"
        . "\n//Auth key\n"
        . "const AUTH_KEY = '" . $PHPASS->HashPassword(getRandStr(32) . md5(getIp()) . getUA() . microtime()) . "';"
        . "\n//Cookie name\n"
        . "const AUTH_COOKIE_NAME = 'EM_AUTHCOOKIE_" . sha1(getRandStr(32, false) . md5(getIp()) . getUA() . microtime()) . "';"
        . "\n// Default blog language\n"
        . "const DEFAULT_LANG = 'en'; //'en', 'ru', 'zh-CN', 'zh-TW', 'pt-BR', etc."
        . "\n// Enabled language list\n"
        . "const LANG_LIST = [\n"
        . "    'zh-CN' => [\n"
        . "         'name'=>'简体中文',\n"
        . "        'title'=>'Simplified Chinese',\n"
        . "        'dir'=>'ltr',\n"
        . "    ],\n"
        . "    'en' => [\n"
        . "        'name'=>'English',\n"
        . "        'title'=>'English',\n"
        . "        'dir'=>'ltr',\n"
        . "    ],\n"
        . "];\n";

    if (!file_put_contents('config.php', $config)) {
        emMsg(lang('config_not_writable'));
    }

    $password = $PHPASS->HashPassword($password);

    $table_charset_sql = 'DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
    $DB->query("ALTER DATABASE `{$db_name}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;", true);

    $widget_title = serialize(Option::getWidgetTitle());
    $def_widgets = serialize(Option::getDefWidget());
    $def_plugin = serialize(Option::getDefPlugin());

    $apikey = md5(getRandStr(32));

    define('BLOG_URL', realUrl());

    $sql = "
DROP TABLE IF EXISTS {$db_prefix}blog;
CREATE TABLE {$db_prefix}blog (
    gid int(11) unsigned NOT NULL auto_increment COMMENT 'Article table',
    title varchar(512) NOT NULL default '' COMMENT 'Article title',
    date bigint(20) NOT NULL COMMENT 'Publish time',
    content longtext NOT NULL  COMMENT 'Article content',
    excerpt longtext NOT NULL  COMMENT 'Article Summary',
    cover varchar(2048) NOT NULL DEFAULT '' COMMENT 'Cover image',
    alias varchar(255) NOT NULL DEFAULT '' COMMENT 'Article alias',
    author int(11) NOT NULL default '1' COMMENT 'Author UID',
    sortid int(11) NOT NULL default '-1' COMMENT 'Category ID',
    type varchar(20) NOT NULL default 'blog' COMMENT 'Article or Page',
    views int(11) unsigned NOT NULL default '0' COMMENT 'Read counter',
    comnum int(11) unsigned NOT NULL default '0' COMMENT 'Number of comments',
    like_count int(11) unsigned NOT NULL default '0' COMMENT 'Like',
    attnum int(11) unsigned NOT NULL default '0' COMMENT 'Number of attachments (obsolete)',
    top enum('n','y') NOT NULL default 'n' COMMENT 'Top',
    sortop enum('n','y') NOT NULL default 'n' COMMENT 'Top category',
    hide enum('n','y') NOT NULL default 'n' COMMENT 'Draft=y',
    checked enum('n','y') NOT NULL default 'y' COMMENT 'If article is reviewed',
    allow_remark enum('n','y') NOT NULL default 'y' COMMENT 'Allow comments=y',
    password varchar(255) NOT NULL default '' COMMENT 'Access password',
    template varchar(255) NOT NULL default '' COMMENT 'Template',
    tags text COMMENT 'Tags',
    link varchar(2048) NOT NULL DEFAULT '' COMMENT 'Article jump link',
    feedback varchar(2048) NOT NULL DEFAULT '' COMMENT 'audit feedback',
    parent_id bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Article Hierarchy - Parent ID',
    PRIMARY KEY (gid),
    KEY author (author),
    KEY views (views),
    KEY comnum (comnum),
    KEY sortid (sortid),
    KEY top (top,date),
    KEY date (date)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}blog (gid,title,date,content,excerpt,author,views,comnum,attnum,top,sortop,hide,allow_remark,password) VALUES (1, '" . lang('emlog_welcome') . "', '" . time() . "', '" . lang('emlog_install_congratulation') . "', '', 1, 0, 1, 0, 'n', 'n', 'n', 'y', '');
DROP TABLE IF EXISTS {$db_prefix}attachment;
CREATE TABLE {$db_prefix}attachment (
    aid int(11) unsigned NOT NULL auto_increment COMMENT 'Resource file table',
    alias varchar(64) NOT NULL default '' COMMENT 'Resource Alias',
    author int(11) unsigned NOT NULL default '1' COMMENT 'Author UID',
    sortid int(11) NOT NULL default '0' COMMENT 'Category ID',
    blogid int(11) unsigned NOT NULL default '0' COMMENT 'Article ID (obsolete)',
    filename varchar(255) NOT NULL default '' COMMENT 'File name',
    filesize int(11) NOT NULL default '0' COMMENT 'File size',
    filepath varchar(255) NOT NULL default '' COMMENT 'File path',
    addtime bigint(20) NOT NULL default '0' COMMENT 'Creation time',
    width int(11) NOT NULL default '0' COMMENT 'Image width',
    height int(11) NOT NULL default '0' COMMENT 'Image Height',
    mimetype varchar(40) NOT NULL default '' COMMENT 'File mime type',
    thumfor int(11) NOT NULL default 0 COMMENT 'Thumbnail for original resource ID (obsolete)',
    download_count bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT 'Downloads',
    PRIMARY KEY  (aid),
    KEY thum_uid (thumfor,author),
    KEY addtime (addtime)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}media_sort;
CREATE TABLE {$db_prefix}media_sort (
    id int(11) unsigned NOT NULL auto_increment COMMENT 'Media Category ID',
    sortname varchar(255) NOT NULL default '' COMMENT 'Media Category Name',
    PRIMARY KEY  (id)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}comment;
CREATE TABLE {$db_prefix}comment (
    cid int(11) unsigned NOT NULL auto_increment COMMENT 'Comment ID',
    gid int(11) unsigned NOT NULL default '0' COMMENT 'Article ID',
    pid int(11) unsigned NOT NULL default '0' COMMENT 'Parent comment ID',
    top enum('n','y') NOT NULL default 'n' COMMENT 'Top',
    poster varchar(20) NOT NULL default '' COMMENT 'Publisher nickname',
    avatar varchar(512) NOT NULL default '' COMMENT 'Publisher Avatar URL',
    uid int(11) NOT NULL default '0' COMMENT 'Publisher UID',
    comment text NOT NULL COMMENT 'Comment content',
    mail varchar(60) NOT NULL default '' COMMENT 'Email',
    url varchar(75) NOT NULL default '' COMMENT 'Homepage URL',
    ip varchar(128) NOT NULL default '' COMMENT 'IP address',
    agent varchar(512) NOT NULL default '' COMMENT 'User agent',
    hide enum('n','y') NOT NULL default 'n' COMMENT 'Hide or not',
    like_count int(11) unsigned NOT NULL default '0' COMMENT 'Like',
    date bigint(20) NOT NULL COMMENT 'Creation time',
    PRIMARY KEY  (cid),
    KEY gid (gid),
    KEY date (date),
    KEY hide (hide)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}comment (gid, date, poster, comment) VALUES (1, '" . time() . "', 'emlog', '" . lang('emlog_install_demo_comment') . "');
DROP TABLE IF EXISTS {$db_prefix}like;
CREATE TABLE {$db_prefix}like (
    id int(11) unsigned NOT NULL auto_increment COMMENT 'Like table',
    gid int(11) unsigned NOT NULL default '0' COMMENT 'Article ID',
    poster varchar(20) NOT NULL default '' COMMENT 'Publisher nickname',
    avatar varchar(512) NOT NULL default '' COMMENT 'Publisher Avatar URL',
    uid int(11) NOT NULL default '0',
    ip varchar(128) NOT NULL default '',
    agent varchar(512) NOT NULL default '',
    date bigint(20) NOT NULL,
    PRIMARY KEY  (id),
    KEY gid (gid),
    KEY date (date)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}options;
CREATE TABLE {$db_prefix}options (
    option_id INT(11) UNSIGNED NOT NULL auto_increment COMMENT 'Cofiguration table',
    option_name VARCHAR(75) NOT NULL COMMENT 'Option name',
    option_value LONGTEXT NOT NULL COMMENT 'Option value',
    PRIMARY KEY (option_id),
    UNIQUE KEY `option_name_uindex` (`option_name`)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES 
('blogname','EMLOG'),
('bloginfo','" . lang('emlog_powered') . "'),
('site_title',''),
('site_description',''),
('site_key','emlog'),
('log_title_style','0'),
('blogurl','" . BLOG_URL . "'),
('icp',''),
('footer_info','powered by <a href=\"https://www.emlog.net\">emlog</a>'),
('rss_output_num','10'),
('rss_output_fulltext','y'),
('index_lognum','10'),
('isfullsearch','n'),
('index_comnum','10'),
('index_newlognum','5'),
('index_hotlognum','5'),
('comment_subnum','20'),
('nonce_templet','default'),
('admin_style','default'),
('tpl_sidenum','1'),
('comment_code','n'),
('comment_needchinese','n'),
('comment_interval',60),
('isgravatar','y'),
('isthumbnail','n'),
('att_maxsize','2048'),
('att_type','jpg,jpeg,png,gif,zip,rar'),
('att_imgmaxw','600'),
('att_imgmaxh','370'),
('comment_paging','y'),
('comment_pnum','10'),
('comment_order','newer'),
('iscomment','y'),
('login_comment','n'),
('ischkcomment','y'),
('isurlrewrite','0'),
('isalias','n'),
('isalias_html','n'),
('timezone','Asia/Shanghai'),
('active_plugins','$def_plugin'),
('widget_title','$widget_title'),
('custom_widget','a:0:{}'),
('widgets1','$def_widgets'),
('detect_url','y'),
('emkey',''),
('login_code','n'),
('email_code','n'),
('is_signup','y'),
('ischkarticle','y'),
('article_uneditable','n'),
('forbid_user_upload','n'),
('posts_per_day',10),
('smtp_mail',''),
('smtp_pw',''),
('smtp_server',''),
('smtp_port',''),
('is_openapi','n'),
('apikey','$apikey'),
('panel_menu_title',''),
('admin_article_perpage_num','20'),
('admin_user_perpage_num','20'),
('admin_comment_perpage_num','20');
DROP TABLE IF EXISTS {$db_prefix}link;
CREATE TABLE {$db_prefix}link (
    id int(11) unsigned NOT NULL auto_increment COMMENT 'Link table',
    sitename varchar(255) NOT NULL default '' COMMENT 'Name',
    siteurl varchar(255) NOT NULL default '' COMMENT 'URL',
    icon varchar(512) NOT NULL default '' COMMENT 'Link LOGO URL',
    description varchar(512) NOT NULL default '' COMMENT 'Description',
    hide enum('n','y') NOT NULL default 'n' COMMENT 'Hide or not',
    taxis int(11) unsigned NOT NULL default '0' COMMENT 'Sort order',
    PRIMARY KEY  (id)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}link (id, sitename, siteurl, icon, description, taxis) VALUES (1, 'EMLOG', 'https://www.emlog.net', '', '" . lang('emlog_official_site') . "', 0);
DROP TABLE IF EXISTS {$db_prefix}navi;
CREATE TABLE {$db_prefix}navi (
    id int(11) unsigned NOT NULL auto_increment COMMENT 'Navigation table',
    naviname varchar(30) NOT NULL default '' COMMENT 'Navigation name',
    url varchar(512) NOT NULL default '' COMMENT 'Navigation URL',
    newtab enum('n','y') NOT NULL default 'n' COMMENT 'Open in a new window',
    hide enum('n','y') NOT NULL default 'n' COMMENT 'Hide or not',
    taxis int(11) unsigned NOT NULL default '0' COMMENT 'Sort order',
    pid int(11) unsigned NOT NULL default '0' COMMENT 'Parent ID',
    isdefault enum('n','y') NOT NULL default 'n' COMMENT 'Is the system default navigation, i.e. home page',
    type tinyint(3) unsigned NOT NULL default '0' COMMENT 'Navigation type: 0=custom, 1=home, 2=Note, 3=AdminCP, 4=Categories, 5=page',
    type_id int(11) unsigned NOT NULL default '0' COMMENT 'Navigation type corresponding ID',
    PRIMARY KEY  (id)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (1, '" . lang('home') . "', '', 1, 'y', 1);
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (3, '" . lang('login') . "', 'admin', 3, 'y', 3);
DROP TABLE IF EXISTS {$db_prefix}tag;
CREATE TABLE {$db_prefix}tag (
    tid int(11) unsigned NOT NULL auto_increment COMMENT 'Tag table',
    tagname varchar(60) NOT NULL default '' COMMENT 'Tag name',
    description VARCHAR(2048) NOT NULL DEFAULT '' COMMENT 'Description',
    title VARCHAR(2048) NOT NULL DEFAULT '' COMMENT 'Page title',
    kw VARCHAR(2048) NOT NULL DEFAULT '' COMMENT 'Keyword',
    gid text NOT NULL COMMENT 'Article ID',
    PRIMARY KEY  (tid),
    KEY tagname (tagname)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}sort;
CREATE TABLE {$db_prefix}sort (
    sid int(11) unsigned NOT NULL auto_increment COMMENT 'Category Table',
    sortname varchar(255) NOT NULL default '' COMMENT 'Category name',
    alias VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Alias',
    taxis int(11) unsigned NOT NULL default '0' COMMENT 'Sort order',
    pid int(11) unsigned NOT NULL default '0' COMMENT 'Parent category ID',
    description text NOT NULL COMMENT 'Description',
    kw VARCHAR(2048) NOT NULL DEFAULT '' COMMENT 'Keyword',
    title VARCHAR(2048) NOT NULL DEFAULT '' COMMENT 'Page title',
    template varchar(255) NOT NULL default '' COMMENT 'Category template',
    sortimg varchar(512) NOT NULL default '' COMMENT 'Category Cover',
    page_count int(11) unsigned NOT NULL default '0' COMMENT 'Count per page',
    allow_user_post enum('n','y') NOT NULL default 'y' COMMENT 'Allow users to publish articles',
    PRIMARY KEY  (sid)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}user;
CREATE TABLE {$db_prefix}user (
    uid int(11) unsigned NOT NULL auto_increment COMMENT 'User table',
    username varchar(32) NOT NULL default '' COMMENT 'User name',
    password varchar(64) NOT NULL default '' COMMENT 'User password',
    nickname varchar(20) NOT NULL default '' COMMENT 'Nickname',
    role varchar(60) NOT NULL default '' COMMENT 'Role',
    ischeck enum('n','y') NOT NULL default 'n' COMMENT 'Need to preview by admin',
    photo varchar(255) NOT NULL default '' COMMENT 'Avatar',
    email varchar(60) NOT NULL default '' COMMENT 'Email',
    description varchar(255) NOT NULL default '' COMMENT 'Description',
    ip varchar(128) NOT NULL default '' COMMENT 'IP address',
    state tinyint NOT NULL DEFAULT '0' COMMENT 'User status: 0 normal, 1 disabled',
    credits int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'User points',
    create_time int(11) NOT NULL COMMENT 'Create time',
    update_time int(11) NOT NULL COMMENT 'Update time',
    PRIMARY KEY  (uid),
    KEY username (username),
    KEY email (email)         
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}user (uid, username, email, password, nickname, role, create_time, update_time) VALUES (1,'$username','$email','$password', 'emer','admin', " . time() . ", " . time() . ");
DROP TABLE IF EXISTS {$db_prefix}twitter;
CREATE TABLE {$db_prefix}twitter (
    id INT NOT NULL AUTO_INCREMENT COMMENT 'Note ID',
    content text NOT NULL COMMENT 'Note content',
    img varchar(255) DEFAULT NULL COMMENT 'Image',
    author int(11) NOT NULL default '1' COMMENT 'Author UID',
    date bigint(20) NOT NULL COMMENT 'Create time',
    replynum int(11) unsigned NOT NULL default '0' COMMENT 'Number of replies',
    private enum('n','y') NOT NULL default 'n' COMMENT 'Whether private or not',
    PRIMARY KEY (id),
    KEY author (author)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}storage;
CREATE TABLE {$db_prefix}storage (
    `sid` int(8) NOT NULL AUTO_INCREMENT COMMENT 'Object storage table',
    `plugin` varchar(32) NOT NULL COMMENT 'Plugin name',
    `name` varchar(32) NOT NULL COMMENT 'Object name',
    `type` varchar(8) NOT NULL COMMENT 'Object data type',
    `value` text NOT NULL COMMENT 'Object value',
    `createdate` int(11) NOT NULL COMMENT 'Create time',
    `lastupdate` int(11) NOT NULL COMMENT 'Update time',
    PRIMARY KEY (`sid`),
    UNIQUE KEY `plugin` (`plugin`,`name`)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}tpl_options_data;
CREATE TABLE {$db_prefix}tpl_options_data (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `template` varchar(64) NOT NULL,
    `name` varchar(64) NOT NULL,
    `depend` varchar(64) NOT NULL DEFAULT '',
    `data` longtext NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `template` (`template`,`name`)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}order;
CREATE TABLE {$db_prefix}order (
    id bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Order table',
    app_name varchar(32) NOT NULL COMMENT 'App name',
    order_id varchar(64) NOT NULL DEFAULT '' COMMENT 'Order ID',
    order_uid int unsigned NOT NULL COMMENT 'User ID',
    out_trade_no varchar(255) DEFAULT '' COMMENT 'Order trade num',
    pay_type varchar(64) NOT NULL DEFAULT '' COMMENT 'Payment method',
    sku_name varchar(64) NOT NULL DEFAULT '' COMMENT 'Product type',
    sku_id int NOT NULL,
    price decimal(10, 2) NOT NULL COMMENT 'Price',
    pay_price decimal(10, 2) DEFAULT '0.00' COMMENT 'Paid price',
    refund_amount decimal(10, 2) NOT NULL DEFAULT '0.00' COMMENT 'Refund amount',
    update_time int unsigned NOT NULL COMMENT 'Update time',
    create_time int unsigned NOT NULL COMMENT 'Create time',
    PRIMARY KEY (id),
    UNIQUE KEY order_id (order_id),
    KEY idx_uid_ctime (order_uid, create_time),
    KEY idx_ctime (create_time)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}blog_fields;
CREATE TABLE {$db_prefix}blog_fields (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `gid` bigint unsigned NOT NULL DEFAULT '0',
    `field_key` varchar(255) DEFAULT NULL DEFAULT '',
    `field_value` longtext,
    PRIMARY KEY (`id`),
    KEY `gid` (`gid`)
)" . $table_charset_sql;

    $array_sql = preg_split("/;[\r\n]/", $sql);
    foreach ($array_sql as $sql) {
        $sql = trim($sql);
        if ($sql) {
            $DB->query($sql);
        }
    }
    $CACHE->updateCache();
    $result = '';
    $result .= "
        <p style=\"font-size:24px; border-bottom:1px solid #E6E6E6; padding:10px 0px;\">" . lang('emlog_installed') . "</p>
        <p><b>" . lang('user_name') . "</b>：{$username}</p>
        <p><b>" . lang('password') . "</b>：" . lang('password_entered') . "</p>";
    if ($env_emlog_env === 'develop' || ($env_emlog_env !== 'develop' && !@unlink('./install.php'))) {
        $result .= '<p style="color:#ff0000;margin:10px 20px;">' . lang('delete_install') . '</p> ';
    }
    $result .= "<p style=\"text-align:right;\"><a href=\"./\">" . lang('go_to_front') . "</a> | <a href=\"./admin/\">" . lang('go_to_admincp') . "</a></p>";
    emMsg($result, 'none');
}
?>