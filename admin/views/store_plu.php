<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= lang('store_unavailable') ?></div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800 mt-3"><?= lang('app_store') ?> - <?= $sub_title ?></h1>
</div>
<div class="row mb-main ml-0">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php"><?= lang('all_apps') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=tpl"><?= lang('ext_store_templates') ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=plu"><?= lang('ext_store_plugins') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip"><?= lang('svip') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine"><?= lang('my_apps') ?></a></li>
    </ul>
</div>
<div class="d-flex flex-column flex-sm-row justify-content-between mb-main">
    <div class="flex alc flex-wrap gap6 mb-3 mb-sm-0">
        <a href="./store.php?action=plu" class="badge badge-primary"><?= lang('all') ?></a>
        <a href="./store.php?action=plu&tag=free" class="badge badge-success"><?= lang('free') ?></a>
        <a href="./store.php?action=plu&tag=paid" class="badge badge-warning"><?= lang('pay') ?></a>
        <a href="./store.php?action=plu&tag=promo" class="badge badge-danger"><?= lang('preferential') ?></a>
        <a href="./store.php?action=plu&tag=download_top" class="badge badge-light text-primary small">🔥 <?= lang('download_top') ?></a>
        <a href="./store.php?action=plu&tag=paid_top" class="badge badge-light text-primary small">🏆 <?= lang('paid_top') ?></a>
    </div>
    <div class="d-flex gap6 mb-3 mb-sm-0">
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" id="plugin-category" class="form-control">
                <?php foreach ($plugin_categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="./store.php" method="get" class="form-inline">
            <div class="input-group">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control small" placeholder="<?= lang('plugin_search') ?>">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="icofont-search-2"></i>
                    </button>
                </div>
            </div>
            <input type="hidden" name="action" value="plu">
        </form>
    </div>
</div>
<div class="mb-3">
    <?php if (!empty($plugins)): ?>
        <div class="d-flex flex-wrap app-list">
            <?php foreach ($plugins as $k => $v):
                $icon = $v['icon'] ?: "./views/images/plugin.png";
            ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card mb-4 shadow-sm hover-shadow-lg">
                        <a href="#appModal" class="p-1" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>">
                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="<?= $icon ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text font-weight-bold mb6">
                                <?php if ($v['top'] === 1): ?>
                                    <span class="badge badge-success p-1"><?= lang('recommend_today') ?></span>
                                <?php endif; ?>
                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>"><?= $v['name'] ?></a>
                                <?php if ($v['svip']): ?>
                                    <a href="https://www.emlog.net/register" class="badge badge-warning p-1" target="_blank">铁杆免费</a>
                                <?php endif; ?>
                            </p>
                            <div class="card-text text-muted mb6">
                                <?= lang('price') ?>：
                                <?php if ($v['price'] > 0): ?>
                                    <?php if ($v['promo_price'] > 0): ?>
                                        <span style="text-decoration:line-through"><?= $v['price'] ?><small><?= lang('price_unit') ?></small></span>
                                        <span class="text-danger"><?= $v['promo_price'] ?><small><?= lang('price_unit') ?></small></span>
                                    <?php else: ?>
                                        <span class="text-danger"><?= $v['price'] ?><small><?= lang('price_unit') ?></small></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-success"><?= lang('free') ?></span>
                                <?php endif; ?>
                                <div class="flex flex-wrap gap6 mt6 mb-main">
                                    <span class="badge badge-light text-left"><?= lang('developer') ?>：<a href="./store.php?author_id=<?= $v['author_id'] ?>"><?= $v['author'] ?></a></span>
                                    <span class="badge badge-light text-left"><?= lang('version_number') ?>：<?= $v['ver'] ?></span>
                                    <span class="badge badge-light text-left"><?= lang('download_count') ?>：<?= $v['downloads'] ?></span>
                                    <span class="badge badge-light text-left"><?= lang('update_time') ?>：<?= $v['update_time'] ?></span>
                                </div>
                            </div>
                            <div class="card-text">
                                <div>
                                    <?php if (Plugin::isActive($v['alias'])): ?>
                                        <a href="plugin.php" class="em-but em-but-warning all-radius btn-block"><?= lang('actived') ?></a>
                                    <?php endif; ?>
                                    <?php if ($v['price'] > 0): ?>
                                        <?php if ($v['purchased'] === true): ?>
                                            <a href="store.php?action=mine" class="btn btn-light"><?= lang('purchased') ?></a>
                                            <a href="#" class="em-but em-but-success all-radius btn-block installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="plugin"><?= lang('install_now') ?></a>
                                        <?php elseif ($v['svip'] && Register::getRegType() === 2): ?>
                                            <a href="#" class="em-but em-but-warning all-radius btn-block installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="plugin"><?= lang('install_now') ?></a>
                                        <?php else: ?>
                                            <a href="https://www.emlog.net/order/submit/plugin/<?= $v['id'] ?>" class="em-but em-but-error btn-block all-radius" target="_blank"><?= lang('go_buy') ?></a>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <a href="#" class="em-but em-but-success all-radius btn-block installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="plugin"><?= lang('install_free') ?></a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="col-md-12 page my-5"><?= $pageurl ?></div>
    <?php else: ?>
        <div>
            <div class="alert alert-info"><?= lang('store_no_results') ?></div>
        </div>
    <?php endif ?>
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

        $('#plugin-category').on('change', function() {
            var selectedCategory = $(this).val();
            if (selectedCategory) {
                window.location.href = './store.php?action=plu&sid=' + selectedCategory;
            }
        });
    });
</script>