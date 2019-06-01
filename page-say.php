<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 语录页面
 *
 * @package custom
 */
$this->need('header.php');
?>

<div id="pjax" class="container-fluid" style="margin-top: 3rem;">
    <main id="say">
        <article class="say" itemscope itemtype="http://schema.org/BlogPosting">
            <?php

            $content = $this->content;
            // 匹配每行 放入数组

            preg_match_all('/<p>(.*?)<\/p>/', $content, $says);

            $content = array();
            foreach ($says['1'] as $key => $say) {
                $content[] = preg_split('/(----|---|--|————|——)/', $say);  /*匹配提取----|---|--|————|——后的内容*/

            }
            $author_names = array();
            $say_bodys = array();
            foreach ($content as $key => $value) {
                if (count($value) != 1) {
                    $author_names[] = '————' . array_pop($value);   // 分割后数量如果为1 说明作者提取失败
                } else {
                    $author_names[] = '';  // 失败情况加入处理
                }

                $say_bodys[] = implode("——", $value);  // 合并多余的分割项
            }

            foreach ($say_bodys as $key => $say) {
                echo '<say><p>' . $say . '</p><p class="author"> ' . $author_names[$key] . '</p></say>';
            }

            /*            $says_content_number = count($says['1']);
                        $says_author_number = 0;
            
            
                        // 提取每行 ---或—— 后的内容
                        $author_names = array();
                        foreach ($says['1'] as $key => $say) {
                                $author_names[] = explode("---",$say);
            
                        }
            
            
                        // 记录当前处理
                        $i = 0;
                        if ($this->fields) {
                            foreach ($this->fields as $key => $value) {
                                if ($i < $says_content_number) {
                                    echo '<say><p>' . $says['1'][(string)$i] . '</p><p class="author"> ' . $value . '</p></say>';
                                    $says_author_number++;
                                    $i++;
                                }
                            }
            
                            // 作者数量不匹配的情况处理
                            for (; $says_content_number > $says_author_number && $i < $says_content_number; $i++) {
                                echo '<say><p>' . $says['1'][(string)$i] . '</p></say>';
                            }
                        }*/

            ?>

        </article>
    </main>
    <script>


        var says = document.querySelectorAll('say');
        (function () {
            for (let say of says) {

                toggleClass(say, 'swing animated');


                once(say, 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {

                    removeClass(say, 'swing animated');

                });

            }
        })();

        function once(dom, event, callback) {
            const handle = function () {
                callback();
                dom.removeEventListener(event, handle);
            };
            dom.addEventListener(event, handle)
        }

        function hasClass(obj, cls) {
            return obj.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
        }

        function addClass(obj, cls) {
            if (!this.hasClass(obj, cls)) obj.className += " " + cls;
        }

        function removeClass(obj, cls) {
            if (hasClass(obj, cls)) {
                let reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
                obj.className = obj.className.replace(reg, ' ');
            }
        }

        function toggleClass(obj, cls) {
            if (hasClass(obj, cls)) {
                removeClass(obj, cls);
            } else {
                addClass(obj, cls);
            }
        }

        (function () {
            if (/Safari/.test(navigator.userAgent) && !/Chrome/.test(navigator.userAgent)) {

                for (let i of document.querySelectorAll('#say > article > say > p:nth-child(1)')) {
                    i.style.WebkitFontSmoothing = 'antialiased';
                }
                for (let i of document.querySelectorAll('say')) {
                    i.style.boxShadow = 'none';
                }
            }
        })();

    </script>
</div>


<?php $this->need('footer.php'); ?>
