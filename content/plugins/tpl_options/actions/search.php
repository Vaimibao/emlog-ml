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

//处理AJAX action
$action = Input::postStrVar('action', '');
if (!isset($action)) {
    echo lang('operation_failed');
    exit;
}

//处理AJAX传入值
$_s_type = '';
$s_key = Input::postStrVar('kywd', '');
$s_key = htmlspecialchars($s_key) ?: '';
$name = Input::postStrVar('name', '');
$type = Input::postStrVar('type', '');

//Processing Template options plugin file exception
$type_arr = [
    'post' => lang('articles'),
    'cate' => lang('categories'),
    'page' => lang('pages'),
];

$exit_tip = '<li class="no-results">'. lang('plugin_file_damaged') .'</li>';
$is_type_exists = array_key_exists(trim($type), $type_arr);

if (!$is_type_exists) {
    echo $exit_tip;
    exit;
}
$_s_type = $type_arr[$type];

//Handling AJAX requests
if ($action === 'tpl_select_search') {
    if (empty(trim($s_key))) {
        echo '<li class="no-results">' . lang('please_input') . $_s_type . lang('_title_kw_tip') . '</li>';
        exit;
    }
    switch ($type) {
        case 'post':
        case 'page':
        {
            if (strstr($s_key, "'")) {
                $sqlSegment = 'and title like "%{$s_key}%" order by date desc';
            } else {
                $sqlSegment = "and title like '%{$s_key}%' order by date desc";
            }
            $html = '';
            $_this_sql_type = $type == 'post' ? 'blog' : 'page';
            $now = time();
            $DB = Database::getInstance();
            $sql = "SELECT gid,title,date FROM " . DB_PREFIX . "blog WHERE type='$_this_sql_type' and hide='n' and checked='y' and date<= $now $sqlSegment";
            $res = $DB->query($sql);
            if (mysqli_num_rows($res)) {
                while ($row = $DB->fetch_array($res)) {
                    $_title = htmlspecialchars(trim($row['title']));
                    $html .= '<li class="active-result" data-opt="' . $type . '" data-id="' . $row['gid'] . '" data-s-name="' . $name . '">' . $_title . '</li>';
                }
                echo $html;
                exit;
            } else {
                echo '<li class="no-results">' . lang('not_fount') . $_s_type . '</li>';
                exit;
            }
        }
        case 'cate':
        {
            $sorts = Cache::getInstance()->readCache('sort');
            $html = '';
            foreach ($sorts as $sort) {
                if (strpos($sort['sortname'], $s_key) !== false) {
                    $html .= '<li class="active-result" data-opt="' . $type . '" data-id="' . $sort['sid'] . '" data-s-name="' . $name . '">' . $sort['sortname'] . '</li>';
                }
            }
            echo $html ?: '<li class="no-results">' . lang('not_fount') . $_s_type . '</li>';
            exit;
        }
    }
}