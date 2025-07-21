var LNG = {
//---------------------------
//admin/views/article_write.php
    'leave_prompt': 'Leave page prompt',//'离开页面提示',
    'already_edited': '[already edited] ',//'[已修改] ',

// admin/views/article.php
    'select_article': 'Please select the article to operate',//'请选择要操作的文章',
    'sure_delete_articles': 'Are you sure you want to delete the selected articles',//'确定要删除所选文章吗',

// admin/views/comment.php
    'comment_operation_select': 'Please select a comment',//'请选择评论',
    'comment_selected_delete_sure': 'Are you sure you want to delete the selected comment',//'确定要删除所选评论吗',

// admin/views/media.php
    'resource_select': 'Please select a resource file',//'请选择资源文件',
    'resource_del_sure': 'Are you sure you want to delete the selected resource file',//'确定要删除所选资源文件吗',

// admin/views/page.php
    'select_page_to_operate': 'Please select a page',//'请选择页面',
    'sure_delete_selected_pages': 'Are you sure you want to delete the selected page',//'确定要删除所选页面吗',

//---------------------------
//admin/views/plugin.php
    'update': 'Update',//'更新',
    'updating': 'Updating...',//'正在更新...',
    'update_request_failed': 'Update request failed, please try again later',//'更新请求失败，请稍后重试',
    'plugin_update_check_fail': 'Plug-in update check failed, error code: ',//'插件更新检查无法正常进行,错误码:',
    'plugin_update_check_exception': 'Plugin update check exception: ',//'插件更新检查异常： ',

//---------------------------
//admin/views/signup.php
    'send_email_code': 'Send email verification code',//'发送邮件验证码',
    'code_valid_for': 'Sent successfully, please check your email in ',//'发送成功，请查收邮件 ',
    '_seconds': ' seconds',//'秒',
    'test_mail_failed': 'Failed to send',//'发送失败',

//---------------------------
//admin/views/tag.php
    'tag_select_del': 'Please select a tag to delete',//'请选择要删除的标签',
    'tag_delete_sure': 'Are you sure you want to delete the selected tags',//'确定要删除所选标签吗',

//---------------------------
//admin/views/template.php
    'update_api_error': 'The update interface returned an error',//'更新接口返回错误',
    'update_request_error': 'The request to update the interface failed',//'请求更新接口失败',

//---------------------------
//admin/views/js/common.js
    'ok': 'OK',//'确定',
    'cancel': 'Cancel',//'取消',
    'delete': 'Delete',//'删除',
    'delete_permanently': 'Delete permanently',//'彻底删除',
    'disable': 'Disable',//'禁用',
    'restore': 'Restore',//'重置',
    'article_del_sure': 'Are you sure you want to delete this article?',//'删除这篇文章？',
    'draft_del_sure': 'Are you sure you want to delete this draft?',//'删除这篇草稿？',
    'twitter_del_sure': 'Are you sure you want to delete this note?',//'删除这条微语？',
    'comment_del_sure': 'Are you sure you want to delete this comment?',//'删除这条评论？',
    'comment_ip_del_sure': 'Are you sure you want to delete all comments from that IP?',//'删除来自该IP的所有评论',
    'link_del_sure': 'Are you sure you want to delete this link?',//'删除该链接？',
    'navi_del_sure': 'Are you sure you want to delete this navigation?',//'删除该导航？',
    'attach_del_sure': 'Are you sure you want to delete this file?',//'删除该文件？',
    'avatar_del_sure': 'Are you sure you want to delete this avatar?',//'删除头像？',
    'category_del_sure': 'Are you sure you want to delete this category?',//'删除该分类？',
    'user_del_sure': 'Are you sure you want to delete this user?',//'删除该用户？',
    'user_disable_sure': 'Are you sure you want to disable this user?',//'禁用该用户？',
    'template_del_sure': 'Are you sure you want to delete default template?',//'删除该模板？'
    'plugin_reset_sure': 'Are you sure you want to restore default plugin settings? This operation will lose your custom plugin configuration.',//'重置组件？重置会丢失自定义的组件',
    'plugin_del_sure': 'Are you sure you want to delete this plugin?',//'删除该插件？',
    'media_category_del_sure': 'Are you sure you want to delete this resource category (resource files will not be deleted)?',//'确定要删除该资源分类吗（不会删除资源文件）？',
    'ai_model_del_sure': 'Are you sure you want to delete this AI model?',//'删除该模型？',
    'change_to_draft': 'Change to draft',//'放入草稿',
    'alias_link_error': 'Link Alias error',//'链接别名错误',
    'alias_invalid_chars': 'Alias should contain only latin letters, numbers, underscores and dashes',//'别名错误，应由字母、数字、下划线、短横线组成',
    'alias_digital': 'Alias cannot contain numbers only',//'别名错误，不能为纯数字',
    'alias_format_must_be': 'Invalid alias. It can not contain \'post\' or \'post-digits\'',//'别名错误，不能为\'post\'或\'post-数字\'',
    'alias_system_conflict': 'Alias error (system conflict)',//'别名错误，与系统链接冲突',
    'alias_link_error_not_saved': 'Invalid Link Alias. Can not be saved automatically.',//'链接别名错误，自动保存失败',
    'saving': 'Saving...',//'正在保存中...',
    'saved_ok_time': 'Saved at ',//'保存于：',
    'save_system_error': 'Failed to save, maybe the article cannot be edited or the daily post limit has been reached',//'保存失败，可能文章不可编辑或达到每日发文限额',
    'too_quick': 'Do not operate frequently!',//'请勿频繁操作！',
    'publish_page_first': 'Please publish the page first!',//'请先发布页面！',
    'page_content_empty': 'Page content cannot be empty!',//'页面内容不能为空！',
    'saving_in': '[Saving] ',//'[保存中...] ',
    'saved_ok': '[Saved successfully]: ',//'[保存成功] ',
    'saved_ok_msg': 'Saved successfully: ',//'保存成功',
    'save_failed': '[Save failed]: ',//'[保存失败] ',
    'save_failed!': 'Save failed!',//'保存失败！',
    'save_failed_prompt': 'Failed to save, please backup content, refresh the page and try again!',//'保存失败，请备份内容和刷新页面后重试！',
    'paste_upload': 'Paste upload ',//'粘贴上传 ',
    'uploading': 'Uploading...',//'上传中...',
    'progress': 'Progress (bytes): ',//'进度(bytes): ',
    'upload_ok_get_result': 'Upload successful! Getting results...',//'上传成功！正在获取结果...',
    'result_ok': 'Get the result successfully!',//'获取结果成功！',
    'unknown_error': 'Unknown error',//'未知错误',
    'upload_failed_error': 'Upload failed, wrong image type or network error',//'上传失败，图片类型错误或网络错误',
    'installing': 'Installing...',//'安装中…',
    'install': 'Install',//'安装',
    'install_free': 'Install for free',//'免费安装',
    'get_result_fail': 'Failed to get result!',//'获取结果失败！',

//----
    'backup_import_sure': 'Are you sure you want to import the backup files?',//'你确定要导入该备份文件吗？',
    'page_del_sure': 'Are you sure you want to delete this page?',//'你确定要删除该页面吗？',
    'title_empty': 'Title can not be empty',//'标题不能为空',
    'wysiwyg_switch': 'Please, switch to WYSIWYG mode',//'请先切换到所见所得模式',
    'click_view_fullsize': 'Click to view full size',//'点击查看原图',
    'media_delete' : 'Are you sure you want to delete this resource?',//'确定要删除该资源吗？',
    'media_select': 'Please select a media file to move',//'请选择要移动的资源',
    'delete_not_recover': 'Deleted may not be recoverable',//'删除后可能无法恢复',
    'category_not_deleted': 'The resource files under the category will not be deleted',//'不会删除分类下资源文件',
    'emlog_not_registered': 'Your emlog has not been registered',//'您的emlog未完成正版注册',
    'register': 'Register',//'去注册',
    'is_latest_version': 'Already the latest version',//'已经是最新版本',
    'update_expired': 'Update service has expired',//'更新服务已到期',
    'log_in_renew': 'Log in to the official website to renew',//'登录官网续期',
    'new_ver_available': 'There is a new version available ',//'有可用的新版本 ',
    'check_for_new': 'Change log',//'查看更新内容',
    'update_now': 'Update now',//'现在更新',
    'check_failed': 'Check failed, may be a network problem',//'检查失败，可能是网络问题',
    'updating_now': 'Updating..., please wait patiently',//'更新中... 请耐心等待',
    'refresh_the_page': 'Refresh the page',//'刷新页面',
    'updated_ok': 'Congratulations! The update is successful, <a href="./">refresh the page</a> to start experiencing the new version',//'🎉恭喜，更新成功了🎉，<a href="./">刷新页面</a>开始体验新版本',
    'update_download_fail': 'Failed to download the update, it may be a server network problem',//'下载更新失败，可能是服务器网络问题',
    'unzip_fail': 'Failed to decompress and update. your server does not support zip',//'解压更新失败，可能是你的服务器空间不支持zip模块',
    'update_not_writable': 'Update failed, the directory is not writable',//'更新失败，目录不可写',
    'update_fail': 'Update failed',//'更新失败',
    'save_first': 'Please save the page first!',//'请先保存页面！',
    'content_empty': 'Page content cannot be empty!',//'页面内容不能为空！',
    'plugin': 'Plugin: ',//'插件：',
    'template': 'Template: ',//'模板：',
    'buy': 'Buy',//'购买',
    'go_store_install': 'Go to the store to install',//'去商店安装',
    'free': 'Free',//'免费',
    'price': 'Price: ',//'应用售价',
    'used': 'Being used',//'使用中',
    'go_buy': 'Go to buy',//'去购买',
    'purchased': 'Purchased',//'已购买',
    'load_more_btn': 'Load more',//'点击加载更多',
    'all_loaded': 'All loaded',//'已加载全部内容',
    'failed_to_load': 'Failed to load. Click Retry to load',//'加载失败，点击重试加载',
    'recommend_today': 'Recommended today',//'今日推荐',
    '_template': 'Template',//'模板',
    '_plugin': 'Plug-in',//'插件',
    'svip': 'Hardcore free',//'铁杆免费',
    '_price': 'Price',//'售价',
    'price_unit': 'Yuan',//'元',
    'developer': 'Developer',//'开发者',
    'version_number': 'Version number',//'版本号',
    'download_count': 'Downloads',//'下载次数',
    'update_time': 'Update time',//'更新时间',

//---------------------------
//include/lib/js/common_tpl.js
    'loading': 'Loading...',//'加载中...',
    'max_140_bytes': '(Up to 140 characters)',//'(回复长度需在140个字内)',
    'nickname_empty': '(Nickname cannot be empty)',//'(昵称不能为空)',
    'captcha_error': '(Verification code error)',//'(验证码错误)',
    'nickname_disabled': '(This nickname is not allowed)',//'(不允许使用该昵称)',
    'nickname_exists': '(This nickname already exists)',//'(已存在该回复)',
    'comments_disabled': '(Comments disabled)',//'(禁止回复)',
    'comment_ok_moderation': '(Your comment saved successfully and is awaiting for moderation.)',//'(回复成功，等待管理员审核)',
    'chinese_must_have': 'The comment content must contain Chinese characters!',//'评论内容需要包含中文！',
    'email_invalid': 'The email format is wrong!',//'邮箱格式错误！',
    'url_invalid': 'URL format is wrong!',//'网址格式错误！',
    'toc': 'Table of contents',//'目录',

//---------------------------
//admin/views/js/dropzone.min.js
    'drag_message': 'Drag the file here, or click to upload',//'拖动文件到这里，或者点击后选择上传',

//---------------------------
//admin/views/js/media-lib.js
    'insert_to_article': 'Insert to the article',//'插入文章',
    'set_cover': 'Set as cover',//'设为封面',
    'public_download': 'Public download',//'公开下载',
    'user_download': 'Log in to download',//'登录下载',
    'file_size': 'File size: ',//'文件大小：',
    'upload_files': 'Upload image/file',//'上传图片/文件',

//----------------
// The LAST key. DO NOT EDIT!!!
    '@': '@'
};

//------------------------------
// Return the language var value
function lang(key) {
    if (LNG[key]) {
        val = LNG[key];
    } else {
        val = '{' + key + '}';
    }
    return val;
}
