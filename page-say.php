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

                $says_content_number = count($says['1']);
                $says_author_number = 0;

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
                }

                ?>

            </article>
        </main>
        <script>


            var says = document.querySelectorAll('say');
            (function(){
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
            //document.addEventListener("pjax:complete", window.onload);

        </script>
    </div>


<?php $this->need('footer.php'); ?>
