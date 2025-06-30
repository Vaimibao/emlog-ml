<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_backup'])): ?>
    <div class="alert alert-success"><?= lang('backup_create_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_import'])): ?>
    <div class="alert alert-success"><?= lang('backup_import_ok') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= lang('backup_file_select') ?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger"><?= lang('backup_file_invalid') ?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger"><?= lang('backup_import_zip_unsupported') ?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger"><?= lang('backup_upload_failed') ?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger"><?= lang('backup_file_wrong') ?></div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger"><?= lang('backup_export_zip_unsupported') ?></div><?php endif ?>
<?php if (isset($_GET['active_mc'])): ?>
    <div class="alert alert-success"><?= lang('cache_update_ok') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800 mt-3"><?= lang('data_backup') ?></h1>
</div>
<div class="card-deck">
    <div class="card">
        <h5 class="card-header"><?= lang('db_backup') ?></h5>
        <div class="card-body">
            <div id="backup">
                <p><?= lang('backup_prompt') ?></p>
            </div>
        </div>
        <div class="card-footer">
            <form action="data.php?action=backup" method="post" class="text-right">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?= lang('backup_start') ?>" class="btn btn-sm btn-success" />
            </form>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header"><?= lang('backup_import_local') ?></h5>
        <form action="data.php?action=import" enctype="multipart/form-data" method="post">
            <div class="card-body">
                <div id="import">
                    <p class="des"><?= lang('backup_version_tip') ?></p>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="sqlfile" id="sqlfile" required>
                    <label class="custom-file-label" for="sqlfile"><?= lang('select_backup_file') ?></label>
                </div>
                <small class="form-text text-muted mt-2">
                    <?= lang('backup_version_tip2') ?><?= DB_PREFIX ?>
                </small>
            </div>
            <div class="card-footer text-right">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?= lang('import') ?>" class="btn btn-sm btn-success" />
            </div>
        </form>
    </div>
    <div class="card">
        <h5 class="card-header"><?= lang('cache_update') ?></h5>
        <div class="card-body">
            <div id="cache">
                <p class="des"><?= lang('cache_update_info') ?></p>
            </div>
        </div>
        <div class="card-footer text-right">
            <input type="button" onclick="window.location='data.php?action=Cache';" value="<?= lang('cache_update') ?>" class="btn btn-sm btn-success" />
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_data").addClass('active');
        setTimeout(hideActived, 3600);

        // Monitor the upload of backup files
        $('#sqlfile').on('change', function() {
            var fileName = $(this).get(0).files[0] ? $(this).get(0).files[0].name : '';
            $(this).next('.custom-file-label').text(fileName || '<?= lang('select_backup_file') ?>');
        });
    });
</script>