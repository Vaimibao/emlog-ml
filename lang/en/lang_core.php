<?php
// LANG_CORE
$lang = array(

//---------------------------
//init.php
    'language' => 'Language',//'语言',

//---------------------------
//include/lib/cache.php
    'cache_date_format' => 'm.Y',//'Y年n月',
    'cache_not_writable' => 'Failed to write to the cache, the cache directory (content/cache) is not writable',//'写入缓存失败，缓存目录(content/cache)不可写',

//---------------------------
//include/lib/calendar.php

    'weekday1' => 'Mo',//'Monday',//'一',
    'weekday2' => 'Tu',//'Tuesday',//'二',
    'weekday3' => 'We',//'Wednesday',//'三',
    'weekday4' => 'Th',//'Thursday',//'四',
    'weekday5' => 'Fr',//'Friday',//'五',
    'weekday6' => 'Sa',//'Saturday',//'六',
    'weekday7' => 'Su',//'Sunday',//'日',

    'month_1' => 'January',
    'month_2' => 'February',
    'month_3' => 'March',
    'month_4' => 'April',
    'month_5' => 'May',
    'month_6' => 'Jun',
    'month_7' => 'July',
    'month_8' => 'August',
    'month_9' => 'September',
    'month_10' => 'October',
    'month_11' => 'November',
    'month_12' => 'December',

//---------------------------
//include/lib/common.php
    'not_editable' => 'Approved articles cannot be edited or deleted by users',//'审核通过的文章用户不可编辑、删除',

//---------------------------------------
//include/lib/databasepdo.php
    'pdo_ext_disabled' => 'PDO extension is not enabled for server PHP',//'服务器PHP未启用PDO扩展',
    'pdo_not_supported' => 'Server PHP does not support PDO function',//'服务器空间PHP不支持PDO函数',
    'pdo_connect_error' => 'Failed to connect to the database, please check the database information. Error message: ',//'连接数据库失败，请检查数据库信息。错误原因：',


//---------------------------
//include/lib/emcurl.php
    'need_curl_extension' => 'The request failed. Please install the Curl extension of PHP first.',//'请求失败，请先安装 PHP 的 Curl 扩展。',

//---------------------------
//include/lib/function.base.php
    '_load_failed' => ' load failed.',//'加载失败。',
    '_bytes' => ' bytes',//'字节',
    'home' => 'Home',//'首页',
    'first_page' => 'First',//'首页',
    'last_page' => 'Last',//'尾页',
    'read_more' => 'Read more&gt;&gt;',//'阅读全文&gt;&gt;',
    '_sec_ago' => ' seconds ago.',//'秒前',
    '_min_ago' => ' minutes ago.',//'分钟前',
    'about_' => '~ ',//'约 ',
    '_hour_ago' => ' hour(s) ago.',//' 小时前',
    '_day_ago' => ' day(s) ago.',//' 天前',
    '_month_ago' => ' month(s) ago.',//' 个月前',
    '_year_ago' => ' year(s) ago.',//' 年前',
    'file_size_exceeds_system' => 'File size exceeds the system limit ',//'文件大小超过系统 ',
    '_limit' => '',//' limit',//'限制',//LEAVE THIS EMPTY???
    'upload_failed_error_code' => 'Upload failed. Error code: ',//'上传文件失败,错误码: ',
    'file_type_not_supported' => 'This file type is not supported.',//'错误的文件类型',
    'file_size_exceeds_' => 'File size exceeds the limit ',//'文件大小超出',
    '_of_limit' => '',//' limit',//'的限制',
    'upload_folder_create_error' => 'Failed to create file upload directory.',//'创建文件上传目录失败',
    'upload_folder_unwritable' => 'Upload failed. Directory (content/uploadfile) cannot be written.',//'上传失败。文件上传目录(content/uploadfile)不可写',
    'failed_to_create_temporary_file' => 'Failed to create temporary file.', //'无法创建临时文件'
    'failed_to_write_temporary_file' => 'Failed to write temporary file.', //'无法写入临时文件'
//    '404_description' => 'Sorry, the page that you requested does not exist.',//'抱歉，你所请求的页面不存在！',
    'prompt' => 'Prompt Message',//'提示信息',
    'click_return' => 'Return back',//'点击返回',
    'upload_ok' => 'Upload successful',//'上传成功',

//---------------------------
//include/lib/loginauth.php
    'captcha' => 'Captcha',//'验证码',
    'captcha_error_reenter' => 'Captcha error. Please, re-enter.',//'验证错误，请重新输入',
    'user_name_wrong_reenter' => 'Wrong username. Please, re-enter.',//'用户名错误，请重新输入',
    'password_wrong_reenter' => 'Wrong password. Please, re-enter.',//'密码错误，请重新输入',
// 'no_permission'		=> 'Insufficient permissions!',//'权限不足！',
    'token_error' => 'Token verification failed. Please try to clean the browser cookie and refresh the page or change the browser to try again',//'Token校验失败，请尝试清理浏览器cookie后刷新页面或者更换浏览器重试',

//---------------------------
//include/lib/option.php
    'article' => 'Article',//'文章',
    'blogger' => 'Personal info',//'个人资料',
    'categories' => 'Categories',//'分类',
    'category' => 'Category',//'分类',
    'calendar' => 'Calendar',//'日历',
    'twitter' => 'Twitter',//'微语',
    'tags' => 'Tags',//'标签',
    'archive' => 'Archive',//'存档',
    'new_comments' => 'Latest comments',//'最新评论',
    'new_posts' => 'Latest posts',//'最新文章',
    'random_post' => 'Random entry',//'随机文章',
    'hot_posts' => 'Popular entries',//'热门文章',
    'links' => 'Links',//'链接',
    'search' => 'Search',//'搜索',
    'widget_custom' => 'Custom widget',//'自定义组件',
    'search_placeholder' => 'Search...and Enter',//'Search...and Enter',
    'unregistered_version' => 'Unregistered version ',//'&#x672A;&#x6CE8;&#x518C;&#x7684;&#x7248;&#x672C; ',

//---------------------------
//include/lib/sendmail.php
    'smtp_test' => 'Send STMP test mail',//'测试邮件STMP发送',

//---------------------------
//include/lib/view.php
    'template_not_found' => 'The current template has been deleted or corrupted. Please please login as administrator to replace other template.',//'当前使用的模板已被删除或损坏，请登录后台更换其他模板。',
    'template_corrupted' => 'Background template is corrupted',//'后台模板已损坏',

//---------------------------------------
//include/lib/mysql.php
    'mysql_not_supported' => 'Server does not support PHP MySql database',//'服务器空间PHP不支持MySql数据库',
    'db_database_unavailable' => 'Database connection error: The database server or database is unavailable.',//'连接数据库失败，数据库地址错误或者数据库服务器不可用',
    'db_port_invalid' => 'Database connection error: The database port is invalid.',//'连接数据库失败，数据库端口错误',
    'db_server_unavailable' => 'Database connection error: The database server is unavailable.',//'连接数据库失败，数据库服务器不可用',
    'db_credential_error' => 'Database connection error: Wrong username or password.',//'连接数据库失败，数据库用户名或密码错误',
    'db_error_code' => 'Failed to connect to the MySQL database, please check the database information. Error message: ',//'连接MySQL数据库失败，请检查数据库信息。错误信息：',
    'db_not_found' => 'Database connection failed. The database you filled in was not found.',//'连接数据库失败，未找到您填写的数据库',
    'db_sql_error' => 'SQL execution error',//'SQL执行错误',
    'unsupported_database_type' => 'Unsupported database type:',//'不支持的数据库类型:',

//---------------------------------------
//include/lib/mysqlii.php
    'mysqli_not_supported' => 'Server PHP does not support mysqli function',//'服务器PHP不支持mysqli函数',
//    'db_credential_error' => 'Failed to connect to the MySQL database, the database user name or password is incorrect',//'连接MySQL数据库失败，数据库用户名或密码错误',
//    'db_not_found' => 'Failed to connect to the MySQL database, the database you filled in was not found',//'连接MySQL数据库失败，未找到你填写的数据库',
// 'db_port_invalid'		=> 'Database connection error: The database port is invalid.',//'连接数据库失败，数据库端口错误',
    'db_unavailable' => 'Failed to connect to the MySQL database, the database address is wrong or the database server is unavailable',//'连接MySQL数据库失败，数据库地址错误或者数据库服务器不可用',
// 'db_server_unavailable'	=> 'Database connection error: The database server is unavailable.',//'连接数据库失败，数据库服务器不可用',
//    'db_error_code' => 'Failed to connect to the MySQL database, please check the database information. Error code: ',//'连接MySQL数据库失败，请检查数据库信息。错误编号：',
    'db_error_name' => 'Database connection error:  Please fill out the database name',//'连接数据库失败，请填写数据库名',
// 'db_sql_error'		=> 'SQL statement execution error',//'SQL语句执行错误',
    'utf8mb4_not_support' => 'MySQL does not support utf8mb4 character set, please upgrade to MySQL5.6 or later',//'MySQL缺少utf8mb4字符集，请升级到MySQL5.6或更高版本',

//---------------------------------------
//include/lib/twitter_model.php
// 'no_permission'	=> 'Insufficient permissions!',//'权限不足！',

//---------------------------------------
//include/model/media_model.php
    'del_failed' => 'Failed to delete!',//'删除失败!',

//---------------------------
//include/model/sort_model.php
    'uncategorized' => 'Uncategorized',//'未分类',

//---------------------------------------
//include/service/ai.php
    'useful_assistant' => 'You are a useful assistant',//'你是一个有用的助手',
    'no_ai_model' => 'AI model is not configured',//'AI 模型未配置'
    'model_processing_exception' => 'Large model processing exception:',//'大模型处理异常，请稍后再试，错误信息：'

//---------------------------------------
//include/service/media.php
    'media_upload_failed' => 'Upload failed, no file information received, can change the browser and try again',//'上传失败，未收到文件信息，可更换浏览器重试',
    'file_size_exceeds' => 'File size exceeds PHP',//'文件大小超过PHP'
    'file_size_limit' => 'limit',//'限制'
    'file_cannot_be_uploaded' => 'This type of file cannot be uploaded',//'不能上传该类型文件'
    'file_is_too_large' => 'The file is too large. The system restricts uploading:',//'文件太大了，系统限制上传：'

//---------------------------------------
//include/service/notice.php
    'new_article_review' => 'Your site receives new article submissions',//'你的站点收到新的文章投稿',
    'new_article_title' => 'The article title: ',//'文章标题：',
    'new_comment_reply_review' => 'Your comment has received a new reply',//'你的评论收到一条回复',
    'new_comment_review' => 'Your article has received a new comment',//'你的文章收到新的评论',
    'new_comment_is' => 'The comment is: ',//'评论内容是：',
    'from_article' => 'From article: ',//'来自文章',
    'email_verif_code_title' => 'Registered user email verification code',//'注册用户邮件验证码',
    'email_verif_code' => 'Email Verification Code: ',//'邮件验证码：',
    'email_verif_title' => 'Email Verification Code',//'邮件验证码',
    'reset_password_code' => 'Recover Password Email Verification Code',//'找回密码邮件验证码',
    'email_verify_code' => 'Email verification code: ',//'邮件验证码: ',
    'group_no_permission' => 'The user group you are in cannot use this function, please contact the administrator',//'你所在的用户组无法使用该功能，请联系管理员',
    'founder' => 'Founder',//'创始人',
    'admin' => 'Administrator',//'管理员',
    'registered_user' => 'Registered user',//'注册用户',
    'visitor' => 'Guest',//'游客',
    'editor' => 'Content Editor',//'内容编辑',

//---------------------------
//content/templates/default/404.php
    '404_error' => 'Error - page not found.',//'错误提示-页面未找到',
    '404_description' => 'Sorry, the page that you requested does not exist.',//'抱歉，你所请求的页面不存在！',
//    'click_return' => '&laquo;Return back',//'&laquo;点击返回',

//---------------------------
//content/templates/default/module.php
    'post_time' => 'Posted on',//'发布于',
    'reads' => 'Reads',//'阅读',

//---------------------------
//content/templates/default/footer.php
    'powered_by' => 'Powered by',
    'powered_by_emlog' => 'Powered by Emlog',//'采用emlog系统',

//---------------------------
//content/templates/default/module.php
// '_posts'			=> 'posts',//'篇文章',
// 'subscribe_category'	=> 'Subscribe this category',//'订阅该分类',
// 'subscribe_category'	=> 'Subscribe this category',//'订阅该分类',
    'view_image' => 'View image',//'查看图片',
    'more' => 'More &raquo;',//'更多&raquo;',
    'site_management' => 'Site management',//'管理',
    'logout' => 'Logout',//'退出',
    'top_posts' => 'Top entries',//'置顶文章',
    'cat_top_posts' => 'Category Top entries',//'分类置顶文章',
    'edit' => 'Edit',//'编辑',
// 'category'		=> 'Category',//'分类',
// 'tags'		=> 'Tags',//'标签',
// 'comments'		=> 'Comments',//'评论',
// 'reply'		=> 'Reply',//'回复',
// 'reply'		=> 'Reply',//'回复',
    'cancel_reply' => 'Cancel reply',//'取消回复',
    'comment_leave' => 'Leave a comment',//'发表评论',
    'nickname' => 'Nicname',//'昵称',
    'email_optional' => 'E-Mail adress (optional)',//'邮件地址 (选填)',
    'email_addr' => 'E-Mail address',//'邮件地址',
    'email' => 'E-mail',//'邮箱',
    'homepage' => 'Homepage',//'个人主页',
    'homepage_optional' => 'Homepage (optional)',//'个人主页 (选填)',
//    'comment_leave' => 'Post a comment',//'发布评论',
    'need_template_plugin' => 'Please enable the Template options plugin,',//'请开启【模板设置】插件，',
    'to_enable' => 'To enable',//'去开启'
    'need_logged_reply' => 'Please <a href="./admin/index.php">login</a> before posting comments',//'请先 <a href="./admin/index.php">登录</a> 再评论',
    'received'  => '',//''
    'comment_received'  => ' comment(s) received',//'条评论'

//---------------------------
//content/templates/default/pw.php
    'submit' => 'Submit',//'提交',

//---------------------------
//content/templates/default/side.php
    'rss_feed' => 'RSS Subscription',//'RSS订阅',
    'feed_rss' => 'RSS Subscription',//'订阅Rss',


);
