<section id="user-index" class="row-fluid">

	<div id="user-sidebar" class="span2">
		<div class="img-circle pull-left">
			<?=Image::rounded("https://graph.facebook.com/$username/picture?type=normal");?>
		</div>
		<div class="text-right">
			<p> <?=$first_name;?> <?=$last_name;?> </p>
			<p> <?=$location['name'];?> </p>
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
		<div>
			<?php print_r($friends); ?>
		</div>
	</div>

	<div id="user-buckets" class="span2">
		<p>test</p>
	</div>
	
</div>