<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['activate_install'])): ?>
    <div class="alert alert-success"><?= lang('plugin_upload_ok') ?></div><?php endif ?>
<?php if (isset($_GET['activate_upgrade'])): ?>
    <div class="alert alert-success"><?=lang('plugin_update_ok')?></div><?php endif ?>
<?php if (isset($_GET['active_error'])): ?>
    <div class="alert alert-danger"><?= lang('plugin_active_failed') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= lang('plugin_delete_failed') ?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger"><?= lang('plugin_not_writable') ?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger"><?= lang('plugin_zip_nonsupport') ?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger"><?= lang('plugin_zip_select') ?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger"><?= lang('plugin_wrong_format') ?></div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger"><?= lang('plugin_zipped_only') ?></div><?php endif ?>
<?php if (isset($_GET['error_g'])): ?>
    <div class="alert alert-danger"><?=lang('php_size_limit')?></div><?php endif ?>
<?php if (isset($_GET['error_i'])): ?>
    <div class="alert alert-danger"><?=lang('emlog_unregistered')?></div><?php endif ?>
<?php if (isset($_GET['error_sys'])): ?>
    <div class="alert alert-danger"><?= lang('plugin_system_dep') ?></div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800 mt-3"><?= lang('plugin_manage') ?></h1>
    <div>
        <a href="store.php?action=plu" class="btn btn-sm btn-warning shadow-sm mt-4"><i class="icofont-shopping-cart"></i> <?= lang('app_store') ?></a>
        <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> <?= lang('plugin_new_install') ?></a>
    </div>
</div>
<div class="panel-heading d-flex flex-column flex-md-row justify-content-between mb-3">
    <ul class="nav nav-pills justify-content-start mb-2 mb-md-0">
        <li class="nav-item">
            <a class="nav-link <?= $filter == '' ? 'active' : '' ?>" href="./plugin.php"><?= lang('all') ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $filter == 'on' ? 'active' : '' ?>" href="./plugin.php?filter=on"><?= lang('enabled') ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $filter == 'off' ? 'active' : '' ?>" href="./plugin.php?filter=off"><?= lang('disabled') ?></a>
        </li>
    </ul>
    <div class="w-md-auto">
        <input type="text" id="pluginSearch" class="form-control" placeholder="<?= lang('plugin_search') ?>">
    </div>
