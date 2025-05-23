<?php
defined('EMLOG_ROOT') || exit('access denied!');

// Execute this function when the plugin is started
function callback_init() {
    // do something
}

// Execute this function when the plugin is removed
function callback_rm() {
    $plugin_storage = Storage::getInstance('tips');
    $plugin_storage->deleteAllName('YES'); // Clean up plugin settings data when the plugin is removed
}

// Execute this function when the plugin is updated
function callback_up() {
    // do something
}
