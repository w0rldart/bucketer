<section id="user-index" class="row-fluid">

	<div id="user-sidebar" class="span2">
		<div class="img-circle pull-left">
			<?=Image::rounded("https://graph.facebook.com/$username/picture?type=normal");?>
		</div>
		<div class="text-right">
			<p> <?=$first_name;?> <?=$last_name;?> </p>
			<p> <?=$location;?> </p>
		</div>

		<div class="clearfix"></div>

		<hr/>

		<div id="form-friends">
			<?=Form::horizontal_open();?>
			<?=Form::text('filter-names', null, array('id'=>'friend-search', 'class'=>'input-block-level', 'placeholder'=>'...filter your friends...'));?>
			<?=Form::close();?>

			<ul id="friends-list">
			<?php foreach ($friends as $friend): ?>
				<li>
					<div class="img-circle pull-left">
						<?=Image::rounded("https://graph.facebook.com/{$friend['id']}/picture?type=small");?>
					</div>
					<div class="text-right">
						<p> <?=$friend['name'];?> </p>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>

		</div>
	</div>

	<div id="user-bucket" class="span8">

	</div>

	<div id="list-buckets" class="span2">
		<h1>
			<i class="icon-th-large" style="font-size:37px;"></i>
		 	Buckets
		</h1>

		<hr/>

		<?php if($buckets): ?>
			<?php foreach ($buckets as $bucket): ?>
				<h2> <a href="#"><?=$bucket['name'];?></a> </h2>
			<?php endforeach; ?>
		<?php else: ?>
			<h2> <a href="#new"> Create Bucket </a> </h2>
		<?php endif; ?>

	</div>
	
</div>