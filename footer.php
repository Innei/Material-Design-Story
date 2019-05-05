<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
</div><!-- end #body -->

<footer id="footer" role="contentinfo" style="position: relative;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                &copy; <?php echo date('Y'); ?> <a
                        href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
                <?php _e('Using <a target="_blank" href="http://www.typecho.org">Typecho</a> & <a target="_blank" href="https://github.com/Innei/Material-Design-Story">Card Design</a>'); ?>
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
                        var birthDay = Date.UTC(<?php $this->options->jstime();?>);
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
                    <ul>
                        <?php $this->widget('Widget_Comments_Recent', 'pageSize=4')->to($comments); ?>
                        <?php while ($comments->next()): ?>
                            <li><a href="<?php $comments->permalink(); ?>" rel="nofollow"
                                   target="_blank"><?php $comments->author(false); ?>
                                    ：<?php $comments->excerpt(10, '...'); ?></a></li>
                        <?php endwhile; ?></ul>
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
        <?php if ($this->is('post')): ?>
        <?php $postConfig = parse_title($this->content);?>
        <?php if ($postConfig): ?>
        isMenu2('auto');
        <?php endif; ?>
        <?php endif; ?>
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
        // go-top
        {
            let goTop = document.getElementById('go-top');
            // 判断是否点击
            let flag = 0;
            // alert(totalHeight);
            // 获取正在显示的长度
            let showHeight = window.innerHeight;
            let container = document.querySelector('html');
            // 判断滚动条高度需要添加 overflow: auto 属性
            window.onscroll = function () {
                if (container.scrollTop > showHeight && flag === 0) {
                    goTop.style.transform = 'scale(1)';
                } else if (container.scrollTop <= showHeight) {
                    goTop.style.transform = '';
                }

                // 点击时, 回到 0,0点
                goTop.onclick = function () {
                    goTop.style.transform = '';
                    flag = 1;
                    let curTop = container.scrollTop;
                    // 平滑移动
                    let timer = setInterval(function () {
                        // 如果到达 0,0 取消定时器
                        if (container.scrollTop === 0) {
                            clearInterval(timer);

                            // 别忘了设回 0
                            flag = 0;
                        }
                        container.scrollTo(0, curTop);
                        // 速度设定
                        curTop -= 50;

                    }, 10);
                };
            };


            // 窗口改变时
            window.onresize = function () {
                showHeight = window.innerHeight;
            }
        }

        {
            if (document.querySelector('#torTree > div > div')) {
                const torArr = document.querySelectorAll('#torTree > div > div > a');

                function getElementTop(element) {
                    var actualTop = element.offsetTop;
                    var current = element.offsetParent;

                    while (current !== null) {
                        actualTop += current.offsetTop;
                        current = current.offsetParent;
                    }

                    return actualTop;
                }

                for (var i = 0; i < torArr.length; i++) {
                    torArr[i].onclick = function (e) {
                        var Top = getElementTop(document.getElementById(`${this.getAttribute('href').replace(/^#/, '')}`)) - 10;
                        const timer = setInterval(
                            () => {
                                let curTop = document.documentElement.scrollTop;

                                if (Math.abs(curTop - Top) < 50) {
                                    window.scrollTo(0, Top);
                                    clearInterval(timer);
                                    return;
                                }

                                if (curTop < Top) {
                                    curTop += 50;
                                    window.scrollTo(0, curTop);
                                } else if (curTop > Top) {
                                    curTop -= 50;
                                    window.scrollTo(0, curTop);
                                } else {
                                    clearInterval(timer);
                                }
                            }
                            , 10);

                        e.preventDefault();
                    };
                }


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

    function isMenu2(c = 'none') {
        if (document.getElementById('torTree')) {
            if ($("#torTree").attr('style') == 'display: none;') {
                $("#torTree").fadeIn(300);
                $("#torTree").css('display', 'inline-block');
            } else {
                $("#torTree").fadeOut(300);
            }
        } else {
            if (c != 'auto') {
                alert('人家是导航树哦！只有在特定的文章页面才会出现哦...');
            }
        }
    }

    function isMenu3() {
        if (document.getElementById('search-box').style.display == 'block') {
            $('#search-box').fadeOut(300);
        } else {
            $('#search-box').fadeIn(300);
        }
    }

    // 评论区过度

    function isComments() {
        if (document.getElementById('btn-comments').innerText == 'show comments') {
            document.getElementById('btn-comments').innerText = 'hide comments';
            document.getElementById('comments').style.maxHeight = 2000 + 'px';

        } else {
            document.getElementById('btn-comments').innerText = 'show comments';
            document.getElementById('comments').style.maxHeight = 0;

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

    function footerPosition() {
        $("footer").removeClass("fixed-bottom");
        var contentHeight = document.body.scrollHeight,
            winHeight = window.innerHeight;
        if (document.getElementsByClassName("post-content")[0]) {
            var winImgNum = document.getElementsByClassName("post-content")[0].getElementsByTagName("img").length;
        } else {
            var winImgNum = 0;
        }
        if (!(contentHeight > winHeight) && winImgNum <= 1) {
            $("footer").addClass("fixed-bottom");
        }
    }

    footerPosition();
    $(window).resize(footerPosition);



    <?php if($this->is('post') || $this->is('page-link') || $this->is('page-archive')):?>
    var article = $('#main > article');
    $(document).ready(function () {
        article.removeClass('hidden');
        article.toggleClass('fadeInUp animated');
        article.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function (e) {
            $(e.target).removeClass('fadeInUp animated');

        });

    });
    <?php endif;?>
    <?php if($this->is('index')):?>
    $(document).ready(function () {
        var card = $('#main > ul > li > a.colorgradient-card');
        card.removeClass('hidden');
        card.toggleClass('zoomIn animated');
        card.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function (e) {
            $(e.target).removeClass('zoomIn animated');

        });

    });
    <?php endif;?>

</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<?php if ($this->options->analysis != null): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php $this->options->analysis() ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '<?php $this->options->analysis() ?>');
    </script>
<?php endif; ?>
<div id="go-top"></div>
<?php $this->footer(); ?>
</body>
</html>