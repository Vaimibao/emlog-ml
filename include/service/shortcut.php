<?php

/**
 * Service: Shortcut
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Shortcut
{

    public static function getActive()
    {
        $shortcut = Option::get('shortcut');
        if (empty($shortcut)) {
            return [];
        }
        return json_decode($shortcut, 1);
    }

    public static function getAll($plugins = [])
    {
        if (empty($plugins)) {
            $Plugin_Model = new Plugin_Model();
            $plugins = $Plugin_Model->getPlugins();
        }
        $shortcutAll = [
        ['name' => lang('template'), 'url' => 'template.php'],
        ['name' => lang('plugin'), 'url' => 'plugin.php'],
        ['name' => lang('category'), 'url' => 'sort.php'],
        ['name' => lang('tag'), 'url' => 'tag.php'],
        ['name' => lang('pages'), 'url' => 'page.php'],
        ['name' => lang('navigation'), 'url' => 'navbar.php'],
        ['name' => lang('sidebar'), 'url' => 'widgets.php'],
        ['name' => lang('links'), 'url' => 'link.php'],
        ];
        foreach ($plugins as $val) {
            if (empty($val) || $val['active'] === 'off' || !$val['Setting'] || in_array($val['Name'], [lang('tips_plugin'), lang('tpl_plugin')])) {
                continue;
            }
            $shortcutAll[] = [
                'name' => $val['Name'],
                'url'  => './plugin.php?plugin=' . $val['Plugin'],
            ];
        }

        return $shortcutAll;
    }
}
