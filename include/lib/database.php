<?php

/**
 * Database operation routing
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Database
{

    public static function getInstance()
    {
        if (defined('USE_MYSQL_PDO') && USE_MYSQL_PDO === true) {
            if (class_exists('pdo', false)) {
                return DatabasePDO::getInstance();
            } else {
                emMsg(lang('pdo_not_supported'));
            }
        } else {
            if (class_exists('mysqli', FALSE)) {
                return MySqlii::getInstance();
            }

            if (class_exists('pdo', false)) {
                return DatabasePDO::getInstance();
            }

            emMsg(lang('mysql_not_supported'));
        }
    }
}
