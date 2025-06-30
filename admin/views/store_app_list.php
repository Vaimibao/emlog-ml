<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="mb-3">
    <?php if (!empty($apps)): ?>
        <div class="d-flex flex-wrap app-list">
            <?php foreach ($apps as $k => $v):
                $icon = $v['icon'] ?: "./views/images/theme.png";
                $type = $v['app_type'] === 'template' ? 'tpl' : 'plugin';
                $order_url = 'https://www.emlog.net/order/submit/' . $type . '/' . $v['id']
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
                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>"><?= subString($v['name'], 0, 15) ?></a>
                                <?php if ($type === 'tpl'): ?>
                                    <span class="badge badge-success p-1"><?= lang('template') ?></span>
                                <?php else: ?>
                                    <span class="badge badge-primary p-1"><?= lang('plugin') ?></span>
                                <?php endif; ?>
                                <?php if ($v['svip']): ?>
                                    <a href="https://www.emlog.net/register" class="badge badge-warning p-1" target="_blank"><?= lang('svip') ?></a>
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
                                    <?php if (Plugin::isActive($v['alias']) || Template::isActive($v['alias'])): ?>
                                        <a href="plugin.php" class="em-but em-but-warning all-radius btn-block"><?= lang('actived') ?></a>
                                    <?php endif; ?>
                                    <?php if ($v['price'] > 0): ?>
                                        <?php if ($v['purchased'] === true): ?>
                                            <a href="store.php?action=mine" class="btn btn-light"><?= lang('purchased') ?></a>
                                            <a href="#" class="em-but em-but-success all-radius btn-block installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>"><?= lang('install_now') ?></a>
                                        <?php elseif ($v['svip'] && Register::getRegType() === 2): ?>
                                            <a href="#" class="em-but em-but-warning all-radius btn-block installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>"><?= lang('install_now') ?></a>
                                        <?php else: ?>
                                            <a href="<?= $order_url ?>" class="em-but em-but-error btn-block all-radius" target="_blank"><?= lang('go_buy') ?></a>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <a href="#" class="em-but em-but-success all-radius btn-block installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>"><?= lang('install_free') ?></a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="col-md-12 page my-5"></div>
        <!-- Manually load more buttons -->
        <div class="col-md-12 text-center mb-4" id="loadMoreContainer" style="display: none;">
            <button type="button" class="btn btn-primary" id="loadMoreBtn">
                <?= lang('load_more_btn') ?>
            </button>
        </div>
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

        $('.category').on('change', function() {
            var selectedCategory = $(this).val();
            if (selectedCategory) {
                window.location.href = './store.php?sid=' + selectedCategory;
            }
        });

        // Rolling loading function
        let isLoading = false;
        let hasMore = <?= $has_more ? 'true' : 'false' ?>;
        let currentPage = <?= $page ?>;
        let tabType = "<?= $tab_type ?>";

        function loadMoreApps() {
            if (isLoading || !hasMore) return;

            isLoading = true;
            const nextPage = currentPage + 1;

            // Disable manual loading button
            $('#loadMoreBtn').prop('disabled', true).html(lang('loading'));

            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('action', 'ajax_load');
            urlParams.set('type', tabType);
            urlParams.set('page', nextPage);

            $.ajax({
                url: './store.php',
                type: 'GET',
                data: urlParams.toString(),
                dataType: 'json',
                success: function(response) {
                    if (response.code === 200 && response.data.apps.length > 0) {
                        // Rendering a new application card
                        let html = '';
                        response.data.apps.forEach(function(app) {
                            const icon = app.icon || './views/images/theme.png';
                            const type = app.app_type === 'template' ? 'tpl' : 'plugin';
                            const orderUrl = 'https://www.emlog.net/order/submit/' + type + '/' + app.id;
                            const install_text = lang('install');
                            const go_by_text = lang('go_buy');
                            const recommend_today = lang('recommend_today');
                            const template_text = lang('_template');
                            const plugin_text = lang('_plugin');
                            const svip_text = lang('svip');
                            const price_text = lang('_price');
                            const price_unit = lang('price_unit');
                            const free_text = lang('free');
                            const developer = lang('developer');
                            const version_number = lang('version_number');
                            const download_count = lang('download_count');
                            const update_time = lang('update_time');

                            // Build button HTML
                            let buttonsHtml = '';

                            // Check the status during use
                            if (app.is_active) {
                                buttonsHtml += '<a href="plugin.php" class="em-but em-but-warning all-radius btn-block">' + lang('used') + '</a> ';
                            }

                            // Build installation/purchase buttons based on price and permissions
                            if (app.price > 0) {
                                if (app.purchased === true) {
                                    buttonsHtml += '<a href="store.php?action=mine" class="btn btn-light">' + lang('purchased') + '</a> ';
                                    buttonsHtml += `<a href="#" class="em-but em-but-success all-radius btn-block installBtn" data-url="${encodeURIComponent(app.download_url)}" data-cdn-url="${encodeURIComponent(app.cdn_download_url)}" data-type="${type}">${install_text}</a>`;
                                } else if (app.svip && app.user_is_svip) {
                                    buttonsHtml += `<a href="#" class="em-but em-but-warning all-radius btn-block installBtn" data-url="${encodeURIComponent(app.download_url)}" data-cdn-url="${encodeURIComponent(app.cdn_download_url)}" data-type="${type}">${install_text}</a>`;
                                } else {
                                    buttonsHtml += `<a href="${orderUrl}" class="em-but em-but-error btn-block all-radius" target="_blank">${go_by_text}</a>`;
                                }
                            } else {
                                buttonsHtml += `<a href="#" class="em-but em-but-success all-radius btn-block installBtn" data-url="${encodeURIComponent(app.download_url)}" data-cdn-url="${encodeURIComponent(app.cdn_download_url)}" data-type="${type}">${install_text}</a>`;
                            }

                            html += `
                                <div class="col-md-6 col-lg-3">
                                    <div class="card mb-4 shadow-sm hover-shadow-lg">
                                        <a href="#appModal" class="p-1" data-toggle="modal" data-target="#appModal" data-name="${app.name}" data-url="${app.app_url}" data-buy-url="${app.buy_url}">
                                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="${icon}">
                                        </a>
                                        <div class="card-body">
                                            <p class="card-text font-weight-bold mb6">
                                                ${app.top === 1 ? `<span class="badge badge-success p-1">${recommend_today}</span>` : ''}
                                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="${app.name}" data-url="${app.app_url}" data-buy-url="${app.buy_url}">${app.name.substring(0, 15)}</a>
                                                ${type === 'tpl' ? `<span class="badge badge-success p-1">${template_text}</span>` : `<span class="badge badge-primary p-1">${plugin_text}</span>`}
                                                ${app.svip ? `<a href="https://www.emlog.net/register" class="badge badge-warning p-1" target="_blank">${svip_text}</a>` : ''}
                                            </p>
                                            <div class="card-text text-muted mb6">
                                                ${price_text}：
                                                ${app.price > 0 ?
                                (app.promo_price > 0 ?
                                        `<span style="text-decoration:line-through">${app.price}<small>${price_unit}</small></span> <span class="text-danger">${app.promo_price}<small>${price_unit}</small></span>` :
                                        `<span class="text-danger">${app.price}<small>${price_unit}</small></span>`
                                ) :
                                `<span class="text-success">${free_text}</span>`
                            }
                                                <div class="flex flex-wrap gap6 mt6 mb-main">
                                                    <span class="badge badge-light text-left">${developer}：<a href="./store.php?author_id=${app.author_id}">${app.author}</a></span>
                                                    <span class="badge badge-light text-left">${version_number}：${app.ver}</span>
                                                    <span class="badge badge-light text-left">${download_count}：${app.downloads}</span>
                                                    <span class="badge badge-light text-left">${update_time}：${app.update_time}</span>
                                                </div>
                                            </div>
                                            <div class="card-text">
                                                <div>
                                                    ${buttonsHtml}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        // Add to app list
                        $('.app-list').append(html);

                        // Update Status
                        currentPage = response.current_page;
                        hasMore = response.has_more;

                        if (hasMore) {
                            // Show manual load button
                            $('#loadMoreContainer').show();
                            $('#loadMoreBtn').prop('disabled', false).html(lang('load_more_btn'));
                        } else {
                            $('.page').html('<div class="text-center text-muted">' + lang('all_loaded') + '</div>');
                            // Hide manual load button
                            $('#loadMoreContainer').hide();
                        }
                    } else {
                        hasMore = false;
                        $('.page').html('<div class="text-center text-muted">' + lang('all_loaded') + '</div>');
                        $('#loadMoreContainer').hide();
                    }
                },
                error: function() {
                    // Re enable manual load button
                    $('#loadMoreBtn').prop('disabled', false).html(lang('failed_to_load'));
                },
                complete: function() {
                    isLoading = false;
                }
            });
        }

        // Manually load more button click events
        $('#loadMoreBtn').on('click', function() {
            loadMoreApps();
        });

        // Rolling monitoring
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                loadMoreApps();
            }
        });

        // Show manual load button at initialization (if there is more)
        if (hasMore) {
            $('#loadMoreContainer').show();
        }
    });
</script>