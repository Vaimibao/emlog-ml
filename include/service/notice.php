<?php

/**
 * Service: Notice
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Notice
{

    // Send user registration verification code email
    public static function sendRegMailCode($mail)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $randCode = getRandStr(6, false, true);
        $_SESSION['mail_code'] = $randCode;
        $_SESSION['mail'] = $mail;

        $title = lang('email_verif_code_title');
        $content = sprintf('<div id="email_code">'. lang('email_verif_code') .'<b style="color: orange;">%s</b></div>', $randCode);
        return self::sendMail($mail, $title, $content);
    }

    // General method of sending verification code
    public static function sendVerifyMailCode($mail)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $randCode = getRandStr(6, false, true);
        $_SESSION['mail_code'] = $randCode;
        $_SESSION['mail'] = $mail;

        $title = lang('email_verif_title');
        $content = sprintf('<div id="email_code">'. lang('email_verif_code') .'<b style="color: orange;">%s</b></div>', $randCode);
        return self::sendMail($mail, $title, $content);
    }

    public static function sendResetMailCode($mail)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $randCode = getRandStr(6, false, true);
        $_SESSION['mail_code'] = $randCode;
        $_SESSION['mail'] = $mail;

        $title = lang('reset_password_code');
        $content = sprintf('<div id="email_code">'. lang('email_verif_code') .'<span>%s</span></div>', $randCode);
        return self::sendMail($mail, $title, $content);
    }

    public static function sendNewPostMail($postTitle, $gid)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (Option::get('mail_notice_post') === 'n') {
            return false;
        }
        $mail = self::getFounderEmail();
        if (!$mail) {
            return false;
        }
        $title = "你的站点收到新的文章投稿";
        $url = Url::log($gid);
        $content = sprintf(lang('new_article_title') . '<a href="%s">%s</a>', $url, $postTitle);
        return self::sendMail($mail, $title, $content);
    }

    public static function sendNewCommentMail($comment, $gid, $pid)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (Option::get('mail_notice_comment') === 'n') {
            return false;
        }

        $content = lang('new_comment_is') . $comment;
        $article = self::getArticleInfo($gid);

        if (empty($article)) {
            return false;
        }

        if ($pid) {
            $title = lang('new_comment_reply_review');
            $content .= '<hr>'. lang('from_article') .'<a href="' . Url::log($article['logid']) . '" target="_blank">' . $article['log_title'] . '</a>';
            $mail = self::getCommentAuthorEmail($pid);
        } else {
            $title = lang('new_comment_review');
            $content .= '<hr>'. lang('from_article') .'<a href="' . Url::log($article['logid']) . '" target="_blank">' . $article['log_title'] . '</a>';
            $mail = self::getArticleAuthorEmail($article['author']);
        }
        if (!$mail) {
            return false;
        }
        return self::sendMail($mail, $title, $content);
    }

    public static function getFounderEmail()
    {
        $User_Model = new User_Model();
        $r = $User_Model->getOneUser(1);
        if (isset($r['email']) && checkMail($r['email'])) {
            return $r['email'];
        }
        return false;
    }

    public static function getArticleAuthorEmail($uid)
    {
        $User_Model = new User_Model();
        $r = $User_Model->getOneUser($uid);
        if (isset($r['email']) && checkMail($r['email'])) {
            return $r['email'];
        }
        return false;
    }

    public static function getCommentAuthorEmail($cid)
    {
        $Comment_Model = new Comment_Model();
        $r = $Comment_Model->getOneComment($cid);
        if (isset($r['mail']) && checkMail($r['mail'])) {
            return $r['mail'];
        }
        return false;
    }

    public static function sendMail($mail, $title, $content)
    {
        $content = self::getMailTemplate($content);
        $sendmail = new SendMail();
        $ret = $sendmail->send($mail, $title, $content);
        if ($ret) {
            return true;
        }
        return false;
    }

    public static function sendMail2Founder($title, $content)
    {
        $mail = self::getFounderEmail();
        if (!$mail) {
            return false;
        }
        $content = self::getMailTemplate($content);
        $sendmail = new SendMail();
        $ret = $sendmail->send($mail, $title, $content);
        if ($ret) {
            return true;
        }
        return false;
    }

    public static function getMailTemplate($content)
    {
        $mailTemplate = Option::get('mail_template');
        if (!empty(trim($mailTemplate))) {
            return str_replace(['{{mail_content}}', '{{mail_site_title}}'], [$content, Option::get('blogname')], $mailTemplate);
        }
        return $content;
    }

    private static function smtpServerReady()
    {
        if (empty(Option::get('smtp_pw')) || empty(Option::get('smtp_mail'))) {
            return false;
        }
        return true;
    }

    private static function getArticleInfo($gid)
    {
        $Log_Model = new Log_Model();
        $r = $Log_Model->getOneLogForHome($gid);
        if (isset($r['author'])) {
            return $r;
        }
        return false;
    }
}
