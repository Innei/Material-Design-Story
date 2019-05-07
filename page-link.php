<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 友链页面
 *
 * @package custom
 */
$this->need('header.php');
require_once 'functions.php';
?>
    <div id="pjax" class="container-fluid">
        <div class="row">
            <div id="main" class="col-12 clearfix" role="main">
                <article class="posti" itemscope itemtype="http://schema.org/BlogPosting">
                    <h1 style="text-align: right;">Links</h1>
                    <?php if ($this->options->self_link != null): ?>
                        <div class="self-link">
                            <h4>与我相关</h4>
                            <ul class="a_tag">
                                <?php parse_Flink($this->options->self_link); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->options->link != null): ?>
                        <div class="friends">
                            <h4>朋友们</h4>
                            <ul class="a_tag">
                                <?php parse_Flink($this->options->link); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </div>

<?php $this->need('footer.php'); ?>