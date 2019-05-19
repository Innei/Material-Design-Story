<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 语录页面
 *
 * @package custom
 */
$this->need('header.php');
?>

    <div id="pjax" class="container-fluid">
        <main id="say">
            <article class="say" itemscope itemtype="http://schema.org/BlogPosting">
                <?php

                $content = $this->content;

                preg_match_all('/<p>(.*?)<\/p>/', $content, $says);

                $says_number = count($says['1']);

                $i = 0;
                if ($this->fields) {
                    foreach ($this->fields as $key => $value) {
                        if ($i < $says_number) {
                            echo '<say><p>' . $says['1'][(string)$i] . '</p><p class="author"> ' . $value . '</p></say>';
                            $i++;
                        }
                    }

                }

                ?>

            </article>
        </main>
    </div>


<?php $this->need('footer.php'); ?>