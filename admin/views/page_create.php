<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<form action="page.php?action=save" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <h1 class="h4 pt-3 mb-4 text-gray-800"><?= $containertitle ?></h1>
    <div class="row">
        <div class="col-xl-9">
            <div id="post" class="form-group">
                <div>
                    <input type="text" name="title" id="title" value="<?= $title ?>" class="form-control" placeholder="<?= lang('page_title') ?>" />
                </div>
                <div class="small my-3">
                    <a href="#mediaModal" data-toggle="modal" data-target="#mediaModal"><i class="icofont-plus"></i><?= lang('resource_library') ?></a>
                    <?php doAction('adm_writelog_bar') ?>
                </div>
                <div id="pagecontent"><textarea><?= $content ?></textarea></div>
                <div class="mt-3">
                    <label id="post_bar_label"><?= lang('plugin_manage_act') ?></label>
                    <div id="post_bar"><?php doAction('adm_writelog_head') ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div id="post_button">
                <input type="hidden" name="ishide" id="ishide" value="<?= $hide ?>" />
                <input type="hidden" name="pageid" value="<?= $pageId ?>" />
                <?php if ($pageId < 0): ?>
                    <input type="submit" value="<?= lang('page_publish') ?>" onclick="return checkform();" class="btn btn-success btn-sm" />
                <?php else: ?>
                    <input type="submit" value="<?= lang('save_and_return') ?>" onclick="return checkform();" class="btn btn-success btn-sm" />
                <?php endif ?>
            </div>
            <div class="shadow-sm p-3 mb-2 bg-white rounded">
                <div class="form-group">
                    <label><?= lang('article_cover') ?></label>
                    <input name="cover" id="cover" class="form-control" placeholder="" value="<?= $cover ?>" />
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="upload_img">
                                <img src="<?= $cover ?: './views/images/cover.svg' ?>" width="200" id="cover_image" class="rounded" alt="<?= lang('cover_image') ?>" />
                                <input type="file" name="upload_img" class="image" id="upload_img" style="display:none" />
                                <button type="button" id="cover_rm" class="btn-sm btn btn-link" <?php if (!$cover): ?>style="display:none" <?php endif ?>>x</button>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><?= lang('link_alias') ?></label>
                    <input name="alias" id="alias" class="form-control" value="<?= $alias ?>" />
                    <small class="text-muted"><?= lang('link_alias_info') ?></small>
                </div>
                <div class="form-group">
                    <label><?= lang('jump_link')?></label>
                    <input name="link" id="link" type="url" class="form-control" value="<?= $link ?>" placeholder="https://" />
                    <small class="text-muted"><?= lang('jump_link_info') ?></small>
                </div>
                <div class="form-group">
                    <label><?= lang('page_template') ?></label>
                    <?php if ($customTemplates):
                        $sortListHtml = '<option value="">'. lang('default') .'</option>';
                        foreach ($customTemplates as $v) {
                            $select = $v['filename'] == $template ? 'selected="selected"' : '';
                            $sortListHtml .= '<option value="' . str_replace('.php', '', $v['filename']) . '" ' . $select . '>' . ($v['comment']) . '</option>';
                        }
                    ?>
                        <select id="template" name="template" class="form-control"><?= $sortListHtml; ?></select>
                        <small class="form-text text-muted"><?= lang('select_tmpl_option') ?></small>
                    <?php else: ?>
                        <input class="form-control" id="template" name="template" value="<?= $template ?>">
                        <small class="form-text text-muted"><?= lang('custom_tmpl_info') ?></small>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="allow_remark" name="allow_remark" value="y" <?= $is_allow_remark ?>>
                        <label class="custom-control-label" for="allow_remark"><?= lang('allow_comments') ?></label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="home_page" name="home_page" value="y" <?= $is_home_page ?>>
                        <label class="custom-control-label" for="home_page"><?= lang('set_as_index') ?></label>
                    </div>
                </div>
                <div id="page_side_ext">
                    <?php doAction('adm_write_page_side') ?>
                </div>
            </div>
        </div>
    </div>
