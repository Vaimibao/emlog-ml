<?php
defined('EMLOG_ROOT') || exit('access denied!');
$isdraft = $draft ? '&draft=1' : '';
?>
<?php if (isset($_GET['active_up'])): ?>
    <div class="alert alert-success"><?= lang('sticked_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_down'])): ?>
    <div class="alert alert-success"><?= lang('unsticked_ok') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= lang('select_post_to_operate') ?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger"><?= lang('select_action_to_perform') ?></div><?php endif ?>
<?php if (isset($_GET['active_post'])): ?>
    <div class="alert alert-success"><?= lang('published_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_move'])): ?>
    <div class="alert alert-success"><?= lang('moved_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_change_author'])): ?>
    <div class="alert alert-success"><?= lang('user_modified_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_hide'])): ?>
    <div class="alert alert-success"><?= lang('draft_moved_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_savedraft'])): ?>
    <div class="alert alert-success"><?= lang('draft_saved_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_savelog'])): ?>
    <div class="alert alert-success"><?= lang('saved_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_ck'])): ?>
    <div class="alert alert-success"><?= lang('verified_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_unck'])): ?>
    <div class="alert alert-success"><?= lang('rejected_ok') ?></div><?php endif ?>
<?php if (isset($_GET['error_post_per_day'])): ?>
    <div class="alert alert-danger"><?= lang('daily_posts_exceed') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php if (User::haveEditPermission()): ?>
        <h1 class="h4 mb-0 text-gray-800 mt-3"><?= $draft ? lang('drafts') : lang('articles') ?></h1>
        <a href="./article.php?action=write" class="btn btn-sm btn-success shadow-sm mt-4"><i class="icofont-pencil-alt-5"></i> <?= lang('article_add') ?></a>
    <?php else: ?>
        <h1 class="h4 mb-0 text-gray-800 mt-3"><?= $draft ? lang('draft') : Option::get("posts_name") ?></h1>
        <div>
            <?php if (!$draft) : ?>
                <a href="article.php?draft=1" class="btn btn-sm btn-primary shadow-sm mt-4"><?= lang('drafts') ?></a>
            <?php else: ?>
                <a href="article.php" class="btn btn-sm btn-primary shadow-sm mt-4"><?= Option::get("posts_name") ?></a>
            <?php endif; ?>
            <a href="./article.php?action=write" class="btn btn-sm btn-success shadow-sm mt-4"><i class="icofont-plus"></i> <?= lang('publish_new') ?><?= Option::get("posts_name") ?></a>
        </div>
    <?php endif; ?>
