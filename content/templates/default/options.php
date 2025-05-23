<?php
/*@support tpl_options*/

/**
 * Profile for template options
 * See the official website for details - Template development：https://www.emlog.net/docs/dev/template
 */

defined('EMLOG_ROOT') || exit('access denied!');

load_language('templates/default');

$options = [
    'TplOptionsNavi' => [
        'type'        => 'radio',
        'name'        => lang('define_settings_tab_name'),
        'values'      => [
            'tpl-head' => lang('head_settings'),
            'tpl-home' => lang('home_page_settings'),
        ],
        'description' => '<p>'. lang('settings_tip') .'</p>'
    ],
    'logotype'       => [
        'labels'  => 'tpl-head',
        'type'    => 'radio',
        'name'    => lang('logo_type'),
        'new'     => 'NEW',
        'values'  => [
            '1' => lang('text'),
            '0' => lang('image'),
        ],
        'default' => '1',
    ],
    'logoimg'        => [
        'labels'      => 'tpl-head',
        'type'        => 'image',
        'name'        => lang('upload_logo'),
        'values'      => [
            TEMPLATE_URL . 'images/logo.png',
        ],
        'description' => lang('upload_logo_tip')
    ],
    'favicon'        => [
        'labels'      => 'tpl-head',
        'type'        => 'image',
        'name'        => lang('browser_icon'),
        'description' => lang('browser_icon_tip')
    ],
    'slideShow'      => [
        'labels'      => 'tpl-home',
        'type'        => 'text',
        'name'        => lang('swiper_images'),
        'multi'       => true,
        'description' => lang('swiper_images_tip'),
    ],
];
