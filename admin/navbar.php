<?php

/**
 * navbar menu items
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Navi_Model = new Navi_Model();

if (empty($action)) {
    $emPage = new Log_Model();

    $navis = $Navi_Model->getNavis();
    $sorts = $CACHE->readCache('sort');
    $pages = $emPage->getAllPageList();

    include View::getAdmView('header');
    require_once(View::getAdmView('navbar'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'taxis') {
    $navi = Input::postStrArray('navi', []);

    if (empty($navi)) {
        Output::error(lang('nav_no_order'));
    }

    foreach ($navi as $key => $value) {
        $value = (int)$value;
        $key = (int)$key;
        $Navi_Model->updateNavi(array('taxis' => $key), $value);
    }
    $CACHE->updateCache('navi');
    Output::ok();
}

if ($action == 'add') {
    $taxis = Input::postIntVar('taxis', 0);
    $naviname = Input::postStrVar('naviname');
    $url = Input::postStrVar('url');
    $pid = Input::postIntVar('pid', 0);
    $newtab = Input::postStrVar('newtab', 'n');

    if ($naviname == '' || $url == '') {
        emDirect("./navbar.php?error_a=1");
    }

    $Navi_Model->addNavi($naviname, $url, $taxis, $pid, $newtab);
    $CACHE->updateCache('navi');
    emDirect("./navbar.php?active_add=1");
}

if ($action == 'add_sort') {
    $sort_ids = Input::postIntArray('sort_ids', []);

    $sorts = $CACHE->readCache('sort');

    if (empty($sort_ids)) {
        emDirect("./navbar.php?error_d=1");
    }

    foreach ($sort_ids as $val) {
        $sort_id = (int)$val;
        $Navi_Model->addNavi(addslashes($sorts[$sort_id]['sortname']), '', 0, 0, 'n', Navi_Model::navitype_sort, $sort_id);
    }

    $CACHE->updateCache('navi');
    emDirect("./navbar.php?active_add=1");
}

if ($action == 'add_page') {
    $pages = Input::postStrArray('pages', []);

    if (empty($pages)) {
        emDirect("./navbar.php?error_e=1");
    }

    foreach ($pages as $id => $title) {
        $id = (int)$id;
        $title = addslashes($title);
        $Navi_Model->addNavi($title, '', 0, 0, 'n', Navi_Model::navitype_page, $id);
    }

    $CACHE->updateCache('navi');
    emDirect('./navbar.php?active_add=1');
}

if ($action == 'mod') {
    $naviId = Input::getIntVar('navid');
    $navis = $CACHE->readCache('navi');
    $naviData = $Navi_Model->getOneNavi($naviId);
    extract($naviData);
    if ($type != Navi_Model::navitype_custom) {
        $url = lang('address_generated');
    }
    $conf_newtab = $newtab == 'y' ? 'checked="checked"' : '';
    $conf_isdefault = $type != Navi_Model::navitype_custom ? 'disabled="disabled"' : '';

    include View::getAdmView('header');
    require_once(View::getAdmView('naviedit'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'update') {
    $naviname = Input::postStrVar('naviname');
    $url = Input::postStrVar('url');
    $newtab = Input::postStrVar('newtab', 'n');
    $naviId = Input::postIntVar('navid');
    $isdefault = Input::postStrVar('isdefault', 'n');
    $pid = Input::postIntVar('pid', 0);

    $navi_data = array(
        'naviname' => $naviname,
        'newtab'   => $newtab,
        'pid'      => $pid,
    );

    if (empty($naviname)) {
        unset($navi_data['naviname']);
    }

    if ($isdefault == 'n') {
        $navi_data['url'] = $url;
    }

    $Navi_Model->updateNavi($navi_data, $naviId);

    $CACHE->updateCache('navi');
    emDirect("./navbar.php?active_edit=1");
}

if ($action == 'del') {
    LoginAuth::checkToken();
    $navid = Input::getIntVar('id');
    $Navi_Model->deleteNavi($navid);
    $CACHE->updateCache('navi');
    emDirect("./navbar.php");
}

if ($action == 'hide') {
    $naviId = Input::getIntVar('id');

    $Navi_Model->updateNavi(array('hide' => 'y'), $naviId);

    $CACHE->updateCache('navi');
    emDirect('./navbar.php');
}

if ($action == 'show') {
    $naviId = Input::getIntVar('id');

    $Navi_Model->updateNavi(array('hide' => 'n'), $naviId);

    $CACHE->updateCache('navi');
    emDirect('./navbar.php');
}
