<div id="content" class="span-17 colborder <?php echo $fixedHeight; ?>">
	<div class="post">        
		<?php $count = 0; ?>

		<?php foreach($posts->row as $post): ?>
			<h2><?php echo $post->title; ?></h2>

			<p>
				<div class="posted-date"><?php echo $post->created; ?></div>

				<div class="tags">
					Tags:
					<?php foreach($post->tag->get() as $tag): ?>
						<?php echo anchor('index/tag/' . $tag->name, $tag->name); ?>
					<?php endforeach; ?>
				</div>
			</p>

			<?php echo word_limiter($post->content); ?>

			<p class="anchor-post-more">
				<?php echo anchor('index/post/' . $post->id, 'Więcej'); ?>
			</p>

			<?php ++$count; echo $count != $posts->toDisplay ? '<hr />' : ''; ?>
		<?php endforeach; ?>

		<?php if ($posts->count > $posts->toDisplay): ?>
			<?php echo $this->pagination->create_links(); ?>
		<?php endif; ?>
	</div>
</div>
