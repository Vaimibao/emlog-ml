<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= lang('store_unavailable') ?></div><?php endif ?>

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800 mt-3"><?= lang('app_store') ?> - <?= $sub_title ?></h1>
</div>
<div class="row mb-main ml-0">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="./store.php"><?= lang('all_apps') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=tpl"><?= lang('ext_store_templates') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu"><?= lang('ext_store_plugins') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip"><?= lang('svip') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine"><?= lang('my_apps') ?></a></li>
    </ul>
</div>

<div class="d-flex flex-column flex-sm-row justify-content-between mb-main">
    <div class="flex alc flex-wrap gap6 mb-3 mb-sm-0">
        <a href="./store.php" class="badge badge-primary"><?= lang('all') ?></a>
        <a href="./store.php?tag=free" class="badge badge-success"><?= lang('free') ?></a>
        <a href="./store.php?tag=paid" class="badge badge-warning"><?= lang('pay') ?></a>
        <a href="./store.php?tag=promo" class="badge badge-danger"><?= lang('preferential') ?></a>
        <a href="./store.php?tag=download_top" class="badge badge-light text-primary small">🔥  <?= lang('download_top') ?></a>
        <a href="./store.php?keyword=ai" class="badge badge-light text-primary small">✨AI</a>
        <a href="./store.php?sid=2" class="badge badge-light text-primary small">SEO</a>
        <a href="./store.php?sid=8" class="badge badge-light text-primary small"><?= lang('tpl_category_8') ?></a>
        <a href="./store.php?sid=21" class="badge badge-light text-primary small"><?= lang('tpl_category_21') ?></a>
        <a href="./store.php?sid=17" class="badge badge-light text-primary small"><?= lang('tpl_category_17') ?></a>
        <a href="./store.php?sid=1" class="badge badge-light text-primary small"><?= lang('tpl_category_7') ?></a>
        <a href="./store.php?sid=12" class="badge badge-light text-primary small"><?= lang('plu_category_12') ?></a>
        <a href="./store.php?sid=11" class="badge badge-light text-primary small"><?= lang('plu_category_11') ?></a>
    </div>
    <div class="d-flex gap6 mb-3 mb-sm-0">
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" class="form-control category">
                <?php foreach ($template_categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" class="form-control category">
                <?php foreach ($plugin_categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="./store.php" method="get">
            <div class="input-group">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control small" placeholder="<?= lang('app_search') ?>">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="icofont-search-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
