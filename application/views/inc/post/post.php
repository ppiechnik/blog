<div id="content" class="span-17 colborder">
	<div class="post">
		<?php foreach($post as $p): ?>
			<?php $p->tag->get(); ?>
			<h2><?php echo $p->title; ?></h2>

			<p><div class="posted-date"><?php echo $p->created; ?></div>

			<div class="tags">
				Tags:
				<?php foreach($p->tag->all as $t): ?>
					<?php echo anchor('index/tag' . $t->name, $t->name); ?>
				<?php endforeach; ?>
			</div></p>

			<?php echo $p->content; ?>
		<?php endforeach; ?>
	</div>
</div>
