<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
</div><!-- end #body -->

<footer id="footer" role="contentinfo">
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
                            let today = new Date();
                            let todayYear = today.getFullYear();
                            let todayMonth = today.getMonth() + 1;
                            let todayDate = today.getDate();
                            let todayHour = today.getHours();
                            let todayMinute = today.getMinutes();
                            let todaySecond = today.getSeconds();
                            let now = Date.UTC(todayYear, todayMonth, todayDate, todayHour, todayMinute, todaySecond);
                            let diff = now - birthDay;
                            let diffYears = Math.floor(diff / years);
                            let diffDays = Math.floor((diff / days));
                            let diffHours = Math.floor((diff - (diffYears * 365 + diffDays) * days) / hours);
                            let diffMinutes = Math.floor((diff - (diffYears * 365 + diffDays) * days - diffHours * hours) / minutes);
                            let diffSeconds = Math.floor((diff - (diffYears * 365 + diffDays) * days - diffHours * hours - diffMinutes * minutes) / seconds);
                            document.getElementById('showDays').innerHTML = "" + diffDays + "天" + diffHours + "小时" + diffMinutes + "分钟" + diffSeconds + "秒";
                        }, 1000);
                    </script>
                <?php elseif ($this->options->runtime == 'PHP'):
                    $this->need('time.php');

                endif;
                ?>
            </div>
        </div>
        <section id="footer-infor">
            <div class="footer-item">

                <h3>站点信息：<i class="fas fa-globe-asia icon"></i></h3>
                <ul>
                    <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
                    <li>文章：<?php $stat->publishedPostsNum() ?> 篇</li>
                    <li>分类：<?php $stat->categoriesNum() ?> 个</li>
                    <li>评论：<?php $stat->publishedCommentsNum() ?> 条</li>
                    <li>页面：<?php $stat->publishedPagesNum() ?> 个</li>
                </ul>
            </div>
            <div class="footer-item">
                <h3>最新文章：<i class="fas fa-book-open icon"></i></h3>
                <ul>
                    <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=4')->parse('<li><a href="{permalink}" target="_blank">{title}</a></li>'); ?>
                </ul>
            </div>
            <div class="footer-item">
                <h3>时光机：<i class="fas fa-history icon"></i></h3>
                <ul>
                    <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 m 月&limit=4')->parse('<li><a href="{permalink}" rel="nofollow" target="_blank">{date}</a></li>'); ?>
                </ul>
            </div>
            <div class="footer-item">
                <h3>最近评论：<i class="far fa-comment icon"></i></h3>
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
        </section>
    </div>
</footer>
<script src="https://lib.baomitu.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pjax/pjax.js"></script>
<script src="<?php $this->options->themeUrl('assert/js/prism.js'); ?>" pjax></script>
<script src="<?php $this->options->themeUrl('assert/js/zoom-vanilla.min.js'); ?>" pjax></script>


