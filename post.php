<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="container-fluid">
	<div class="row">
		<div id="main" class="col-12 clearfix" role="main">
			<article class="posti" itemscope itemtype="http://schema.org/BlogPosting">
				<h1 class="post-title" itemprop="name headline"><?php $this->title() ?></h1>
				<div class="post-meta">
					<p>Written by <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a>
					 <?php if($this->options->showCommentNum == 'on'): echo "with ".$this->commentsNum." comment(s) on"; else: ?>
					 	with ♥ on 
					 <?php endif; ?>
					 <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('F j, Y'); ?></time> in <?php $this->category(', ', true, 'none'); ?></p>
				</div>
				<?php if(time() - $this -> modified >= 2476800 && $this->options->modifiedDate == 'on'): ?>
					<div class="modified-date">
						<p>这篇文章上次修改于 <?php echo ceil((time() - $this -> modified) / 86400) ?> 天前，可能其部分内容已经发生变化，如有疑问可询问作者。</p>
					</div>
				<?php endif; ?>
				<div class="post-content" itemprop="articleBody">
					<?php parseContnet($this->content); ?>
				</div>
				<?php if($this->options->copyright == 'on'):?>
					<div>
						<ul class="post-copyright">
							<li>
								<strong>本文作者：</strong><?php $this->author(); ?>
							</li>
							<li>
								<strong>发布时间：</strong><?php $this->date('F j, Y'); ?>
							</li>
							<li>
								<strong>修改时间：</strong><?php echo date('F j, Y',$this->modified); ?>
							</li>
							<li>
								<strong>阅读次数：</strong> <?php get_post_view($this) ?>
							</li>
							<li>
								<strong>本文链接：</strong>
								<a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"><?php $this->permalink() ?></a>
							</li>
							<li>
								<strong>版权声明： </strong>
								本博客所有文章除特别声明外，均采用 <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/cn/" rel="external nofollow" target="_blank">CC BY-NC-SA 3.0 CN</a> 许可协议。转载请注明出处！
							</li>
						</ul>
					</div>
				<?php endif ;?>
				<div style="display:block;margin-bottom:2em;" class="clearfix">
					<section style="float:left;">
						<span itemprop="keywords" class="tags"><?php _e('tag(s): '); ?><?php $this->tags(', ', true, 'none'); ?></span>
					</section>
					<section style="float:right;">
						<span><a id="btn-comments" href="javascript:isComments();">show comments</a></span> · <span><a href="javascript:goBack();">back</a></span> · 
						<span><a href="<?php $this->options->siteUrl(); ?>">home</a></span>
					</section>
				</div>
				<?php $this->need('comments.php'); ?>
			</article>
		</div>
	</div>
</div>

<?php $this->need('footer.php'); ?>
