<section id="user-index" class="row-fluid">

	<div id="user-sidebar" class="span2">
		<div class="pull-left">
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

		<h2 id="create-bucket">
			<a href="#bucket-form" role="button" data-toggle="modal"> Create Bucket <i class="icon-plus"></i> </a>
		</h2>
	</div>
	
</div>

<div id="bucket-form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Enter your new bucket's name</h3>
	</div>
	<div class="modal-body">
		<?=Form::horizontal_open();?>
		<?=Form::text('bucket-name', null, array('class'=>'input-block-level', 'placeholder'=>'Co-Workers'));?>
		<?=Form::close();?>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true" id="close-form-button">Close</button>
		<button class="btn btn-primary" id="create-bucket-button">Create</button>
	</div>
</div>

<script>
	var uid = <?=$uid;?>;
</script>