<script>


    function loadAtfer() {

        <?php if($this->options->isAutoNav == 'on'): ?>
        const b = document.getElementsByClassName('b');
        const w = document.getElementsByClassName('w');
        const menupgMargin = (b.length + w.length) * 28;
        const srhboxMargin = (b.length + w.length + 3) * 28 + 30;
        const menusrhWidth = (b.length + w.length - 1) * 28;
        document.getElementById('menu-page').style['margin-left'] = menupgMargin + 'px';
        document.getElementById('search-box').style['margin-left'] = srhboxMargin + 'px';
        document.getElementById('menu-search').style['width'] = menusrhWidth + 'px';
        if (menusrhWidth < 140) {
            document.getElementById('menu-search').setAttribute('placeholder', 'Search~');
        }
        <?php endif; ?>

        if (window.location.hash != '') {
            const i = window.location.hash.indexOf('#comment');
            const ii = window.location.hash.indexOf('#respond-post');
            if (i != '-1' || ii != '-1') {
                document.getElementById('btn-comments').innerText = 'hide comments';
                document.getElementById('comments').style.maxHeight = 2000 + 'px';
            }
        }
        // go-top

        let goTop = document.getElementById('go-top');
        // // 判断是否点击
        // let flag = 0;
        // alert(totalHeight);
        // 获取正在显示的长度
        let showHeight = window.innerHeight;
        let container = document.querySelector('html');
        // 判断滚动条高度需要添加 overflow: auto 属性
        window.onscroll = function () {
            if (container.scrollTop > showHeight) {
                goTop.style.transform = 'scale(1)';
            } else if (container.scrollTop <= showHeight) {
                goTop.removeAttribute('style');
            }
            /*
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

                        };*/
        };


        // 窗口改变时
        window.onresize = function () {
            showHeight = window.innerHeight;
        };

        // document.getElementById('go-top').onclick = function (e) {
        //     document.getElementById('header').scrollIntoView({
        //         behavior: "smooth"
        //     })
        document.getElementById('go-top').onclick = function (e) {
            scrollSmoothTo(0);
            e.preventDefault()
        };

        // 标题锚点平滑
        if (document.querySelector('#torTree > div > div')) {
            const torArr = document.querySelectorAll('#torTree > div > div > a');

            function getElementTop(element) {
                let actualTop = element.offsetTop;
                let current = element.offsetParent;

                while (current !== null) {
                    actualTop += current.offsetTop;
                    current = current.offsetParent;
                }

                return actualTop;
            }

            for (let i = 0; i < torArr.length; i++) {
                torArr[i].onclick = function (e) {
                    const Top = getElementTop(document.getElementById(`${this.getAttribute('href').replace(/^#/, '')}`)) - 10;
                    /*const timer = setInterval(
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
                        , 10);*/
                    scrollSmoothTo(Top);

                    e.preventDefault();
                };
            }
        }

        /*// 绑定事件 点击导航后淡出
        var menu = document.querySelectorAll('#menu-page > a');

        for (var i = 0; i < menu.length; i++) {
            menu[i].onclick = function () {
                isMenu1();
                console.log(menu);
            }
        }*/

        // 委派事件 点击导航后淡出

        const menu = document.querySelector('#menu-page');
        menu.addEventListener("click", function (e) {
            const target = e.target;

            if (target.nodeName.toLocaleLowerCase() === 'li') {
                isMenu1();
            }
        })
    }


    const scrollSmoothTo = function (position) {
        if (!window.requestAnimationFrame) {
            window.requestAnimationFrame = function (callback, element) {
                return setTimeout(callback, 17);
            };
        }
        // 当前滚动高度
        let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        // 滚动step方法
        const step = function () {
            // 距离目标滚动距离
            let distance = position - scrollTop;
            // 目标滚动位置
            scrollTop = scrollTop + distance / 5;
            if (Math.abs(distance) < 1) {
                window.scrollTo(0, position);
            } else {
                window.scrollTo(0, scrollTop);
                requestAnimationFrame(step);
            }
        };
        step();
    };


    function isMenu() {
        document.getElementById('menu-page').style.cssText = 'display: block;';
        const menuList = document.querySelectorAll('#menu-page li');
        for (let i of menuList) {
            i.style.display = 'none'
        }

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
        //
        // if (document.getElementById('menu-page').style.display == 'block') {
        //     $('#menu-page').fadeOut(300);
        //
        // } else {
        // $('#menu-page').fadeIn(300);


        const menuPage = $('#menu-page li');
        if (menuPage[0].style.display === 'none') {
            let i = 1;
            for (let menu of menuPage) {
                setTimeout(function () {
                    $(menu).fadeIn(300);
                }, 100 * i);
                i++;
            }
        } else {
            let i = menuPage.length;
            for (let menu of menuPage) {
                setTimeout(function () {
                    $(menu).fadeOut(300);
                }, 100 * i);
                i--;
            }
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

                const message = document.createElement('div');
                message.innerHTML = `人家是导航树哦！只有在特定的文章页面才会出现哦...`;
                message.style.cssText = `
                position: fixed;
                display: flex;
                justify-content: center;
                align-items: center;
                top: 3em;
                left: 0;
                right: 0;
                margin: 0 auto;
                border-radius: 24px;
                background-color: #f1c40f;
                width: 450px;
                height: 53px;
                box-shadow: 0 3px 15px 10px rgba(87,87,87,.2), 0 1px 3px -6px rgba(87,87,87,.2) inset;
                `.trim();
                message.classList.add('fade-in');
                document.body.appendChild(message);
                setTimeout(function () {
                    message.classList.replace('fade-in', 'fade-out');
                    setTimeout(function () {
                        message.remove();
                    }, 450);
                }, 2000)
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

    // 点击其他区域关闭菜单
    $(document).click(function (e) {
        const pop = $('#menu-page > a > li');
        if (!pop.is(e.target) && pop.has(e.target).length === 0 && !$(e.target).is($('#menu-1')) && !$(e.target).is($('#menu-1 > i'))) {
            const menuPage = $('#menu-page li');
            let i = menuPage.length;
            for (let menu of menuPage) {
                setTimeout(function () {
                    $(menu).fadeOut(300);
                }, 100 * i);
                i--;
            }
        }
    })


    // 评论区过度

    function isComments() {
        if (document.getElementById('btn-comments').innerText == 'show comments') {
            document.getElementById('btn-comments').innerText = 'hide comments';
            document.getElementById('comments').style.maxHeight = 1500 + 'px';

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
        let contentHeight = document.body.scrollHeight,
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

    new Pjax({
        selectors: [
            "title",
            "meta[name=description]",
            "#pjax",
            "[pjax]",
            ".hitokoto"
        ],
        cacheBust: false,

    });
    document.addEventListener('pjax:complete', loadAtfer);
    document.addEventListener("DOMContentLoaded", loadAtfer);

</script>

<script pjax>

    <?php if ($this->is('post')): ?>
    <?php $postConfig = parse_title($this->content);?>
    <?php if ($postConfig): ?>
    isMenu2('auto');
    <?php endif; ?>
    <?php endif; ?>
    <?php if($this->is('post') || $this->is('page') ):?>
    (function () {
        if (/Safari/.test(navigator.userAgent) && !/Chrome/.test(navigator.userAgent)) {
            document.querySelector('#main > article').style.WebkitFontSmoothing = 'antialiased';
        }
    })();
    if ($('#main > article')) {
        $(document).ready(function () {
            var article = $('#main > article');
            article.removeClass('hidden');
            article.toggleClass('fadeInUp animated');
            article.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function (e) {
                $(e.target).removeClass('fadeInUp animated');

            });

        });
    }
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

<div id="go-top">
    <i class="fas fa-arrow-up" style="
    position: absolute;
    bottom: 28%;
    left: 30%;
    color: white;
    display: block;
    text-align: center;
    font-size: 20px;
"></i>
</div>
<?php $this->footer(); ?>
</body>
</html>