</form>
<!--Resource library-->
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('resource_library') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <div><a href="#" id="mediaAdd" class="btn btn-sm btn-success shadow-sm mb-3"><?= lang('upload_files') ?></a></div>
                    <div>
                        <?php if (User::haveEditPermission() && $mediaSorts): ?>
                            <select class="form-control" id="media-sort-select">
                                <option value=""><?= lang('select_file_category') ?></option>
                                <?php foreach ($mediaSorts as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['sortname'] ?></option>
                                <?php endforeach ?>
                            </select>
                        <?php endif ?>
                    </div>
                </div>
                <form action="media.php?action=operate_media" method="post" name="form_media" id="form_media">
                    <div class="row" id="image-list"></div>
                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-sm mt-2" id="load-more"><?= lang('load_more') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 封面图裁剪 -->
<div class="modal fade" id="modal" tabindex="-2" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title"><?= lang('crop_upload') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-11">
                            <img src="" id="sample_image" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div><?= lang('cover_picture_tip') ?></div>
                <div>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="button" id="crop" class="btn btn-sm btn-success"><?= lang('save') ?></button>
                    <button type="button" id="use_original_image" class="btn btn-sm btn-google"><?= lang('use_original_picture') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dropzone-previews" style="display: none;"></div>
<script src="./views/js/dropzone.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="./views/js/media-lib.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="./editor.md/editormd.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="./editor.md/languages/<?=strtolower(LANG)?>.js"></script>
<script>
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('show');
    $("#menu_page").addClass('active');

    checkalias();
    $("#alias").keyup(function() {
        checkalias();
    });
    $("#title").focus(function() {
        $("#title_label").hide();
    });
    $("#title").blur(function() {
        if ($("#title").val() == '') {
            $("#title_label").show();
        }
    });
    if ($("#title").val() != '') $("#title_label").hide();

    var Editor;
    $(function() {
        Editor = editormd("pagecontent", {
            width: "100%",
            height: 745,
            toolbarIcons: function() {
                return ["bold", "del", "italic", "quote", "|", "h1", "h2", "h3", "|", "list-ul", "list-ol", "hr", "|",
                    "link", "image", "audio", "video", "code", "code-block", "table", "|", "search", "preview", "fullscreen", "help"
                ]
            },
            path: "editor.md/lib/",
            tex: false,
            flowChart: false,
            watch: false,
            htmlDecode: true,
            lineNumbers: false,
            sequenceDiagram: false,
            syncScrolling: "single",
            onload: function() {
                hooks.doAction("page_loaded", this);
            }
        });
        Editor.setToolbarAutoFixed(false);
    });
    // When leaving the page, if the page content has been modified, ask the user if they want to leave
    var pageText;
    hooks.addAction("page_loaded", function() {
        pageText = $("textarea").text();
    });
    window.onbeforeunload = function(e) {
        if ($("textarea").text() == pageText) return
        e = e || window.event;
        if (e) e.returnValue = '<?= lang('reload_page_tip') ?>';
        return '<?= lang('reload_page_tip') ?>';
    }
    // The global shortcut key Ctrl (Cmd)+S in the article editing interface saves the content
    document.addEventListener('keydown', function(e) {
        if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
            e.preventDefault();
            pagesave();
        }
    });

    // Cover image
    $(function() {
        var $modal = $('#modal');
        var image = document.getElementById('sample_image');
        var cropper;
        $('#upload_img').change(function(event) {
            var files = event.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            if (files && files.length > 0) {
                if (!files[0].type.startsWith('image')) {
                    alert('<?= lang('only_upload_pictures') ?>');
                    return;
                }
                reader = new FileReader();
                reader.onload = function(event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: NaN,
                viewMode: 1
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });

        // 上传图片
        function uploadImage(blob, filename) {
            var formData = new FormData();
            formData.append('image', blob, filename);
            $.ajax('./article.php?action=upload_cover', {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $modal.modal('hide');
                    if (data.code == 0) {
                        $('#cover_image').attr('src', data.data);
                        $('#cover').val(data.data);
                        $('#cover_rm').show();
                    } else {
                        alert(data.msg);
                    }
                },
                error: function(xhr) {
                    var data = xhr.responseJSON;
                    if (data && typeof data === "object") {
                        alert(data.msg);
                    } else {
                        alert("<?= lang('upload_pictures_error') ?>");
                    }
                }
            });
        }

        $('#crop').click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 650,
                height: 366
            });
            canvas.toBlob(function(blob) {
                uploadImage(blob, 'cover.jpg')
            });
        });

        $('#use_original_image').click(function() {
            var blob = $('#upload_img')[0].files[0];
            uploadImage(blob, blob.name)
        });

        $('#cover_rm').click(function() {
            $('#cover_image').attr('src', "./views/images/cover.svg");
            $('#cover').val("");
            $('#cover_rm').hide();
        });
    });

    $('#cover').blur(function() {
        c = $('#cover').val();
        if (!c) {
            $('#cover_image').attr('src', "./views/images/cover.svg");
            $('#cover_rm').hide();
            return
        }
        $('#cover_image').attr('src', c);
        $('#cover_rm').show();
    });

    // Display plugin extension label
    const postBar = $("#post_bar");
    if (postBar.children().length === 0) {
        $("#post_bar_label").hide();
    }
</script>