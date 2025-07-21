<?php

/**
 * System call file of template
 * After the template is enabled, the file will be automatically loaded by the system. It can be used to implement functions similar to plug-ins.
 */

defined('EMLOG_ROOT') || exit('access denied!');

// Add button style for download link
function add_download_style($logData, &$result)
{
    // Optimize regular expressions to match multiple download link formats
    $pattern = '/<a\s+([^>]*href="[^"]*(?:\?resource_alias=[^&"]*(?:&resource_filename=[^"]*)?|\.(?:zip|rar|7z|gz|bz2|tar|exe|dmg|pkg|deb|rpm))(?:[^"]*)?"[^>]*)>/i';
    $replacement = '<a $1 class="em-download-btn"><span class="iconfont icon-clouddownload"></span> ';
    $result['log_content'] = preg_replace($pattern, $replacement, $logData['log_content']);
}

addAction('article_content_echo', 'add_download_style');

// Define Download Button Style
function render_download_btn()
{
    echo <<<EOT
<style>
.em-download-btn {
    background-color: var(--buttonBgColor);
    color: var(--fontColor);
    border: 1px solid var(--buttonBorderColor);
    padding: 10px 20px;
    border-radius: var(--marRadius);
    cursor: pointer;
    font-size: 16px;
    text-decoration: none !important;
}
</style>

EOT;
}

addAction('index_head', 'render_download_btn');