</div>
<div class="card mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="form-inline">
                <div id="f_t_sort" class="mx-1">
                    <select name="bysort" id="bysort" onChange="selectSort(this);" class="form-control">
                        <option value="" selected="selected"><?= lang('category_view') ?></option>
                        <?php
                        foreach ($sorts as $key => $value):
                            if ($value['pid'] != 0) {
                                continue;
                            }
                            $flg = $value['sid'] == $sid ? 'selected' : '';
                        ?>
                            <option value="<?= $value['sid'] ?>" <?= $flg ?>><?= $value['sortname'] ?></option>
                            <?php
                            $children = $value['children'];
                            foreach ($children as $key):
                                $value = $sorts[$key];
                                $flg = $value['sid'] == $sid ? 'selected' : '';
                            ?>
                                <option value="<?= $value['sid'] ?>" <?= $flg ?>>&nbsp; &nbsp; &nbsp; <?= $value['sortname'] ?></option>
                        <?php
                            endforeach;
                        endforeach;
                        ?>
                        <option value="-1" <?php if ($sid == -1)
                                                echo 'selected' ?>><?= lang('uncategorized') ?>
                        </option>
                    </select>
                </div>
                <div id="f_t_order" class="mx-1">
                    <select name="order" id="order" onChange="selectOrder(this);" class="form-control">
                        <option value="date" <?= (empty($order)) ? 'selected' : '' ?>><?= lang('view_by_new') ?></option>
                        <option value="top" <?= ($order === 'top') ? 'selected' : '' ?>><?= lang('view_by_top') ?></option>
                        <option value="comm" <?= ($order === 'comm') ? 'selected' : '' ?>><?= lang('view_by_comment_count') ?></option>
                        <option value="view" <?= ($order === 'view') ? 'selected' : '' ?>><?= lang('view_by_views_count') ?></option>
                    </select>
                </div>
            </div>
            <form action="article.php" method="get">
                <div class="form-inline search-inputs-nowrap">
                    <input type="text" name="keyword" class="form-control m-1 small" placeholder="<?= lang('search_for') ?>" aria-label="<?= lang('search') ?>" aria-describedby="basic-addon2">
                    <input type="hidden" name="draft" value="<?= $draft ?>">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-success" type="submit">
                            <i class="icofont-search-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <form action="article.php?action=operate_log" method="post" name="form_log" id="form_log">
            <input type="hidden" name="draft" value="<?= $draft ?>">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable no-footer">
                    <thead>
                        <tr>
                            <th><input class="" type="checkbox" id="checkAllItem" /></th>
                            <th><?= lang('title') ?></th>
                            <th><?= lang('comments') ?></th>
                            <th><?= lang('views') ?></th>
                            <th><?= lang('user') ?></th>
                            <th><?= lang('category') ?></th>
                            <th><?= lang('time') ?></th>
                            <th><?= lang('operation') ?></th>
                        </tr>
                    </thead>
                    <tbody class="checkboxContainer">
                        <?php
                        $multiCheckBtn = false; // Whether to display batch approval reject button at most comments
                        foreach ($logs as $key => $value):
                            $sortName = isset($sorts[$value['sortid']]['sortname']) ? $sorts[$value['sortid']]['sortname'] : lang('unknown_cate');
                            $sortName = $value['sortid'] == -1 ? lang('uncategorized') : $sortName;
                            $author = isset($user_cache[$value['author']]['name']) ? $user_cache[$value['author']]['name'] : lang('unknown_author');
                            $author_role = isset($user_cache[$value['author']]['role']) ? $user_cache[$value['author']]['role'] : lang('unknown_role');
                            $logTags = [];
                            if ($value['tags']) {
                                $logTags = $Tag_Model->getNamesFromIdStr($value['tags']);
                            }
                        ?>
                            <tr>
                                <td style="width: 20px;"><input type="checkbox" name="blog[]" value="<?= $value['gid'] ?>" class="ids" /></td>
                                <td>
                                    <a href="article.php?action=edit&gid=<?= $value['gid'] ?>"><?= $value['title'] ?></a>
                                    <a href="<?= Url::log($value['gid']) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
                                    <?php if ($value['top'] == 'y'): ?><span class="badge small badge-success"><?= lang('home_top') ?></span><?php endif ?>
                                    <?php if ($value['sortop'] == 'y'): ?><span class="badge small badge-info"><?= lang('category_top') ?></span><?php endif ?>
                                    <?php if (!$draft && $value['timestamp'] > time()): ?><span class="badge small badge-warning"><?= lang('publish_regular') ?></span><?php endif ?>
                                    <?php if ($value['password']): ?><span class="small">🔒</span><?php endif ?>
                                    <?php if ($value['link']): ?><span class="small">🔗</span><?php endif ?>
                                    <?php if (!$draft && $value['checked'] == 'n'): ?>
                                        <span class="badge small badge-secondary"><?= lang('is_pending') ?></span>
                                        <?= $value['feedback'] ? '<br><small class="text-secondary">' . lang('feedback_review') . $value['feedback'] . '</small>' : '' ?>
                                    <?php endif ?>
                                    <br>
                                    <span class="small"> ID:<?= $value['gid'] ?></span>
                                    <?php if ($value['alias']): ?> <span class="small">(<?= $value['alias'] ?>)</span><?php endif ?>
                                    <?php foreach ($logTags as $tid => $t): ?>
                                        <a href="./article.php?tagid=<?= $tid . $isdraft ?>" class='em-badge small em-badge-tag'><?= htmlspecialchars($t) ?></a>
                                    <?php endforeach; ?>
                                </td>
                                <td><a href="comment.php?gid=<?= $value['gid'] ?>" class="badge badge-primary mx-1 px-2"><?= $value['comnum'] ?></a></td>
                                <td><a href="<?= Url::log($value['gid']) ?>" class="badge badge-success  mx-1 px-2" target="_blank"><?= $value['views'] ?></a></td>
                                <td class="small"><a href="article.php?uid=<?= $value['author'] . $isdraft ?>"><?= $author ?></a></td>
                                <td><a href="article.php?sid=<?= $value['sortid'] . $isdraft ?>" class="badge badge-light-gray"><?= $sortName ?></a></td>
                                <td class="small"><?= $value['date'] ?></td>
                                <td>
                                    <?php if ($draft): ?>
                                        <a href="article.php?action=pub&gid=<?= $value['gid'] ?>" class="badge badge-success"><?= lang('publish') ?></a>
                                        <a href="javascript: em_confirm(<?= $value['gid'] ?>, 'draft', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= lang('delete') ?></a>
                                    <?php else: ?>
                                        <a class="badge badge-primary" href="#" data-tag="<?= implode(',', $logTags) ?>" data-gid="<?= $value['gid'] ?>" data-toggle="modal" data-target="#tagModel"><?= lang('tags') ?></a>
                                        <a href="javascript: em_confirm(<?= $value['gid'] ?>, 'article', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= lang('delete') ?></a>
                                    <?php endif ?>
                                    <?php if (!$draft && User::haveEditPermission() && $value['checked'] == 'n'): ?>
                                        <a class="badge badge-success"
                                            href="article.php?action=operate_log&operate=check&gid=<?= $value['gid'] ?>&token=<?= LoginAuth::genToken() ?>"><?= lang('check') ?></a>
                                    <?php endif ?>
                                    <?php
                                    if (!$draft && User::haveEditPermission() && $author_role == User::ROLE_WRITER):
                                        $multiCheckBtn = true;
                                    ?>
                                        <a class="badge badge-warning" href="#" data-gid="<?= $value['gid'] ?>" data-toggle="modal" data-target="#uncheckModel"><?= lang('uncheck') ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            <input name="operate" id="operate" value="" type="hidden" />
            <input name="author" id="author" value="" type="hidden" />
            <div class="form-inline">
                <div class="btn-group">
                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><?= lang('operation')?></button>
                    <div class="dropdown-menu">
                        <?php if ($multiCheckBtn): ?>
                            <a href="javascript:logact('check');" class="dropdown-item"><?= lang('check') ?></a>
                            <a href="javascript:logact('uncheck');" class="dropdown-item"><?= lang('uncheck') ?></a>
                            <hr>
                        <?php endif ?>
                        <?php if ($draft): ?>
                            <a href="javascript:logact('pub');" class="dropdown-item"><?= lang('publish') ?></a>
                            <a href="javascript:logact('del_draft');" class="dropdown-item text-danger"><?= lang('delete') ?></a>
                        <?php else: ?>
                            <?php if (User::haveEditPermission()): ?>
                                <a href="javascript:logact('top');" class="dropdown-item"><?= lang('home_top') ?></a>
                                <a href="javascript:logact('sortop');" class="dropdown-item"><?= lang('category_top') ?></a>
                                <a href="javascript:logact('notop');" class="dropdown-item"><?= lang('untop') ?></a>
                                <hr>
                                <a href="javascript:changeAuthorAlert();" class="dropdown-item"><?= lang('user_edit') ?></a>
                                <hr>
                            <?php endif ?>
                            <a href="javascript:logact('hide');" class="dropdown-item"><?= lang('add_draft') ?></a>
                            <a href="javascript:logact('del');" class="dropdown-item text-danger"><?= lang('delete') ?></a>
                        <?php endif ?>
                    </div>
                </div>
                <select name="sort" id="sort" onChange="changeSort(this);" class="form-control form-control-sm m-1">
                    <option value="" selected="selected"><?= lang('move_to_category') ?></option>
                    <?php
                    foreach ($sorts as $key => $value):
                        if ($value['pid'] != 0) {
                            continue;
                        }
                    ?>
                        <option value="<?= $value['sid'] ?>"><?= $value['sortname'] ?></option>
                        <?php
                        $children = $value['children'];
                        foreach ($children as $key):
                            $value = $sorts[$key];
                        ?>
                            <option value="<?= $value['sid'] ?>">&nbsp; &nbsp;
                                &nbsp; <?= $value['sortname'] ?></option>
                    <?php
                        endforeach;
                    endforeach;
                    ?>
                    <option value="-1"><?= lang('uncategorized') ?></option>
                </select>
            </div>
        </form>
    </div>
