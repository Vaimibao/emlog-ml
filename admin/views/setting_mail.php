<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800 mt-3"><?= lang('settings') ?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php"><?= lang('basic_settings') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?= lang('user_settings') ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=mail"><?= lang('email_notify') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?= lang('seo_settings') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api"><?= lang('api_interface') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai">✨AI</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php"><?= lang('personal_settings') ?></a></li>
    </ul>
</div>
<div class="card mt-2">
    <div class="card-body">
        <form action="setting.php?action=mail_save" method="post" name="mail_setting_form" id="mail_setting_form">
            <h4><?= lang('email_sending') ?></h4>
            <div class="form-group">
                <label><?= lang('sender_email') ?></label>
                <input type="email" class="form-control" value="<?= $smtp_mail ?>" name="smtp_mail">
            </div>
            <div class="form-group">
                <label><?= lang('smtp_password') ?></label>
                <input type="password" name="smtp_pw" cols="" rows="3" class="form-control" value="<?= $smtp_pw ?>" autocomplete="new-password">
            </div>
            <div class="form-group">
                <label><?= lang('sender_name') ?></label>
                <input type="from_name" class="form-control" value="<?= $smtp_from_name ?>" name="smtp_from_name">
            </div>
            <div class="form-group">
                <label><?= lang('smtp_server') ?></label>
                <input class="form-control" value="<?= $smtp_server ?>" name="smtp_server">
            </div>
            <div class="form-group">
                <label><?= lang('smtp_port') ?> <?= lang('smtp_port_info') ?></label>
                <input class="form-control" value="<?= $smtp_port ?>" name="smtp_port">
            </div>
            <div class="form-group">
                <input type="button" value="<?= lang('send_test') ?>" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#testMail" />
            </div>
            <div class="alert alert-warning">
		<?= lang('send_test_prompt') ?>
            </div>
            <!-- Set the modal box for receiving mailboxes -->
            <div class="modal fade" id="testMail">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header border-0">
                            <h4 class="modal-title"><?= lang('send_test') ?></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input class="form-control" type="email" name="testTo" placeholder="输入接收邮箱">
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <div id="testMailMsg"></div>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
                            <button type="button" class="btn btn-success btn-sm" id="testSendBtn"><?= lang('send') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <h4><?= lang('mail_template') ?></h4>
            <div class="my-3">
                <div class="mb-3" id="mail_template_box"><?= lang('select_mail_template') ?> <a href="javascript:useDefaultTemplate();"><?= lang('mail_template_1') ?></a>
                    <a href="javascript:useDeepBlueTemplate();"><?= lang('mail_template_2') ?></a>
                    <a href="javascript:useGreenVibrantTemplate();"><?= lang('mail_template_3') ?></a>
                    <span id="mail_template_box_ext"></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <textarea id="mail_template" name="mail_template" rows="10" class="form-control" placeholder="<?= lang('mail_template_tip') ?>"><?= $mail_template ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <iframe id="mail_review_frame"></iframe>
                    </div>
                </div>
                <div class="mb-3 mt-1 small" id="mail_template_box"><?= lang('_template_variables') ?> {{mail_content}} <?= lang('_mail_content') ?> {{mail_site_title}} <?= lang('site_title') ?></div>
            </div>
            <h4><?= lang('email_notify') ?></h4>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="mail_notice_comment" id="mail_notice_comment" <?= $conf_mail_notice_comment ?> />
                <label class="custom-control-label" for="mail_notice_comment"><?= lang('comment_new_notify') ?></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="mail_notice_post" id="mail_notice_post" <?= $conf_mail_notice_post ?>>
                <label class="custom-control-label" for="mail_notice_post"><?= lang('article_new_notify') ?></label>
            </div>
            <div class="form-group mb-0">
                <hr>
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?= lang('save_settings') ?>" class="btn btn-sm btn-success" />
            </div>
        </form>
    </div>
