<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div id="msg" class="fixed-top alert" style="display: none"></div>
<h4 class="mb-4 text-gray-800"><?= $containerTitle ?> <span id="save_info"></span></h4>
<form action="article_save.php" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <div class="row">
        <div class="col-xl-9">
            <div id="post" class="form-group">
                <div>
                    <input type="text" name="title" id="title" value="<?= $title ?>" class="form-control" maxlength="512" placeholder="<?= lang('title') ?>" autofocus required />
                </div>
                <div class="small my-3">
                    <a href="#mediaModal" data-toggle="modal" data-target="#mediaModal"><i class="icofont-plus"></i><?= lang('resource_library') ?></a>
                    <?php doAction('adm_writelog_bar') ?>
                </div>
                <div id="logcontent"><textarea><?= $content ?></textarea></div>
                <div class="mt-3">
                    <?= lang('summary_optional') ?>
                    <textarea id="logexcerpt" name="logexcerpt" class="form-control" rows="5"><?= $excerpt ?></textarea>
                    <div class="custom-control custom-switch mt-1">
                        <input type="checkbox" class="custom-control-input" id="auto_excerpt" name="auto_excerpt" value="y" onclick="toggleCheckbox('auto_excerpt')">
                        <label class="custom-control-label" for="auto_excerpt"><?= lang('extract_summary') ?></label>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="javascript:void (0);" class="field_add small"><i class="icofont-plus"></i><?= lang('add_field') ?></a>
                    <div class="mt-2" id="field_box">
                        <?php
                        foreach ($fields as $key => $value): ?>
                            <div class="form-row field_list mb-3">
                                <div class="col-sm-3 px-2 my-1">
                                    <input type="text" name="field_keys[]" value="<?= $key ?>" list="customFieldList" class="form-control field-keys-input" placeholder="<?= lang('field_name') ?>" maxlength="120" required>
                                    <datalist id="customFieldList">
                                        <?php foreach ($customFields as $k => $v): ?>
                                            <option value="<?= $k ?>"><?= $k . '【' . $v['name'] . '】' . $v['description'] ?></option>
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>
                                <div class="col-sm-8 px-2 my-1">
                                    <textarea name="field_values[]" class="form-control auto-resize-textarea field-values-textarea" placeholder="<?= lang('field_value') ?>" rows="1" style="resize: vertical; min-height: 33px; white-space: pre-wrap; overflow-x: auto;" required><?= $value ?></textarea>
                                </div>
                                <div class="col-sm-1 px-2 my-1 d-flex align-items-start justify-content-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger field_del"><?= lang('delete') ?></button>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label id="post_bar_label"><?= lang('plugin_manage_act') ?></label>
                    <div id="post_bar">
                        <?php doAction('adm_writelog_head') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div id="post_button">
                <input type="hidden" name="ishide" id="ishide" value="<?= $hide ?>" />
                <input type="hidden" name="as_logid" id="as_logid" value="<?= $logid ?>" />
                <input type="hidden" name="gid" id="gid" value="<?= $logid ?>" />
                <input type="hidden" name="author" id="author" value="<?= $author ?>" />
                <?php if ($logid < 0): ?>
                    <input type="submit" name="pubPost" id="pubPost" value="<?= lang('post_publish') ?>" onclick="return checkform();" class="btn btn-success btn-sm" />
                    <input type="button" name="savedf" id="savedf" value="<?= lang('save_draft') ?>" onclick="autosave(2);" class="btn btn-primary btn-sm" />
                <?php else: ?>
                    <input type="submit" value="<?= lang('save_and_return') ?>" onclick="return checkform();" class="btn btn-success btn-sm" />
                    <input type="button" name="savedf" id="savedf" value="<?= lang('save') ?>" onclick="autosave(2);" class="btn btn-primary btn-sm" />
                    <?php if ($isdraft) : ?>
                        <input type="submit" name="pubPost" id="pubPost" value="<?= lang('publish') ?>" onclick="return checkform();" class="btn btn-success btn-sm" />
                    <?php endif ?>
                <?php endif ?>
            </div>
            <div class="shadow-sm p-3 bg-white rounded" id="post_side">
                <div class="form-group">
                    <label><?= lang('article_cover') ?></label>
                    <input name="cover" id="cover" class="form-control" maxlength="2048" placeholder="" value="<?= $cover ?>" />
                    <small class="text-muted"><?= lang('cover_placeholder') ?></small>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="upload_img">
                                <img src="<?= $cover ?: './views/images/cover.svg' ?>" width="200" id="cover_image" class="rounded" alt="<?= lang('cover_image') ?>" />
                                <input type="file" name="upload_img" class="image" id="upload_img" style="display:none" />
                                <button type="button" id="cover_rm" class="btn-sm btn btn-link" <?php if (!$cover): ?>style="display:none" <?php endif ?>>x</button>
                            </label>
                        </div>
                    </div>
                    <div class="custom-control custom-switch mt-1">
                        <input type="checkbox" class="custom-control-input" id="auto_cover" name="auto_cover" value="y" onclick="toggleCheckbox('auto_cover')">
                        <label class="custom-control-label" for="auto_cover"><?= lang('automatically_obtain_cover') ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label><?= lang('category') ?>:</label>
                    <select name="sort" id="sort" class="form-control">
                        <option value="-1"><?= lang('category_select') ?></option>
                        <?php
                        foreach ($sorts as $key => $value):
                            if ($value['pid'] != 0) {
                                continue;
                            }
                            $flg = $value['sid'] == $sortid ? 'selected' : '';
                        ?>
                            <option value="<?= $value['sid'] ?>" <?= $flg ?>><?= $value['sortname'] ?></option>
                            <?php
                            $children = $value['children'];
                            foreach ($children as $key):
                                $value = $sorts[$key];
                                $flg = $value['sid'] == $sortid ? 'selected' : '';
                            ?>
                                <option value="<?= $value['sid'] ?>" <?= $flg ?>>&nbsp; &nbsp; &nbsp; <?= $value['sortname'] ?></option>
                        <?php
                            endforeach;
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= lang('tags') ?>: </label>
                    <?php if ($tags): ?>
                        <span class="small"> <a href="javascript:doToggle('tags', 1);"><?= lang('recently_used') ?></a></span>
                        <div id="tags" class="mb-2" style="display: none">
                            <?php
                            foreach ($tags as $val) {
                                echo " <a class=\"em-badge small em-badge-tag\" href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <input name="tag" id="tag" class="form-control" value="<?= $tagStr ?>" />
                    <small class="text-muted"><?= lang('recently_used_tip') ?></small>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="allow_remark" name="allow_remark" value="y" <?= $is_allow_remark ?>>
                        <label class="custom-control-label" for="allow_remark"><?= lang('allow_comments') ?></label>
                    </div>
                    <?php if (User::haveEditPermission()): ?>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="top" name="top" value="y" <?= $is_top; ?>>
                            <label class="custom-control-label" for="top"><?= lang('home_top') ?></label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="sortop" name="sortop" value="y" <?= $is_sortop; ?>>
                            <label class="custom-control-label" for="sortop"><?= lang('category_top') ?></label>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (User::haveEditPermission()): ?>
                    <div class="form-group">
                        <label><?= lang('publish_time') ?>：</label>
                        <input type="text" maxlength="200" name="postdate" id="postdate" value="<?= $postDate ?>" class="form-control datepicker" required />
                        <small class="text-muted"><?= lang('publish_time_tips') ?></small>
                    </div>
                    <div><a href="javascript:void (0);" class="show_adv_set" onclick="displayToggle('adv_set');"><?= lang('advanced_options') ?><i class="icofont-simple-right"></i></a></div>
                <?php else: ?>
                    <input type="hidden" name="postdate" id="postdate" value="<?= $postDate ?>" />
                <?php endif; ?>
                <div id="adv_set">
                    <?php if (User::haveEditPermission()): ?>
                        <div class="form-group">
                            <label><?= lang('link_alias') ?></label>
                            <input name="alias" id="alias" class="form-control" value="<?= $alias ?>" />
                            <small class="text-muted"><?= lang('link_alias_info') ?></small>
                        </div>
                        <div class="form-group">
                            <label><?= lang('jump_link')?></label>
                            <input name="link" id="link" type="url" class="form-control" maxlength="2048" value="<?= $link ?>" placeholder="https://" />
                            <small class="text-muted"><?= lang('jump_link_info') ?></small>
                        </div>
                        <div class="form-group">
                            <label><?= lang('access_password') ?></label>
                            <input type="text" name="password" id="password" class="form-control" value="<?= $password ?>" />
                        </div>
                        <?php if ($customTemplates): ?>
                            <div class="form-group">
                                <label><?= lang('article_template') ?></label>
                                <?php
                                $sortListHtml = '<option value="">'. lang('default') .'</option>';
                                foreach ($customTemplates as $v) {
                                    $select = $v['filename'] == $template ? 'selected="selected"' : '';
                                    $sortListHtml .= '<option value="' . str_replace('.php', '', $v['filename']) . '" ' . $select . '>' . ($v['comment']) . '</option>';
                                }
                                ?>
                                <select id="template" name="template" class="form-control"><?= $sortListHtml; ?></select>
                            </div>
                        <?php endif; ?>
                        <hr>
                    <?php endif; ?>
                    <div id="post_side_ext">
                        <?php doAction('adm_writelog_side') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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
                    <div><a href="#" id="mediaAdd" class="btn btn-sm btn-success shadow-sm mb-3"><?=lang('upload_files')?></a></div>
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
                        <button type="button" class="btn btn-success btn-sm mt-2" id="load-more"><?=lang('load_more')?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Cover picture clipping -->
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
                    <button type="button" id="use_original_image" class="btn btn-sm btn-primary"><?= lang('use_original_picture') ?></button>
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
    $("#alias").keyup(function() {
        checkalias();
    });
    setTimeout("autosave(1)", 60000);
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_write").addClass('active');

    // Editor
    var Editor;
    $(function() {
        Editor = editormd("logcontent", {
            width: "100%",
            height: 745,
            toolbarIcons: function() {
                return ["bold", "del", "italic", "quote", "|", "h1", "h2", "h3", "|", "list-ul", "list-ol", "hr", "|",
                    "link", "image", "audio", "video", "code", "code-block", "table", "|", "search", "preview", "fullscreen", "help"
                ]
            },
            path: "editor.md/lib/",
            tex: false,
            watch: false,
            lineNumbers: false,
            htmlDecode: true,
            flowChart: false,
            autoFocus: false,
            sequenceDiagram: false,
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png"],
            imageUploadURL: "media.php?action=upload&editor=1",
            videoUpload: false, //Enable video upload
            syncScrolling: "single",
            onfullscreen: function() {
                this.watch();
            },
            onfullscreenExit: function() {
                this.unwatch();
            },
            onload: function() {
                hooks.doAction("loaded", this);
            }
        });
        Editor.setToolbarAutoFixed(false);
    });

    // Cover image
    $(function () {
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

        // Upload pictures
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

    // When leaving the page, if the content of the article has been modified, ask the user whether to leave
    var articleTextRecord;
    var titleText = $('title').text();
    hooks.addAction("loaded", function() {
        articleTextRecord = $("textarea[name=logcontent]").text();
    });
    window.onbeforeunload = function(e) {
        if ($("textarea[name=logcontent]").text() == articleTextRecord) return
        e = e || window.event;
        if (e) e.returnValue = '<?= lang('reload_page_tip') ?>';
        return '<?= lang('reload_page_tip') ?>';
    }

    // The global shortcut key Ctrl (Cmd)+S in the article editing interface saves the content
    document.addEventListener('keydown', function(e) {
        if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
            e.preventDefault();
            autosave(2);
        }
    });

    // Display plug-in extension label
    const postBar = $("#post_bar");
    if (postBar.children().length === 0) {
        $("#post_bar_label").hide();
    }

    // Custom Field
    $(document).on('click', '.field_del', function() {
        $(this).closest('.field_list').remove();
    });
    $(document).on('click', '.field_add', function() {
        var newField = `
                    <div class="form-row field_list mb-3">
                        <div class="col-sm-3 px-2 my-1">
                            <input type="text" name="field_keys[]" list="customFieldList" value="" class="form-control field-keys-input" placeholder="<?= lang('field_name') ?>" maxlength="120" required>
                            <datalist id="customFieldList">
                                <?php foreach ($customFields as $k => $v): ?>
                                    <option value="<?= $k ?>"><?= $k . '【' . $v['name'] . '】' . $v['description'] ?></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="col-sm-8 px-2 my-1">
                            <textarea name="field_values[]" value="" class="form-control auto-resize-textarea field-values-textarea" placeholder="<?= lang('field_value') ?>" rows="1" style="resize: vertical; min-height: 33px; white-space: pre-wrap; overflow-x: auto;" required></textarea>
                        </div>
                        <div class="col-sm-1 px-2 my-1 d-flex align-items-start justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-danger field_del"><?= lang('delete') ?></button>
                        </div>
                    </div>
                `;
        $('#field_box').append(newField);
        // Bind the automatic height adjustment function for the newly added textarea
        autoResizeTextarea($('#field_box .auto-resize-textarea').last());
    });

    // Bind the automatic height adjustment function for the existing textarea
    initAutoResizeTextareas();
    // Advanced Options Expand Status
    initDisplayState('adv_set');
    // Auto Intercept Summary Status
    initCheckboxState('auto_excerpt');
    // Automatically extract cover status
    initCheckboxState('auto_cover');
</script>