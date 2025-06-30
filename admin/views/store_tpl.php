<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= lang('store_unavailable') ?></div><?php endif ?>

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800 mt-3"><?= lang('app_store') ?> - <?= $sub_title ?></h1>
</div>
<div class="row mb-main ml-0">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php"><?= lang('all_apps') ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=tpl"><?= lang('ext_store_templates') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu"><?= lang('ext_store_plugins') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip"><?= lang('svip') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine"><?= lang('my_apps') ?></a></li>
    </ul>
</div>

<div class="d-flex flex-column flex-sm-row justify-content-between mb-main">
    <div class="flex alc flex-wrap gap6 mb-3 mb-sm-0">
        <a href="./store.php?action=tpl" class="badge badge-primary"><?= lang('all') ?></a>
        <a href="./store.php?action=tpl&tag=free" class="badge badge-success"><?= lang('free') ?></a>
        <a href="./store.php?action=tpl&tag=paid" class="badge badge-warning"><?= lang('pay') ?></a>
        <a href="./store.php?action=tpl&tag=promo" class="badge badge-danger"><?= lang('preferential') ?></a>
        <a href="./store.php?action=tpl&tag=download_top" class="badge badge-light text-primary small">🔥 <?= lang('download_top') ?></a>
        <a href="./store.php?action=tpl&tag=paid_top" class="badge badge-light text-primary small">🏆 <?= lang('paid_top') ?></a>
    </div>
    <div class="d-flex gap6 mb-3 mb-sm-0">
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" id="template-category" class="form-control">
                <?php foreach ($template_categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="./store.php" method="get">
            <div class="input-group">
                <input type="hidden" name="action" value="tpl">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control small" placeholder="<?= lang('template_search') ?>">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="icofont-search-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