</div>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div class="my-3" id="upMsg"></div>
            <table class="table table-striped table-hover dataTable no-footer">
                <thead>
                    <tr>
                        <th><?= lang('plugin_name') ?></th>
                        <th><?= lang('plugin_status') ?></th>
                        <th><?= lang('author') ?></th>
                        <th><?= lang('version') ?></th>
                        <th><?= lang('operation') ?></th>
                    </tr>
                </thead>
                <tbody id="pluginTable">
                    <?php
                    if ($plugins):
                        $i = 0;
                        foreach ($plugins as $val):
                            $plug_state = '';
                            $plug_action = 'active';
                            if ($val['active']) {
                                $plug_state = 'checked';
                                $plug_action = 'inactive';
                            }
                            $i++;
                            if (TRUE === $val['Setting']) {
                                $val['Name'] = "<a href=\"./plugin.php?plugin={$val['Plugin']}\" title=\"" . lang('plugin_settings_click') . "\">{$val['Name']}</a>";
                            }
                            $alias = $val['alias'];
                    ?>
                            <tr data-plugin-alias="<?= $val['Plugin'] ?>" data-plugin-version="<?= $val['Version'] ?>">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="<?= $val['preview'] ?>" height="45" width="45" class="rounded" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="align-items-center mb-3">
                                                <p class="mb-0 m-2"><?= $val['Name'] ?></p>
                                                <p class="mb-0 m-2 small"><?= $val['Description'] ?> <?php if (strpos($val['Url'], 'https://www.emlog.net') === 0): ?><a href="<?= $val['Url'] ?>" target="_blank"><?= lang('more_info') ?></a><?php endif ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3">
                                        <input class="mui-switch mui-switch-animbg" type="checkbox" id="sw<?= $i ?>" <?= $plug_state ?> onchange="toggleSwitch('<?= $alias ?>', '<?= 'sw' . $i ?>', '<?= LoginAuth::genToken() ?>')">
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3">
                                        <?php if ($val['Author'] != ''): ?>
                                            <?php if (strpos($val['AuthorUrl'], 'https://www.emlog.net') === 0): ?>
                                                <a href="<?= $val['AuthorUrl'] ?>" target="_blank"><?= $val['Author'] ?></a>
                                            <?php else: ?>
                                                <?= $val['Author'] ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3 small">
                                        <?= $val['Version'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3">
                                        <a href="javascript: em_confirm('<?= $alias ?>', 'plu', '<?= LoginAuth::genToken() ?>');" class="btn btn-outline-danger btn-sm"><?= lang('delete') ?></a>
                                        <span class="update-btn"></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="6"><?= lang('plugin_no_installed') ?></td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title"><?= lang('plugin_install') ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data">
                <div class="modal-body px-4">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="pluzip" id="pluzip">
                        <label class="custom-file-label" for="pluzip"><?= lang('plugin_select') ?></label>
                        <input name="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                    </div>
                    <small class="form-text text-muted mt-2">
                        <?= lang('upload_install_info') ?>
                    </small>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= lang('upload_install') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // check for upgrade
    $(function() {
        setTimeout(hideActived, 3600);
        $("#menu_category_ext").addClass('active');

        // Listening template file upload
        $('#pluzip').on('change', function() {
            var fileName = $(this).get(0).files[0] ? $(this).get(0).files[0].name : '';
            $(this).next('.custom-file-label').text(fileName || '<?= lang('plugin_select') ?>');
        });

        var pluginList = [];
        $('table tbody tr').each(function() {
            var $tr = $(this);
            var pluginAlias = $tr.data('plugin-alias');
            var currentVersion = $tr.data('plugin-version');
            pluginList.push({
                name: pluginAlias,
                version: currentVersion
            });
        });
        $.ajax({
            url: './plugin.php?action=check_update',
            type: 'POST',
            data: {
                plugins: pluginList
            },
            success: function(response) {
                if (response.code === 0) {
                    var pluginsToUpdate = response.data;
                    $.each(pluginsToUpdate, function(index, item) {
                        var $tr = $('table tbody tr[data-plugin-alias="' + item.name + '"]');
                        var $updateBtn = $tr.find('.update-btn');
                        var $updateLink = $('<a>').addClass('btn btn-success btn-sm').text(lang('update')).attr("href", "javascript:void(0);");
                        $updateLink.on('click', function() {
                            updatePlugin(item.name, $updateLink);
                        });
                        $updateBtn.append($updateLink);
                    });
                } else {
                    $('#upMsg').html(lang('plugin_update_check_fail') + response.code).addClass('alert alert-warning');
                }
            },
            error: function(xhr) {
                var responseText = xhr.responseText;
                var responseObject = JSON.parse(responseText);
                var msgValue = responseObject.msg;
                $('#upMsg').html(lang('plugin_update_check_exception') + msgValue).addClass('alert alert-warning');
            }
        });

        // Plugin search functionality
        $('#pluginSearch').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#pluginTable tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });

    function toggleSwitch(plugin, id, token) {
        var switchElement = document.getElementById(id);
        if (switchElement.checked) {
            window.location.href = './plugin.php?action=active&plugin=' + plugin + '&token=' + token + '<?= '&filter=' . $filter ?>';
        } else {
            window.location.href = './plugin.php?action=inactive&plugin=' + plugin + '&token=' + token + '<?= '&filter=' . $filter ?>';
        }
    }

    function updatePlugin(pluginAlias, $updateLink) {
        $updateLink.text(lang('updating')).prop('disabled', true);
        $.ajax({
            url: './plugin.php?action=upgrade',
            type: 'GET',
            data: {
                alias: pluginAlias,
                token: '<?= LoginAuth::genToken() ?>'
            },
            success: function(response) {
                if (response.code === 0) {
                    location.href = 'plugin.php?activate_upgrade=1';
                } else {
                    $updateLink.text(lang('update')).prop('disabled', false);
                    emlog_msg('error', response.msg, 4000);
                }
            },
            error: function(xhr) {
                $updateLink.text(lang('update')).prop('disabled', false);
                emlog_msg('error', lang('update_request_failed'), 4000);
            }
        });
    }
</script>