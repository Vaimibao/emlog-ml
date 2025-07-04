<?php

/**
 * Sidebar components, modules page
 */
defined('EMLOG_ROOT') || exit('access denied!');

load_language('templates/default');

?>
<?php
/**
 * widget:link
 */
function widget_link($title)
{
    global $CACHE;
    $link_cache = $CACHE->readCache('link');
    //if (!blog_tool_ishome()) return;//Only show the friend link on the homepage and remove the double slash comment
?>
    <div class="widget shadow-theme">
        <div class="widget-title">
            <h3><?= $title ?></h3>
        </div>
        <ul class="widget-list no-margin-bottom unstyle-li">
            <?php
            foreach ($link_cache as $value):
                $icon = isset($value['icon']) ? $value['icon'] : '';
            ?>
                <li style="display: flex; align-items: center;">
                    <?php if ($icon): ?>
                        <img src="<?= $icon ?>" height="20" width="20" class="rounded" style="margin-right: 5px;">
                    <?php endif; ?>
                    <a href="<?= $value['url'] ?>" title="<?= $value['des'] ?>" target="_blank"><?= $value['link'] ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:blogger
 */
function widget_blogger($title)
{
    $userModel = new User_Model();
    $uid = UID ?: 1;
    $name = '';
    $description = '';
    $avatar = BLOG_URL . "admin/views/images/avatar.svg";
    $user = $userModel->getOneUser($uid);
    if ($user) {
        $name = $user['nickname'];
        //$description = $user['description'];
        $description = $user['description_orig'];
        $avatar = User::getAvatar($user['photo']);
    }
?>
    <div class="widget shadow-theme">
        <div class="unstyle-li bloggerinfo">
            <div>
                <a href="./admin/blogger.php"><img class='bloggerinfo-img' src="<?= $avatar ?>" alt="blogger" /></a>
            </div>
            <div class='bloginfo-name'><b><?= $name ?></b></div>
            <div class='bloginfo-descript'><?= $description ?></div>
        </div>
    </div>
<?php } ?>
<?php
/**
 * widget:calendar
 */
function widget_calendar($title)
{ ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <div class="unstyle-li">
            <div id="calendar"></div>
            <script>
                sendinfo('<?= Calendar::url() ?>', 'calendar');
            </script>
        </div>
    </div>
<?php } ?>
<?php
/**
 * widget:Tags
 */
function widget_tag($title)
{
    global $CACHE;
    $tag_cache = $CACHE->readCache('tags') ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <div class="unstyle-li tag-container">
            <?php foreach ($tag_cache as $value): ?>
                <span style="font-size:<?= $value['fontsize'] ?>pt; line-height:30px;">
                    <a href="<?= Url::tag($value['tagurl']) ?>" title="<?= $value['usenum'] ?> <?= lang('_posts') ?>" class='tags-side'><?= $value['tagname'] ?></a></span>
            <?php endforeach ?>
        </div>
    </div>
<?php } ?>
<?php
/**
 * widget:Sort
 */
function widget_sort($title)
{
    global $CACHE;
    $sort_cache = $CACHE->readCache('sort') ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li log-classify-f">
            <?php
            foreach ($sort_cache as $value):
                if ($value['pid'] != 0)
                    continue;
            ?>
                <li>
                    <a href="<?= Url::sort($value['sid']) ?>" title="<?= $value["description"] ?>"><?= $value['sortname'] ?>
                        &nbsp;&nbsp;<?= (($value['lognum']) > 0) ? '(' . ($value['lognum']) . ')' : '' ?></a>
                    <?php if (!empty($value['children'])): ?>
                        <ul class="log-classify-c">
                            <?php
                            $children = $value['children'];
                            foreach ($children as $key):
                                $value = $sort_cache[$key];
                            ?>
                                <li>
                                    <a href="<?= Url::sort($value['sid']) ?>" title="<?= $value["description"] ?>">--&nbsp;&nbsp;<?= $value['sortname'] ?>
                                        &nbsp;&nbsp;(<?= $value['lognum'] ?>)</a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget: Latest Notes
 */
function widget_twitter($title)
{
    global $CACHE;
    $index_newtwnum = Option::get('index_newtwnum') ?: 10;
    $Twitter_Model = new Twitter_Model();
    $ts = $Twitter_Model->getTwitters('', 1, $index_newtwnum);
    $user_cache = $CACHE->readCache('user');
?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li">
            <?php foreach ($ts as $value):
                $author = $user_cache[$value['author']]['name'];
            ?>
                <li>
                    <?= $value['t']; ?>
                    <span class='comm-lates-name'><?= $author ?></span>
                    <span class='logcom-latest-time'><?= $value['date'] ?></span><br />
                    <hr>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:Latest Comments
 */
function widget_newcomm($title)
{
    global $CACHE;
    $com_cache = $CACHE->readCache('comment');
?>
    <div class="widget shadow-theme">
        <div class="widget-title">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li">
            <?php
            foreach ($com_cache as $value):
                $url = Url::comment($value['gid'], $value['page'], $value['cid']);
                $avatar = getEmUserAvatar($value['uid'], $value['mail']);
            ?>
                <li class="comment-info">
                    <img class='comment-info_img' src="<?= $avatar ?>" alt="commentator" />
                    <span class='comm-lates-name'><?= $value['name'] ?></span>
                    <span class='logcom-latest-time'><?= smartDate($value['date']) ?></span><br />
                    <a href="<?= $url ?>"><?= $value['content'] ?></a>
                    <hr>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:Latest Posts
 */
function widget_newlog($title)
{
    $Log_Model = new Log_Model();
    $newLogs = $Log_Model->getLogsForHome(' ORDER BY date DESC', 1, (int)Option::get('index_newlognum'));
?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li">
            <?php foreach ($newLogs as $value): ?>
                <li class="blog-lates" style="position: relative;">
                    <?php if ($value['log_cover']): ?>
                        <div class="side-cover-image" style="background-image: url('<?= $value['log_cover'] ?>');">
                            <div class="side-title-container">
                                <a href="<?= $value['log_url'] ?>"><?= $value['log_title'] ?></a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= $value['log_url'] ?>"><?= $value['log_title'] ?></a>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:Popular Posts
 */
function widget_hotlog($title)
{
    $index_hotlognum = Option::get('index_hotlognum');
    $Log_Model = new Log_Model();
    $hotLogs = $Log_Model->getHotLog($index_hotlognum) ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li">
            <?php foreach ($hotLogs as $value): ?>
                <li class="blog-lates" style="position: relative;">
                    <?php if ($value['cover']): ?>
                        <div class="side-cover-image" style="background-image: url('<?= $value['cover'] ?>');">
                            <div class="side-title-container">
                                <a href="<?= Url::log($value['gid']) ?>"><?= $value['title'] ?></a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= Url::log($value['gid']) ?>"><?= $value['title'] ?></a>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget: Search
 */
function widget_search($title)
{ ?>
    <div class="widget shadow-theme">
        <div class="widget-title">
            <h3><?= $title ?></h3>
        </div>
        <div class="unstyle-li" style="text-align: center;">
            <form name="keyform" method="get" action="<?= BLOG_URL ?>index.php">
                <input name="keyword" class="search form-control" autocomplete="off" aria-label="Search" type="search" />
                <input type="submit" value="搜索">
            </form>
        </div>
    </div>
<?php } ?>
<?php
/**
 * widget:Archive
 */
function widget_archive($title)
{
    $bar_id = "36";
    global $CACHE;
    $record_cache = $CACHE->readCache('record');
?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <select id="archive" class="archive">
            <?php foreach ($record_cache as $value): ?>
                <option value="<?= Url::record($value['date']) ?>"><?= $value['record'] ?>&nbsp;(<?= $value['lognum'] ?>)</option>
            <?php endforeach ?>
        </select>
    </div>
<?php } ?>
<?php
/**
 * widget:Custom widget
 */
function widget_custom_text($title, $content)
{ ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li">
            <?= $content ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * Top: Navigation
 */
function blog_navi()
{
    global $CACHE;
    $navi_cache = $CACHE->readCache('navi');
?>
    <div class="blog-header-nav" id="navbarResponsive">
        <ul class="nav-list">
            <?php
            foreach ($navi_cache as $value):
                if ($value['pid'] != 0) {
                    continue;
                }
                if ($value['url'] == 'admin' && (!User::isVisitor())):
            ?>
                    <li class="list-item list-menu"><a href="<?= BLOG_URL ?>admin/" class="nav-link"><?= lang('site_management') ?></a></li>
                    <li class="list-item list-menu"><a href="<?= BLOG_URL ?>admin/account.php?action=logout" class="nav-link"><?= lang('logout') ?></a></li>
                <?php
                    continue;
                endif;
                $newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
                $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
                $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'active' : '';
                ?>
                <?php if (!empty($value['children']) || !empty($value['childnavi'])) : ?>
                    <li class="list-item list-menu">
                        <?php if (!empty($value['children'])): ?>
                            <a class="nav-link has-down" id="nav_link" href="<?= $value['url'] ?>" <?= $newtab ?>><?= $value['naviname'] ?></a>
                            <ul class="dropdown-menus">
                                <?php foreach ($value['children'] as $row) {
                                    echo '<li class="list-item list-menu"><a class="nav-link" href="' . Url::sort($row['sid']) . '">' . $row['sortname'] . '</a></li>';
                                } ?>
                            </ul>
                        <?php endif ?>
                        <?php if (!empty($value['childnavi'])) : ?>
                            <a class='nav-link has-down' id="nav_link" href="<?= $value['url'] ?>" <?= $newtab ?>><?= $value['naviname'] ?></a>
                            <ul class="dropdown-menus">
                                <?php foreach ($value['childnavi'] as $row) {
                                    $newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
                                    echo '<li class="list-item list-menu"><a class="nav-link" href="' . $row['url'] . "\" $newtab >" . $row['naviname'] . '</a></li>';
                                } ?>
                            </ul>
                        <?php endif ?>
                    </li>
                <?php else: ?>
                    <li class="list-item list-menu"><a class="nav-link" href="<?= $value['url'] ?>" <?= $newtab ?>><?= $value['naviname'] ?></a></li>
                <?php endif ?>
            <?php endforeach ?>
            <li class="list-item list-menu"><span class="iconfont icon-DarkTheme" id="theme-toggle"></span></li>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * Article List Card: Top Mark
 */
function topflg($top, $sortop = 'n', $sortid = null)
{
    $ishome_flg = '<span class="log-topflg" >' . lang('home_top') . '</span>';
    $issort_flg = '<span class="log-topflg" >' . lang('category_top') . '</span>';
    if (blog_tool_ishome()) {
        echo $top == 'y' ? $ishome_flg : '';
    } elseif ($sortid) {
        echo $sortop == 'y' ? $issort_flg : '';
    }
}

?>
<?php
/**
 * Article details page: edit link
 */
function editflg($logid, $author)
{
    $editflg = User::haveEditPermission() || $author == UID ? '<a href="' . BLOG_URL . 'admin/article.php?action=edit&gid=' . $logid . '" target="_blank"><span class="iconfont icon-edit"></span></a>' : '';
    echo $editflg;
}

?>
<?php
/**
 * Article details page: Category
 */
function blog_sort($sortID)
{
    $Sort_Model = new Sort_Model();
    $r = $Sort_Model->getOneSortById($sortID);
    $sortName = isset($r['sortname']) ? $r['sortname'] : '';
?>
    <?php if (!empty($sortName)) { ?>
        <a href="<?= Url::sort($sortID) ?>"><?= $sortName ?></a>
<?php }
} ?>
<?php
/**
 * Home Article List: Categories
 */
function bloglist_sort($sortID)
{
    $Sort_Model = new Sort_Model();
    $r = $Sort_Model->getOneSortById($sortID);
    $sortName = isset($r['sortname']) ? $r['sortname'] : '';
?>
    <?php if (!empty($sortName)) { ?>
        <span class="loglist-sort">
            <a href="<?= Url::sort($sortID) ?>"><?= $sortName ?></a>
        </span>
<?php }
} ?>
<?php
/**
 * Homepage article list and article details page: tags
 */
function blog_tag($blogid)
{
    $tag_model = new Tag_Model();
    $tag_ids = $tag_model->getTagIdsFromBlogId($blogid);
    $tag_names = $tag_model->getNamesFromIds($tag_ids);
    if (!empty($tag_names)) {
        $tag = '';
        foreach ($tag_names as $value) {
            $tag .= "    <a href=\"" . Url::tag(rawurlencode($value)) . "\" class='tags' title='标签' >" . htmlspecialchars($value) . '</a>';
        }
        echo $tag;
    }
}

?>
<?php
/**
 * Home page article list and article details page: Author
 */
function blog_author($uid)
{
    $User_Model = new User_Model();
    $user_info = $User_Model->getOneUser($uid);
    $author = $user_info['nickname'];
    echo '<a href="' . Url::author($uid) . "\">$author</a>";
}

?>
<?php
/**
 * Article Details Page: Adjacent Articles
 */
function neighbor_log($neighborLog)
{
    extract($neighborLog) ?>
    <?php if ($prevLog): ?>
        <span class="prev-log"><a href="<?= Url::log($prevLog['gid']) ?>" title="上一篇：<?= $prevLog['title'] ?>"><span class="iconfont icon-prev"></span></a></span>
    <?php endif ?>
    <?php if ($nextLog): ?>
        <span class="next-log"><a href="<?= Url::log($nextLog['gid']) ?>" title="下一篇：<?= $nextLog['title'] ?>"><span class="iconfont icon-next"></span></a></span>
    <?php endif ?>
<?php } ?>
<?php
/**
 * Article details page: comment list
 */
function blog_comments($comments, $comnum)
{
    extract($comments);
    if ($commentStacks): ?>
        <div class="comment-header"><b><?= lang('received') ?><?= $comnum ?><?= lang('comment_received') ?></b></div>
    <?php endif ?>
    <?php
    foreach ($commentStacks as $cid):
        $comment = $comments[$cid];
    ?>
        <div class="comment" id="<?= $comment['cid'] ?>">
            <?php
            $avatar = getEmUserAvatar($comment['uid'], $comment['mail']);
            ?>
            <div class="avatar"><img src="<?= $avatar ?>" alt="avatar" /></div>
            <div class="comment-infos">
                <div class="arrow"></div>
                <b><?= $comment['poster'] ?> </b><span class="comment-time"><?= $comment['date'] ?></span>
                <div class="comment-content"><?= $comment['content'] ?></div>
                <div class="comment-reply">
                    <span class="com-reply"><?= lang('reply') ?></span>
                </div>
            </div>
            <?php blog_comments_children($comments, $comment['children']) ?>
        </div>
    <?php endforeach ?>
    <div id="pagenavi">
        <?= $commentPageUrl ?>
    </div>
<?php } ?>
<?php
/**
 * Article details page: sub-comments
 */
function blog_comments_children($comments, $children)
{
    foreach ($children as $child):
        $comment = $comments[$child];
?>
        <div class="comment comment-children" id="<?= $comment['cid'] ?>">
            <?php
            $avatar = getEmUserAvatar($comment['uid'], $comment['mail']);
            ?>
            <div class="avatar"><img src="<?= $avatar ?>" alt="commentator" /></div>
            <div class="comment-infos">
                <div class="arrow"></div>
                <b><?= $comment['poster'] ?> </b><span class="comment-time"><?= $comment['date'] ?></span>
                <div class="comment-content"><?= $comment['content'] ?></div>
                <?php if ($comment['level'] < 4): ?>
                    <div class="comment-reply">
                        <span class="com-reply comment-replay-btn"><?= lang('reply') ?></span>
                    </div>
                <?php endif ?>
            </div>
            <?php blog_comments_children($comments, $comment['children']) ?>
        </div>
    <?php endforeach ?>
<?php } ?>
<?php
/**
 * Article Details Page: Comment Form
 */
function blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark)
{
    $isLoginComment = Option::get('login_comment');
    if ($allow_remark == 'y'): ?>
        <div id="comments">
            <div class="comment-post" id="comment-post">
                <form class="commentform" method="post" name="commentform" action="<?= BLOG_URL ?>index.php?action=addcom" id="commentform">
                    <input type="hidden" name="gid" value="<?= $logid ?>" />
                    <textarea class="form-control log_comment" name="comment" id="comment" rows="10" tabindex="4" placeholder="撰写评论" required></textarea>
                    <?php if (User::isVisitor() && $isLoginComment === 'n'): ?>
                        <div class="comment-info" id="comment-info">
                            <input class="form-control com_control comment-name" id="info_n" autocomplete="off" type="text" name="comname" maxlength="49"
                                value="<?= $ckname ?>" size="22"
                                tabindex="1" placeholder="<?= lang('nickname') ?>*" required />
                            <input class="form-control com_control comment-mail" id="info_m" autocomplete="off" type="email" name="commail" maxlength="128"
                                value="<?= $ckmail ?>" size="22"
                                tabindex="2" placeholder="<?= lang('email') ?>" />
                        </div>
                    <?php endif ?>
                    <span class="com_submit_p">
                        <?php if (User::isVisitor() && $isLoginComment === 'y'): ?>
                            <?= lang('need_logged_reply') ?>
                        <?php else: ?>
                            <input class="btn" <?php if ($verifyCode != "") { ?> type="button" data-toggle="modal" data-target="#myModal" <?php } else { ?> type="submit" <?php } ?>
                                id="comment_submit" value="<?= lang('comment_leave') ?>" tabindex="6" />
                        <?php endif; ?>
                    </span>
                    <?php if ($verifyCode != "") { ?>
                        <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="display: table-cell;">
                                    <input type="hidden" id="blog_url" value="<?= BLOG_URL ?>" />
                                    <div class="modal-header" style="border-bottom: 0;"><?= lang('enter_captcha') ?></div>
                                    <?= $verifyCode ?>
                                    <div class="modal-footer" style="border-top: 0;">
                                        <button type="button" class="btn" id="close-modal" data-dismiss="modal"><?= lang('close') ?></button>
                                        <button type="submit" class="btn" id="comment_submit2"><?= lang('submit') ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="lock-screen"></div>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="pid" id="comment-pid" value="0" tabindex="1" />
                </form>
            </div>
        </div>
    <?php endif ?>
<?php } ?>
<?php
/**
 * Helper function: whether it is the home page
 */
function blog_tool_ishome()
{
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL) {
        return true;
    } else {
        return FALSE;
    }
}
?>
<?php
function getEmUserAvatar($uid, $mail)
{
    $avatar = '';
    if ($uid) {
        $userModel = new User_Model();
        $user = $userModel->getOneUser($uid);
        $avatar = User::getAvatar($user['photo']);
    } elseif ($mail) {
        $avatar = getGravatar($mail);
    }
    return $avatar ?: BLOG_URL . "admin/views/images/avatar.svg";
}
?>