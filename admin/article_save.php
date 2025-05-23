<?php

/**
 * article save and update
 * @package EMLOG
 * @link https://www.emlog.net
 */

require_once 'globals.php';

if (empty($_POST)) {
    exit;
}

$Log_Model = new Log_Model();
$Tag_Model = new Tag_Model();

$title = Input::postStrVar('title');
$postDate = Input::postStrVar('postdate');
$postDate = $postDate ? strtotime($postDate) : time();
$sort = Input::postIntVar('sort', -1);
$tagstring = strip_tags(Input::postStrVar('tag'));
$content = Input::postStrVar('logcontent');
$excerpt = Input::postStrVar('logexcerpt');
$alias = Input::postStrVar('alias');
$top = Input::postStrVar('top', 'n');
$sortop = Input::postStrVar('sortop', 'n');
$allow_remark = Input::postStrVar('allow_remark', 'n');
$password = Input::postStrVar('password');
$template = Input::postStrVar('template');
$cover = Input::postStrVar('cover');
$link = Input::postStrVar('link');
$author  = Input::postIntVar('author');
$author = $author && User::haveEditPermission() ? $author : UID; // Non administrator users can only modify their own articles
$ishide = Input::postStrVar('ishide', 'y');
$blogid = Input::postIntVar('as_logid', -1); //Automatically save as draft article ID
$pubPost = Input::postStrVar('pubPost'); // Should I publish the article directly instead of saving a draft
$auto_excerpt = Input::postStrVar('auto_excerpt', 'n');
$auto_cover = Input::postStrVar('auto_cover', 'n');
$field_keys = Input::postStrArray('field_keys');
$field_values = Input::postStrArray('field_values');

// Automatically extract summary
if (empty($excerpt) && $auto_excerpt === 'y') {
    $origContent = trim($_POST['logcontent']);
    $parseDown = new Parsedown();
    $excerpt = $parseDown->text($origContent);
    $excerpt = extractHtmlData($excerpt, 180);
    $excerpt = str_replace(["\r", "\n", "'", '"'], ' ', $excerpt);
    $excerpt = addslashes($excerpt);
}

// Automatically obtain cover image
if ($content && empty($cover) && $auto_cover === 'y') {
    $cover = getFirstImage($content);
}

if ($pubPost) {
    $ishide = 'n';
}

// Check article alias
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $alias)) {
    $alias = '';
}
if (!empty($alias)) {
    $logalias_cache = $CACHE->readCache('logalias');
    $alias = $Log_Model->checkAlias($alias, $logalias_cache, $blogid);
}

//Administrators do not need to review articles, registered users are restricted
$checked = Option::get('ischkarticle') == 'y' && !User::haveEditPermission() ? 'n' : 'y';

$logData = [
    'title'        => $title,
    'alias'        => $alias,
    'content'      => $content,
    'excerpt'      => $excerpt,
    'cover'        => $cover,
    'author'       => $author,
    'sortid'       => $sort,
    'date'         => $postDate,
    'top '         => $top,
    'sortop '      => $sortop,
    'allow_remark' => $allow_remark,
    'hide'         => $ishide,
    'checked'      => $checked,
    'password'     => $password,
    'link'         => $link,
    'template'     => $template,
];

// Daily post limit
if (Article::hasReachedDailyPostLimit()) {
    emDirect("./article.php?error_post_per_day=1");
}

doMultiAction('pre_save_log', $logData, $logData);

if ($blogid > 0) {
    $Log_Model->updateLog($logData, $blogid);
    $Tag_Model->updateTag($tagstring, $blogid);
} else {
    $blogid = $Log_Model->addlog($logData);
    $Tag_Model->addTag($tagstring, $blogid);
}

$CACHE->updateArticleCache();

Field::updateField($blogid, $field_keys, $field_values);

doAction('save_log', $blogid, $pubPost, $logData);

// Asynchronous Save
if ($action === 'autosave') {
    exit('autosave_gid:' . $blogid . '_');
}

// Save Draft
if ($ishide === 'y') {
    emDirect("./article.php?draft=1&active_savedraft=1");
}

// Article (draft) publicly released
if ($pubPost) {
    if (!User::haveEditPermission()) {
        notice::sendNewPostMail($title, $blogid);
    }
    emDirect("./article.php?active_post=1");
}

// Edit article (save and return)
$page = $Log_Model->getPageOffset($postDate);
emDirect("./article.php?active_savelog=1&page=" . $page);
