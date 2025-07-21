<?php

/**
 * store
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Store_Model = new Store_Model();

$template_categories = [
    0  => lang('search_by_tpl_category'),
    8  => lang('tpl_category_8'),
    7  => lang('tpl_category_7'),
    9  => lang('tpl_category_9'),
    17 => lang('tpl_category_17'),
    19 => lang('tpl_category_19'),
    21 => lang('tpl_category_21'),
    10 => lang('tpl_category_10'),
];

$plugin_categories = [
    0  => lang('search_by_plugin_category'),
    20 => lang('plu_category_20'),
    2  => lang('plu_category_2'),
    1  => lang('plu_category_1'),
    18 => lang('plu_category_18'),
    3  => lang('plu_category_3'),
    4  => lang('plu_category_4'),
    11 => lang('plu_category_11'),
    12 => lang('plu_category_12'),
    13 => lang('plu_category_13'),
    14 => lang('plu_category_14'),
    15 => lang('plu_category_15'),
    16 => lang('plu_category_16'),
    5  => lang('plu_category_5'),
    6  => lang('plu_category_6')
];

if (empty($action)) {
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getStrVar('author_id');
    $sid = Input::getIntVar('sid');

    $r = $Store_Model->getApps($tag, $keyword, $page, $author_id, $sid);
    $apps = $r['apps'];
    $tab_type = 'all';
    $has_more = $r['has_more'];

    $sub_title = lang('all_apps');
    if ($tag === 'free') {
        $sub_title = lang('free_apps');
    } elseif ($tag === 'paid') {
        $sub_title = lang('paid_apps');
    } elseif ($tag === 'promo') {
        $sub_title = lang('limited_time_offer');
    }

    include View::getAdmView('header');
    require_once(View::getAdmView('store'));
    require_once(View::getAdmView('store_app_list'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'tpl') {
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getStrVar('author_id');
    $sid = Input::getIntVar('sid');

    $r = $Store_Model->getTemplates($tag, $keyword, $page, $author_id, $sid);
    $apps = $r['templates'];
    $tab_type = 'tpl';
    $has_more = $r['has_more'];

    $sub_title = lang('ext_store_templates');
    if ($tag === 'free') {
        $sub_title = lang('free_template');
    } elseif ($tag === 'paid') {
        $sub_title = lang('paid_template');
    } elseif ($tag === 'promo') {
        $sub_title = lang('limited_time_offer');
    } elseif ($tag === 'free_top') {
        $sub_title = lang('free_top');
    } elseif ($tag === 'paid_top') {
        $sub_title = lang('paid_top');
    }

    include View::getAdmView('header');
    require_once(View::getAdmView('store_tpl'));
    require_once(View::getAdmView('store_app_list'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'plu') {
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getIntVar('author_id');
    $sid = Input::getIntVar('sid');

    $r = $Store_Model->getPlugins($tag, $keyword, $page, $author_id, $sid);
    $apps = $r['plugins'];
    $tab_type = 'plu';
    $has_more = $r['has_more'];

    $sub_title = lang('ext_store_plugins');
    if ($tag === 'free') {
        $sub_title = lang('free_plugin');
    } elseif ($tag === 'paid') {
        $sub_title = lang('paid_plugin');
    } elseif ($tag === 'promo') {
        $sub_title = lang('limited_time_offer');
    } elseif ($tag === 'free_top') {
        $sub_title = lang('free_top');
    } elseif ($tag === 'paid_top') {
        $sub_title = lang('paid_top');
    }

    include View::getAdmView('header');
    require_once(View::getAdmView('store_plu'));
    require_once(View::getAdmView('store_app_list'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'mine') {
    $addons = $Store_Model->getMyAddon();
    $sub_title = lang('my_apps');

    include View::getAdmView('header');
    require_once(View::getAdmView('store_mine'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'svip') {
    $addons = $Store_Model->getSvipAddon();
    $sub_title = lang('svip');

    include View::getAdmView('header');
    require_once(View::getAdmView('store_svip'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'top') {
    $addons = $Store_Model->getTopAddon();
    output::ok($addons);
}

if ($action === 'error') {
    $keyword = '';
    $sub_title = '';
    $sid = '';

    include View::getAdmView('header');
    require_once(View::getAdmView('store'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'install') {
    $source = Input::getStrVar('source', ''); // plugin/down/11
    $source_type = Input::getStrVar('type', '');

    if (empty($source)) {
        exit(lang('install_failed'));
    }

    $temp_file = emFetchFile('https://www.emlog.net/' . $source);

    if (!$temp_file) {
        if (false === Register::verifyDownload($source)) {
            exit(lang('emlog_unregistered') . '<a href="https://emlog.net/register">'. lang('go_to_register') .'</a>');
        }
        exit(lang('download_file_timeout'));
    }

    if ($source_type == 'tpl') {
        $unzip_path = '../content/templates/';
        $store_path = './store.php?';
        $suc_url = 'template.php';
    } else {
        $unzip_path = '../content/plugins/';
        $store_path = './store.php?action=plu&';
        $suc_url = 'plugin.php';
    }

    $ret = emUnZip($temp_file, $unzip_path, $source_type);
    @unlink($temp_file);
    switch ($ret) {
        case 0:
            exit(lang('install_ok') . ' <a href="' . $suc_url . '">' . lang('go_check') . '</a>');
        case 1:
            exit(lang('install_failed_permission'));
        case 2:
            exit(lang('install_failed_download'));
        case 3:
            exit(lang('install_failed_zip'));
        default:
            exit(lang('install_invalid_ext'));
    }
}

if ($action === 'ajax_load') {
    $type = Input::getStrVar('type', 'all'); // all, tpl, plu
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getStrVar('author_id');
    $sid = Input::getIntVar('sid');

    $Store_Model = new Store_Model();

    switch ($type) {
        case 'tpl':
            $r = $Store_Model->getTemplates($tag, $keyword, $page, $author_id, $sid);
            $apps = $r['templates'];
            break;
        case 'plu':
            $r = $Store_Model->getPlugins($tag, $keyword, $page, $author_id, $sid);
            $apps = $r['plugins'];
            break;
        default:
            $r = $Store_Model->getApps($tag, $keyword, $page, $author_id, $sid);
            $apps = $r['apps'];
            break;
    }

    $count = $r['count'];
    $page_count = $r['page_count'];
    $has_more = isset($r['has_more']) ? $r['has_more'] : ($page < $page_count);
    $next_page = $has_more ? $page + 1 : null;

    // Add status information for each application
    foreach ($apps as &$app) {
        // Check if it is currently in use
        if ($app['app_type'] === 'template') {
            $app['is_active'] = Template::isActive($app['alias']);
        } else {
            $app['is_active'] = Plugin::isActive($app['alias']);
        }
        $app['user_is_svip'] = (Register::getRegType() === 2);
    }

    $response = [
        'code' => 200,
        'data' => [
            'apps' => $apps,
            'count' => $count,
            'page_count' => $page_count
        ],
        'has_more' => $has_more,
        'current_page' => $page,
        'next_page' => $next_page
    ];

    Output::json($response);
}
