<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_save'])): ?>
    <div class="alert alert-success"><?= lang('saved_ok') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= lang('category_name_empty') ?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger"><?= lang('alias_format_invalid') ?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger"><?= lang('alias_unique') ?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger"><?= lang('alias_no_keywords') ?></div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger"><?= lang('not_parent_category') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800 mt-3"><?= lang('category_management') ?></h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#sortModal"><i class="icofont-plus"></i> 添加分类</a>
</div>
<form method="post" id="sort_form" action="sort.php?action=taxis">
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive" id="adm_sort_list">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th><?= lang('cover') ?></th>
                            <th><?= lang('name') ?></th>
                            <th><?= lang('description') ?></th>
                            <th><?= lang('category_id') ?></th>
                            <th><?= lang('alias') ?></th>
                            <th><?= lang('articles') ?></th>
                            <th><?= lang('operation') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($sorts as $key => $value):
                            if ($value['pid'] != 0) {
                                continue;
                            }
                        ?>
                            <tr style="cursor: move">
                                <td>
                                    <div class="flex-shrink-0">
                                        <?php if ($value['sortimg']): ?>
                                            <img src="<?= $value['sortimg'] ?>" height="55" class="rounded" />
                                        <?php else: ?>
                                            <img src="<?= './views/images/null.png' ?>" height="55" class="rounded" />
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="sortname">
                                    <input type="hidden" value="<?= $value['sid'] ?>" class="sort_id" />
                                    <input type="hidden" name="sort[]" value="<?= $value['sid'] ?>" />
                                    <a href="#" data-toggle="modal" data-target="#sortModal"
                                        data-sid="<?= $value['sid'] ?>"
                                        data-sortname="<?= $value['sortname'] ?>"
                                        data-alias="<?= $value['alias'] ?>"
                                        data-description="<?= $value['description'] ?>"
                                        data-kw="<?= $value['kw'] ?>"
                                        data-title="<?= $value['title_origin'] ?>"
                                        data-pid="<?= $value['pid'] ?>"
                                        data-sortimg="<?= $value['sortimg'] ?>"
                                        data-page_count="<?= $value['page_count'] ?>"
                                        data-allow_user_post="<?= $value['allow_user_post'] ?>"
                                        data-template="<?= $value['template'] ?>">
                                        <?= $value['sortname'] ?>
                                    </a>
                                    <a href="<?= Url::sort($value['sid']) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
                                    <?php if ($value['allow_user_post'] == 'n'): ?>
                                        <br><span class="badge small badge-orange"><?= lang('no_contribution') ?></span>
                                    <?php endif ?>
                                </td>
                                <td><?= subString($value['description'], 0, 100) ?></td>
                                <td><?= $value['sid'] ?></td>
                                <td class="alias"><?= $value['alias'] ?></td>
                                <td><a href="article.php?sid=<?= $value['sid'] ?>"><?= $value['lognum'] ?></a></td>
                                <td>
                                    <a href="javascript: em_confirm(<?= $value['sid'] ?>, 'sort', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= lang('delete') ?></a>
                                </td>
                            </tr>
                            <?php
                            $children = $value['children'];
                            foreach ($children as $key):
                                $value = $sorts[$key];
                            ?>
                                <tr>
                                    <td>
                                        <div class="flex-shrink-0">
                                            <?php if ($value['sortimg']): ?>
                                                <img src="<?= $value['sortimg'] ?>" height="55" class="rounded" />
                                            <?php else: ?>
                                                <img src="<?= './views/images/null.png' ?>" height="55" class="rounded" />
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="sortname">
                                        <input type="hidden" value="<?= $value['sid'] ?>" class="sort_id" />
                                        <input type="hidden" name="sort[]" value="<?= $value['sid'] ?>" />
                                        ---- <a href="#" data-toggle="modal" data-target="#sortModal"
                                            data-sid="<?= $value['sid'] ?>"
                                            data-sortname="<?= $value['sortname'] ?>"
                                            data-alias="<?= $value['alias'] ?>"
                                            data-description="<?= $value['description'] ?>"
                                            data-kw="<?= $value['kw'] ?>"
                                            data-title="<?= $value['title_origin'] ?>"
                                            data-pid="<?= $value['pid'] ?>"
                                            data-sortimg="<?= $value['sortimg'] ?>"
                                            data-page_count="<?= $value['page_count'] ?>"
                                            data-allow_user_post="<?= $value['allow_user_post'] ?>"
                                            data-template="<?= $value['template'] ?>"><?= $value['sortname'] ?></a>
                                        <a href="<?= Url::sort($value['sid']) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
                                        <?php if ($value['allow_user_post'] == 'n'): ?>
                                            <br><span class="badge small badge-orange"><?= lang('no_contribution') ?></span>
                                        <?php endif ?>
                                    </td>
                                    <td><?= subString($value['description'], 0, 100) ?></td>
                                    <td><?= $value['sid'] ?></td>
                                    <td class="alias"><?= $value['alias'] ?></td>
                                    <td><a href="article.php?sid=<?= $value['sid'] ?>"><?= $value['lognum'] ?></a></td>
                                    <td>
                                        <a href="javascript: em_confirm(<?= $value['sid'] ?>, 'sort', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= lang('delete') ?></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="list_footer">
        <input type="submit" value="<?= lang('order_change') ?>" class="btn btn-sm btn-success" />
    </div>
</form>

