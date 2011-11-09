<div id="sidebar" class="span-6 last">
	<div id="service">
		<a href="#"><img src="<?php echo base_url(); ?>img/rss.small.png" alt="rss" /> Feed</a>
	</div>

	<div id="search">
		<form action="" method="post" accept-charset="utf-8">
			<p><label for="search">Szukaj</label><input name="search" id="search" /></p>

			<p><input type="submit" value="Szukaj" /></p>
		</form>
	</div>

	<div id="tags">
		<h3>Tags</h3>

		<ul>
			<?php foreach($tags as $tag): ?>
				<li>
					<?php echo anchor('index/tag/' . $tag, str_replace('-', ' ', $tag)); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<div id="post-by-month">
		<h3>Post by month</h3>

		<ul>
			<?php foreach($month as $m): ?>
				<li>
					<?php
					$month_pieces = explode('-', $m);
					echo anchor(
								'index/year/' . str_replace('-', '/', $m),
								$month_pieces[0] . ' ' . translate_month($month_pieces[1])
								);
					?>
				
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<hr />
