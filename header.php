<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php require_once 'functions.php'; ?>
<!DOCTYPE HTML>
<?php

if ($this->options->style_BG) {
    echo '<style>';
    echo "\n";
    echo 'body{background: #fff;}body::before {background: url(\'';
    $this->options->style_BG();
    echo '\') center/cover no-repeat;}blockquote::before {background: transparent !important;}';
    echo "\n";
    echo '</style>';
    echo "\n";
}
?>
<html>
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="
	<?php if ($this->options->shortcut_ico) {
        $this->options->shortcut_ico();
    } ?>" type="image/x-icon"/>
    <?php Typecho_Plugin::factory('PaceJs')->render(); ?>
    <title><?php $this->archiveTitle(array(
            'category' => _t('%s'),
            'search' => _t('%s'),
            'tag' => _t('%s'),
            'author' => _t('%s')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>

    <!-- 使用url函数转换相关路径 -->
    <link href="https://cdn.jsdelivr.net/gh/FortAwesome/Font-Awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="https://lib.baomitu.com/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl('assert/css/prism.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl('assert/css/zoom.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl('assert/css/main.css'); ?>">
    <link rel="stylesheet" href="http://anijs.github.io/lib/anicollection/anicollection.css">
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl('assert/css/card.css'); ?>">
    <?php if ($this->options->isIconNav == 'on'): ?>
        <link type="text/css" rel="stylesheet"
              href="<?php $this->options->themeUrl('assert/css/twemoji-awesome.css'); ?>">
    <?php endif; ?>

    <!--[if lt IE 9]>
    <script src="http://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="http://cdn.staticfile.org/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
</head>
<body>
<!--[if lt IE 8]>
<div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a
        href="http://browsehappy.com/">升级你的浏览器</a>'); ?>.
</div>
<![endif]-->

<header id="header" class="clearfix">
    <img class="avatar-right" src="<?php $this->options->themeUrl('/assert/remu.png') ?>">
    <div class="container-fluid">
        <div class="row">

            <div class="logo">
                <div class="header-logo">
                    <!-- 标题开始 -->
                    <?php if ($this->options->NAME): ?>
                        <?php
                        function str_split_unicode($str, $l = 0)
                        {              // 字符串转数组,为了支持标题中文
                            if ($l > 0) {
                                $ret = array();
                                $len = mb_strlen($str, "UTF-8");
                                for ($i = 0; $i < $len; $i += $l) {
                                    $ret[] = mb_substr($str, $i, $l, "UTF-8");
                                }
                                return $ret;
                            }
                            return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
                        }

                        $s = $this->options->NAME;
                        $NAME = str_split_unicode($s);
                        ?>
                        <a href="<?php $this->options->adminUrl('login.php'); ?>">
                            <span class="b"><?php echo $NAME['0']; ?></span></a>
                        <span class="b"><?php echo $NAME['1']; ?></span>
                        <a href="<?php $this->options->siteUrl(); ?>">
                            <span class="w"><?php echo $NAME['2']; ?></span>
                        </a>
                        <span class="b"><?php echo $NAME['3']; ?></span>
                        <span class="b"><?php echo $NAME['4']; ?></span>
                    <?php else : ?>
                        <a href="<?php $this->options->adminUrl('login.php'); ?>">
                            <span class="b">I</span></a>
                        <span class="b">N</span>
                        <a href="<?php $this->options->siteUrl(); ?>">
                            <span class="w">N</span>
                        </a>
                        <span class="b">E</span>
                        <span class="b">I</span>
                    <?php endif ?>
                    <!-- 标题结束 -->

                    <a id="btn-menu" href="javascript:isMenu();">
                        <span class="b">·</span>
                    </a>
                    <a href="javascript:isMenu1();">
                        <?php if ($this->options->isIconNav == 'on'): ?>
                            <span id="menu-1" class="bf"><i class="twa twa-flags"></i></span>
                        <?php else: ?>
                            <span id="menu-1" class="bf">1</span>
                        <?php endif; ?>
                    </a>
                    <a href="javascript:isMenu2();">
                        <?php if ($this->options->isIconNav == 'on'): ?>
                            <span id="menu-2" class="bf"><i class="twa twa-evergreen-tree"></i></span>
                        <?php else: ?>
                            <span id="menu-2" class="bf">2</span>
                        <?php endif; ?>
                    </a>
                    <a href="javascript:isMenu3();">
                        <?php if ($this->options->isIconNav == 'on'): ?>
                            <span id="menu-3" class="bf"><i class="twa twa-mag"></i></span>
                        <?php else: ?>
                            <span id="menu-3" class="bf">3</span>
                        <?php endif; ?>
                    </a>
                </div>
                <div id="menu-page">
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while ($pages->next()): ?>
                        <a href="<?php $pages->permalink(); ?>">
                            <li><?php $pages->title(); ?></li>
                        </a>
                    <?php endwhile; ?>
                    <?php if ($this->options->isRSS == 'on') : ?>
                        <a href="<?php $this->options->feedUrl(); ?>">
                            <li>RSS</li>
                        </a>
                    <?php endif; ?>
                </div>
                <div id="search-box">
                    <form id="search" method="post" action="./" role="search">
                        <input autocomplete="off" type="text" name="s" id="menu-search"
                               style="border-radius: 100px" placeholder="Type something~"/>
                    </form>
                </div>
            </div>
        </div>
        <div class="hitokoto"><?php if ($this->options->hitokoto == 'on'): ?>
                <?php $this->need('hitokoto.php') ?>
            <?php endif; ?>
        </div>
    </div>
</header>

<div id="body" class="clearfix">