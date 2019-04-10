<?php
/**
 * 这是一个未完成的二次开发主题
 * 
 * @package Card Design
 * @author Trii Hsia && yiny
 * @version y1.0@#1903
 * @link https://yumoe.com
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
?>

<div class="container-fluid">
    <div class="row">
		<div id="main" role="main">
			<ul class="post-list clearfix">
			<?php while($this->next()): ?>
				<li class="post-item grid-item" itemscope itemtype="http://schema.org/BlogPosting">
					<a class="colorgradient-card hidden" href="<?php $this->permalink() ?>">
						<h3 class="post-title"><time class="index-time" datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('M j, Y'); ?></time><br><span><?php $this->title() ?></span></h3>
						<?php if($this->options->showDec == 'on'):?>
						<br><p class="post-dec"><?php $this->excerpt(75, '...');?></p>
						<?php endif;?>
						<?php if($this->category): ?>
						<div class="post-meta">
							<?php echo $this->category; ?>
						</div>
						<?php endif; ?>
					</a>
				</li>
			<?php endwhile; ?>
			</ul>
		</div>
	</div>
</div>

<div class="container-fluid">
    <div class="row">
		<div class="nav-page">
			<?php $this->pageNav('&laquo;', '&raquo;'); ?>
		</div>
	</div>
</div>

<?php $this->need('footer.php'); ?>