<div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('category_add') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="sort.php?action=save" method="post" id="sort_new">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sortname"><?= lang('category_name') ?> <span class="text-danger">*</span></label>
                        <input class="form-control" id="sortname" name="sortname" required>
                    </div>
                    <div class="form-group">
                        <label for="alias"><?= lang('alias_info') ?>（<?= lang('alias_prompt') ?>）</label>
                        <input class="form-control" id="alias" name="alias">
                    </div>
                    <div class="form-group">
                        <label><?= lang('category_parent') ?></label>
                        <select name="pid" id="pid" class="form-control">
                            <option value="0"><?= lang('none') ?></option>
                            <?php
                            foreach ($sorts as $key => $value):
                                if ($value['pid'] != 0) {
                                    continue;
                                }
                            ?>
                                <option value="<?= $key ?>"><?= $value['sortname'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sortimg"><?= lang('cover') ?></label>
                        <input class="form-control" id="sortimg" name="sortimg" type="url" placeholder="https://">
                    </div>
                    <div class="form-group">
                        <label for="title"><?= lang('category_title') ?></label>
                        <input class="form-control" id="title" name="title">
                        <small class="form-text text-muted"><?= lang('support_variables') ?>: {{site_title}}, {{site_name}}, {{sort_name}}</small>
                    </div>
                    <div class="form-group">
                        <label for="alias"><?= lang('category_description_tip') ?></label>
                        <textarea name="description" id="description" type="text" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kw"><?= lang('category_kw') ?></label>
                        <input class="form-control" id="kw" name="kw">
                    </div>
                    <div class="form-group">
                        <label><?= lang('posts_per_page') ?>(<?= lang('zero_global_settings') ?>)</label>
                        <input class="form-control" value="" name="page_count" id="page_count" type="number" min="0" />
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" name="allow_user_post" id="allow_user_post" value="y">
                        <label class="custom-control-label" for="allow_user_post"><?= lang('allow_publish_cat') ?></label>
                    </div>
                    <?php if ($customTemplates): ?>
                        <div class="form-group">
                            <label for="template"><?= lang('category_template') ?></label>
                            <?php
                            $sortListHtml = '<option value="">' . lang('default') . '</option>';
                            foreach ($customTemplates as $v) {
                                $sortListHtml .= '<option value="' . str_replace('.php', '', $v['filename']) . '">' . ($v['comment']) . '</option>';
                            }
                            ?>
                            <select id="template" name="template" class="form-control"><?= $sortListHtml; ?></select>
                            <small class="form-text text-muted"><?= lang('category_template_intro') ?></small>
                        </div>
                    <?php endif; ?>
                    <?php doAction('adm_sort_add') ?>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" value="" name="sid" id="sid" />
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                    <span id="alias_msg_hook"></span>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="submit" id="save_btn" class="btn btn-sm btn-success"><?= lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function issortalias(a) {
        const validChars = /^[\w-]*$/;
        const validDigits = /^\d+$/;
        const reservedKeywords = ['post', 'record', 'sort', 'tag', 'author', 'page', 'posts'];

        if (!validChars.test(a)) return 1;
        if (validDigits.test(a)) return 2;
        if (reservedKeywords.includes(a)) return 3;

        return 0;
    }

    function checksortalias() {
        const alias = $.trim($("#alias").val());
        const saveButton = $("#save_btn");
        const aliasMsgHook = $("#alias_msg_hook");

        const errorMessages = {
            1: '<?= lang('alias_invalid_characters') ?>',
            2: '<?= lang('alias_only_digits') ?>',
            3: '<?= lang('alias_system_link') ?>'
        };

        const result = issortalias(alias);
        if (result !== 0) {
            saveButton.attr("disabled", "disabled");
            aliasMsgHook.html('<span id="input_error">' + errorMessages[result] + '</span>');
        } else {
            aliasMsgHook.html('');
            $("#msg").html('');
            saveButton.attr("disabled", false);
        }
    }

    // Submit Form 
    $("#sort_form").submit(function(event) {
        event.preventDefault();
        submitForm("#sort_form");
    });

    $(function() {
        setTimeout(hideActived, 3600);
        $("#alias").keyup(function() {
            checksortalias();
        });

        $("#menu_category_content").addClass('active');
        $("#menu_content").addClass('show');
        $("#menu_sort").addClass('active');

        // Initialize drag sorting
        $('#dataTable tbody').sortable().disableSelection();

        // Category Editing
        $('#sortModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var sid = button.data('sid')
            var sortname = button.data('sortname')
            var alias = button.data('alias')
            var description = button.data('description')
            var kw = button.data('kw')
            var title = button.data('title')
            var pid = button.data('pid')
            var template = button.data('template')
            var sortimg = button.data('sortimg')
            var page_count = button.data('page_count')
            var allow_user_post = button.data('allow_user_post')
            var modal = $(this)
            modal.find('.modal-body #sortname').val(sortname)
            modal.find('.modal-body #alias').val(alias)
            modal.find('.modal-body #description').val(description)
            modal.find('.modal-body #kw').val(kw)
            modal.find('.modal-body #title').val(title)
            modal.find('.modal-body #pid').val(pid)
            modal.find('.modal-body #template').val(template)
            modal.find('.modal-body #sortimg').val(sortimg)
            modal.find('.modal-body #page_count').val(page_count)
            modal.find('.modal-body #allow_user_post').prop('checked', !sid || allow_user_post === 'y')
            modal.find('.modal-footer #sid').val(sid)
        })
    });
</script>