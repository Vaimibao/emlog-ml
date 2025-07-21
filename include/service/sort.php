<?php
/**
 * Service: Sort
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Sort
{
    static function formatSortTitle($title, $sortName)
    {
        $site_title = Option::get('site_title');
        $blogname = Option::get('blogname');

        if (empty($site_title)) {
            $site_title = $blogname;
        }

        return strtr($title, [
            '{{site_title}}' => $site_title,
            '{{site_name}}'  => $blogname,
            '{{sort_name}}'  => $sortName
        ]);
    }

    /**
     * Get the list of categories that allow registered users to submit
     * @return array category array
     */
    static function getUserPostableSorts()
    {
        $Sort_Model = new Sort_Model();
        if (User::haveEditPermission()) {
            return $Sort_Model->getSorts();
        }
        return $Sort_Model->getSorts(true);
    }
}