</div>
<div class="page"><?= $pageurl ?> </div>
<div class="d-flex justify-content-center mb-4 small">
    <div class="form-inline">
        <label for="perpage_num" class="mr-2"><?= lang('have') ?> <?= $logNum ?> <?= lang('number_of_items')?><?= $draft ? lang('_drafts') : lang('_articles') ?><?= lang('per_page_show') ?></label>
        <select name="perpage_num" id="perpage_num" class="form-control form-control-sm" onChange="changePerPage(this);">
            <option value="10" <?= ($perPage == 10) ? 'selected' : '' ?>>10</option>
            <option value="20" <?= ($perPage == 20) ? 'selected' : '' ?>>20</option>
            <option value="50" <?= ($perPage == 50) ? 'selected' : '' ?>>50</option>
            <option value="100" <?= ($perPage == 100) ? 'selected' : '' ?>>100</option>
            <option value="500" <?= ($perPage == 500) ? 'selected' : '' ?>>500</option>
        </select>
    </div>
    <script>
        function changePerPage(select) {
            const params = new URLSearchParams(window.location.search);
            params.set('perpage_num', select.value);
            params.set('page', '1');
            window.location.search = params.toString();
        }
    </script>
</div>
<!--Article reject-->
<div class="modal fade" id="uncheckModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('article_reject') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="article.php?action=operate_log&operate=uncheck&token=<?= LoginAuth::genToken() ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <textarea name="feedback" type="text" maxlength="512" class="form-control" placeholder="<?= lang('article_reject_prompt') ?>"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" value="" name="gid" id="gid" />
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-warning"><?= lang('uncheck') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Set tags-->
<div class="modal fade" id="tagModel" tabindex="-1" role="dialog" aria-labelledby="tagModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="tagModelLabel"><?= lang('tags') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="article.php?action=tag" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input name="tag" id="tag" class="form-control" value="" />
                        <input type="hidden" value="" name="gid" id="gid" />
                        <small class="text-muted"><?= lang('tag_separated') ?></small>
                    </div>
                    <?php if ($tags): ?>
                        <div id="tags" class="mb-2">
                            <?php
                            foreach ($tags as $val) {
                                echo " <a class=\"em-badge small em-badge-tag\" href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function logact(act) {
        if (getChecked('ids') === false) {
            infoAlert('<?= lang('select_article') ?>');
            return;
        }

        if (act === 'del') {
            layer.confirm('<?= lang('deleted_not_recoverable') ?>', {
                title: '<?= lang('sure_delete_articles') ?>',
                icon: 0,
                btn: ['<?= lang('add_draft') ?>', '<span class="text-danger"><?= lang('deleted_permanently') ?></span>', '<?= lang('cancel') ?>']
            }, function(index) {
                $("#operate").val("hide");
                $("#form_log").submit();
                layer.close(index);
            }, function(index) {
                localStorage.setItem('alert_action_success', '<?= lang('delete') ?>');
                $("#operate").val(act);
                $("#form_log").submit();
                layer.close(index);
            });
            return;
        }

        if (act === 'del_draft') {
            delAlert2('', '<?= lang('deleted_select_draft') ?>', function() {
                localStorage.setItem('alert_action_success', '<?= lang('delete') ?>');
                $("#operate").val("del");
                $("#form_log").submit();
            })
            return;
        }

        $("#operate").val(act);
        $("#form_log").submit();
    }

    function changeSort(obj) {
        if (getChecked('ids') === false) {
            infoAlert('<?= lang('select_article') ?>');
            return;
        }
        if ($('#sort').val() === '') return;
        $("#operate").val('move');
        $("#form_log").submit();
    }

    function changeAuthor(obj) {
        if (getChecked('ids') === false) {
            infoAlert('<?= lang('select_article') ?>');
            return;
        }
        if ($('#author').val() === '') return;
        $("#operate").val('change_author');
        $("#form_log").submit();
    }

    function selectSort(obj) {
        window.open("./article.php?sid=" + obj.value + "<?= $isdraft ?>", "_self");
    }

    function selectOrder(obj) {
        window.open("./article.php?order=" + obj.value + "<?= $isdraft ?>", "_self");
    }

    $(function() {
        $("#menu_category_content").addClass('active');
        $("#menu_content").addClass('show');
        $("#menu_<?= $draft ? 'draft' : 'log' ?>").addClass('active');
        setTimeout(hideActived, 3600);

        $('#uncheckModel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var gid = button.data('gid')
            var modal = $(this)
            modal.find('.modal-footer #gid').val(gid)
        })

        $('#tagModel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var tag = button.data('tag')
            var gid = button.data('gid')
            var modal = $(this)
            modal.find('.modal-body #tag').val(tag)
            modal.find('.modal-body #gid').val(gid)
        })
    });
</script>