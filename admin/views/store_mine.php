<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= lang('store_unavailable') ?></div>
<?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800 mt-3"><?= lang('app_store') ?> - <?= $sub_title ?></h1>
</div>
<div class="row mb-main ml-0">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php"><?= lang('all_apps') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=tpl"><?= lang('ext_store_templates') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu"><?= lang('ext_store_plugins') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip"><?= lang('svip') ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=mine"><?= lang('my_apps') ?></a></li>
    </ul>
</div>
<div class="mb-3">
    <?php if (!empty($addons)): ?>
        <div class="d-flex flex-wrap app-list">
            <?php foreach ($addons as $k => $v):
                $icon = $v['icon'] ?: "./views/images/theme.png";
            ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card mb-4 shadow-sm hover-shadow-lg">
                        <a href="#appModal" class="p-1" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>">
                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="<?= $icon ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text font-weight-bold mb6">
                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>"><?= $v['name'] ?></a>
                            </p>
                            <div class="card-text text-muted mb-main">
                                <div class="grid g-c-2 g-c-sm-1 gap6">
                                    <span class="badge badge-light text-left"><?= lang('developer') ?>：<a href="./store.php?author_id=<?= $v['author_id'] ?>"><?= $v['author'] ?></a></span>
                                    <span class="badge badge-light text-left"><?= lang('version_number') ?>：<?= $v['ver'] ?></span>
                                    <span class="badge badge-light text-left"><?= lang('update_time') ?>：<?= $v['update_time'] ?></span>
                                </div>
                            </div>
                            <div class="card-text">
                                <div>
                                    <?php if (Plugin::isActive($v['alias'])): ?>
                                        <a href="plugin.php" class="em-but em-but-warning all-radius btn-block"><?= lang('actived') ?></a>
                                    <?php endif; ?>
                                    <?php if (empty($v['download_url'])): ?>
                                        <a href="<?= $v['buy_url'] ?>" class="em-but em-but-success all-radius btn-block"><?=lang('contact_to_install')?></a>
                                    <?php else: ?>
                                        <a href="#" class="em-but em-but-success all-radius btn-block installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $v['type'] ?>"><?= lang('install_app') ?></a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php elseif (!Register::isRegLocal()): ?>
        <div>
            <p class="alert alert-warning my-3"><?= lang('not_paid_registered_user') ?><a href="https://www.emlog.net/register"><?= lang('paid_support') ?></a></p>
        </div>
    <?php else: ?>
        <div>
            <p class="alert alert-warning my-3"><?= lang('no_my_apps') ?></p>
        </div>
    <?php endif; ?>
</div>
<div class="modal fade" id="appModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <div>
                    <a href="" class="modal-buy-url text-muted" target="_blank"><?= lang('to_official_site') ?></a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#menu_store").addClass('active');
        setTimeout(hideActived, 3600);
    });
</script>