</div>
<script>
    function updatePreview() {
        const htmlCode = htmlInput.value;
        const previewDocument = previewFrame.contentDocument;
        previewDocument.open();
        previewDocument.write(htmlCode);
        previewDocument.close();
    }

    function useDefaultTemplate() {
        const defaultTemplate = `<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f7f7f7;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 16px rgba(0,0,0,.1);">
        <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px;">
            <h1 style="font-size: 24px; margin: 0; color: #333;">{{mail_site_title}}</h1>
        </div>
        <div style="font-size: 16px; color: #333; line-height: 1.6;">
            <p>{{mail_content}}</p>
        </div>
        <div style="border-top: 1px solid #e0e0e0; padding-top: 10px; text-align: center; font-size: 12px; color: #888; margin-top: 20px;">
            <small><?= lang('from_site') ?>：{{mail_site_title}}</small>
        </div>
    </div>
</body>
</html>`;
        $('#mail_template').val(defaultTemplate);
        updatePreview();
    }

    function useDeepBlueTemplate() {
        const deepBlueTemplate = `<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{font-family:Arial,sans-serif;margin:0;padding:0;background:#f7f9fb}.container{max-width:600px;margin:0 auto;background:#fff;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.1)}.header{background:#0066cc;color:#fff;padding:20px;text-align:center}.header h1{margin:0;font-size:24px}.content{padding:20px;color:#333;line-height:1.6}.footer{padding:15px;text-align:center;font-size:12px;color:#888;background:#f7f9fb}.divider{margin:20px 0;border-bottom:1px solid #e0e0e0}.cta-button{display:inline-block;background:#0066cc;color:#fff;padding:12px 20px;text-decoration:none;border-radius:30px;font-weight:bold;margin-top:20px}.cta-button:hover{background:#004d99}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{mail_site_title}}</h1>
        </div>
        <div class="content">
            <p>{{mail_content}}</p>
            <div class="divider"></div>
        </div>
        <div class="footer">
            <small><?= lang('from_site') ?>：{{mail_site_title}}</small>
        </div>
    </div>
</body>
</html>`;
        $('#mail_template').val(deepBlueTemplate);
        updatePreview();
    }

    function useGreenVibrantTemplate() {
        const greenVibrantTemplate = `<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{font-family:'Arial',sans-serif;margin:0;padding:0;background:#e8f7ec}
        .container{max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;box-shadow:0 4px 16px rgba(0,0,0,.1)}
        .header{background:#4caf50;color:#fff;padding:20px;text-align:center;border-radius:12px 12px 0 0}
        .header h1{margin:0;font-size:28px;font-weight:bold}
        .content{padding:25px;color:#333333;line-height:1.8;text-align:center}
        .content p{font-size:18px;margin:0 0 20px}
        .content .cta-button{display:inline-block;background:#66bb6a;color:#fff;padding:14px 24px;text-decoration:none;border-radius:50px;font-weight:bold;font-size:18px;box-shadow:0 4px 8px rgba(0,0,0,.1);transition:background-color .3s ease-in-out}
        .content .cta-button:hover{background:#388e3c}
        .footer{padding:15px;text-align:center;font-size:14px;color:#777;background:#4caf50;border-radius:0 0 12px 12px}
        .footer small{display:block}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{mail_site_title}}</h1>
        </div>
        <div class="content">
            <p>{{mail_content}}</p>
        </div>
        <div class="footer">
            <small><?= lang('from_site') ?>：{{mail_site_title}}</small>
        </div>
    </div>
</body>
</html>`;
        $('#mail_template').val(greenVibrantTemplate);
        updatePreview();
    }
    // mail template preview
    const htmlInput = document.getElementById('mail_template');
    const previewFrame = document.getElementById('mail_review_frame');
    updatePreview();
    htmlInput.addEventListener('input', updatePreview);

    $(function() {
        // menu
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);

        // Submit Form 
        $("#mail_setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#mail_setting_form");
        });

        // test sendmail
        $("#testSendBtn").click(function() {
            $("#testMailMsg").html("<small class='text-secondary'><?= lang('sending') ?>...<small>");
            $.post("setting.php?action=mail_test", $("#mail_setting_form").serialize(), function(data) {
                if (data === '') {
                    $("#testMailMsg").html("<small class='text-success'><?= lang('send_ok') ?></small>");
                } else {
                    $("#testMailMsg").html(data);
                }

            });
        })
    });
</script>