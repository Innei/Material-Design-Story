<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
</div><!-- end #body -->

<footer id="footer" role="contentinfo">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                &copy; <?php echo date('Y'); ?> <a
                        href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
                <?php _e('Using <a target="_blank" href="http://www.typecho.org">Typecho</a> & <a target="_blank" href="https://github.com/SorashitaInnei/Material-Design-Story">Card Design</a>'); ?>
                .
                <?php

                if ($this->options->runtime == 'JS') : ?>
                    <p>本站已萌萌哒运行了<span id="showDays"></span></p>
                    <script>
                        var seconds = 1000;
                        var minutes = seconds * 60;
                        var hours = minutes * 60;
                        var days = hours * 24;
                        var years = days * 365;
                        var birthDay = Date.UTC(2019, 2, 14, 14, 30, 10);
                        setInterval(function () {
                            var today = new Date();
                            var todayYear = today.getFullYear();
                            var todayMonth = today.getMonth() + 1;
                            var todayDate = today.getDate();
                            var todayHour = today.getHours();
                            var todayMinute = today.getMinutes();
                            var todaySecond = today.getSeconds();
                            var now = Date.UTC(todayYear, todayMonth, todayDate, todayHour, todayMinute, todaySecond);
                            var diff = now - birthDay;
                            var diffYears = Math.floor(diff / years);
                            var diffDays = Math.floor((diff / days));
                            var diffHours = Math.floor((diff - (diffYears * 365 + diffDays) * days) / hours);
                            var diffMinutes = Math.floor((diff - (diffYears * 365 + diffDays) * days - diffHours * hours) / minutes);
                            var diffSeconds = Math.floor((diff - (diffYears * 365 + diffDays) * days - diffHours * hours - diffMinutes * minutes) / seconds);
                            document.getElementById('showDays').innerHTML = "" + diffDays + "天" + diffHours + "小时" + diffMinutes + "分钟" + diffSeconds + "秒";
                        }, 1000);
                    </script>
                <?php elseif ($this->options->runtime == 'PHP'):
                    $this->need('time.php');

                endif;
                ?>
            </div>
        </div>
        <div id="footer-infor">
            <div class="footer-item">
                <h3>站点信息：</h3>
                <ul>
                    <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
                    <li>文章：<?php $stat->publishedPostsNum() ?> 篇</li>
                    <li>分类：<?php $stat->categoriesNum() ?> 个</li>
                    <li>评论：<?php $stat->publishedCommentsNum() ?> 条</li>
                    <li>页面：<?php $stat->publishedPagesNum() ?> 个</li>
                </ul>
            </div>
            <div class="footer-item">
                <h3>最新文章：</h3>
                <ul>
                    <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=4')->parse('<li><a href="{permalink}" target="_blank">{title}</a></li>'); ?>
                </ul>
            </div>
            <div class="footer-item">
                <h3>时光机：</h3>
                <ul>
                    <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 m 月&limit=4')->parse('<li><a href="{permalink}" rel="nofollow" target="_blank">{date}</a></li>'); ?>
                </ul>
            </div>
            <div class="footer-item">
                <h3>最近评论：</h3>
                <div>
                    <?php $this->widget('Widget_Comments_Recent', 'pageSize=4')->to($comments); ?>
                    <?php while ($comments->next()): ?>
                        <a href="<?php $comments->permalink(); ?>" rel="nofollow" target="_blank"><img
                                    src="<?php echo Typecho_Common::gravatarUrl($comments->mail, 32, 'X', 'wavatar', $this->request->isSecure()) ?>"/><?php $comments->author(false); ?>
                            ：<?php $comments->excerpt(10, '...'); ?></a>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="https://lib.baomitu.com/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php $this->options->themeUrl('assert/js/prism.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assert/js/zoom-vanilla.min.js'); ?>"></script>
<script>
    window.onload = function () {
        <?php if($this->options->isAutoNav == 'on'): ?>
        var b = document.getElementsByClassName('b');
        var w = document.getElementsByClassName('w');
        var menupgMargin = (b.length + w.length) * 28;
        var srhboxMargin = (b.length + w.length + 3) * 28;
        var menusrhWidth = (b.length + w.length - 1) * 28;
        document.getElementById('menu-page').style['margin-left'] = menupgMargin + 'px';
        document.getElementById('search-box').style['margin-left'] = srhboxMargin + 'px';
        document.getElementById('menu-search').style['width'] = menusrhWidth + 'px';
        if (menusrhWidth < 140) {
            document.getElementById('menu-search').setAttribute('placeholder', 'Search~');
        }
        <?php endif; ?>

        if (window.location.hash != '') {
            var i = window.location.hash.indexOf('#comment');
            var ii = window.location.hash.indexOf('#respond-post');
            if (i != '-1' || ii != '-1') {
                document.getElementById('btn-comments').innerText = 'hide comments';
                document.getElementById('comments').style.display = 'block';
            }
        }
    };

    function isMenu() {
        if (document.getElementById('menu-1').style.display == 'inline') {
            $('#search-box').fadeOut(200);
            $('#menu-page').fadeOut(200);
            $('#menu-1').fadeOut(500);
            $('#menu-2').fadeOut(400);
            $('#menu-3').fadeOut(300);
        } else {
            $('#menu-1').fadeIn(150);
            $('#menu-2').fadeIn(150);
            $('#menu-3').fadeIn(150);
        }
    }

    function isMenu1() {
        if (document.getElementById('menu-page').style.display == 'block') {
            $('#menu-page').fadeOut(300);
        } else {
            $('#menu-page').fadeIn(300);
        }
    }

    function isMenu2() {
        if (document.getElementById('torTree')) {
            if (document.getElementById('torTree').style.display == 'block') {
                $('#torTree').fadeOut(300);
            } else {
                $('#torTree').fadeIn(300);
            }
        } else {
            alert('人家是导航树啦！只有在特定的文章页面才会出现哦...');
        }
    }

    function isMenu3() {
        if (document.getElementById('search-box').style.display == 'block') {
            $('#search-box').fadeOut(300);
        } else {
            $('#search-box').fadeIn(300);
        }
    }

    function isComments() {
        if (document.getElementById('btn-comments').innerText == 'show comments') {
            document.getElementById('btn-comments').innerText = 'hide comments';
            document.getElementById('comments').style.display = 'block';
        } else {
            document.getElementById('btn-comments').innerText = 'show comments';
            document.getElementById('comments').style.display = 'none';
        }
    }

    function Search404() {
        $('#menu-1').fadeIn(150);
        $('#menu-2').fadeIn(150);
        $('#menu-3').fadeIn(150);
        $('#search-box').fadeIn(300);
    }

    function goBack() {
        window.history.back();
    }

    $(function () {
        var top = $("#go-top");
        $(window).scroll(function () {
            ($(window).scrollTop() > 300) ? top.show(300) : top.hide(200);
            $("#go-top").click(function () {
                $('body,html').animate({scrollTop: 0});
                return false();
            })
        });
    });
</script>
<div id="go-top"></div>
<?php $this->footer(); ?>
</body>
</html>