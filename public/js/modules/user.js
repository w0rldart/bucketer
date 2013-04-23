var user = {
	friends_list : function() {
		$.get('/ajax/user/friends_list', function(data) {
			$(data).each(function(i, v) {
				$('#friends-list').append(
					'<li data-fid="'+v['id']+'" data-name="'+v['name']+'">'+
						'<div class="pull-left">'+
							'<img src="https://graph.facebook.com/'+v['id']+'/picture?width=45&height=45" class="img-rounded" />'+
						'</div>'+
						'<div class="text-right"> <p> '+v['name']+' </p> </div>'+
					'</li>'
				);
			});

		    // let the gallery items be draggable
		    $('#friends-list li').draggable({
				//cancel: 'a.ui-icon', // clicking an icon won't initiate dragging
				revert: 'invalid', // when not dropped, the item will revert back to its initial position
				containment: 'document',
				appendTo: 'body',
				helper: 'clone',
				cursor: 'move',
				start: function( event, ui ) {
					if( ! $('#user-bucket > #bucket-friends').length > 0)
					{
						alert('Please select a bucket first.');
						// return false;
					}
					img_src = ui.helper.find('img').attr('src').replace('width=45', 'width=100').replace('height=45', 'height=100');
					ui.helper.addClass('bucket-item').css({'width': '100px', 'height': '170px'}).find('.text-right').toggleClass('text-right text-center').parent().find('img').attr('src', img_src);
				}
		    });

		    /*
		    * TODO
		    *	Add possibility to remove items from the bucket
		    */
		    // let the gallery be droppable as well, accepting items from the trash
			/*$gallery.droppable({
				accept: "#bucket-friends li",
				activeClass: "custom-state-active",
				drop: function( event, ui ) {
					recycleImage( ui.draggable );
				}
			});*/
		});
	},
	buckets_list : function() {
		$.get('/ajax/bucket/list/'+uid, function(data) {
			$(data).each(function(i, v) {
				$('#list-buckets').append('<h2 id="open-bucket"> <a href="#" data-id="'+v['id']+'"> '+v['name']+' <i class="icon-th"></i> </a> </h2>');
			});

			$('#open-bucket > a').click(function(e) {

				e.preventDefault();

				var bucket_title = $(this).text();
				var bucket_id = $(this).data('id');

				$('#user-bucket').html(
					'<div id="bucket-title" class="row-fluid">'+
						'<h2 class="pull-left"> Bucket: '+bucket_title+'</h2>'+
						//'<h2 class="pull-right"> No friends added </h2>'+
					'</div>'+
					'<ul id="bucket-friends" class="row-fluid" data-id="'+bucket_id+'" style="height:90%; margin:0;"></ul>'
				);

				$.get('/ajax/bucket/index/'+bucket_id, function(data) {
					if(data)
					{
						$(data['friends']).each(function(i, v) {
							$('#bucket-friends').append(
								'<li class="bucket-item">'+
									'<div>'+
										'<img src="https://graph.facebook.com/'+v['fb_id']+'/picture?width=100&height=100" class="img-rounded" />'+
									'</div>'+
									'<div class="text-center"> <p> '+v['name']+' </p> </div>'+
								'</li>'
							);
							//$('#user-bucket').append('<h2 id="open-bucket"> <a href="#" data-bucket="'+v['id']+'"> '+v['name']+' <i class="icon-th"></i> </a> </h2>');
						});
					}

					// let the trash be droppable, accepting the gallery items
				    $('#bucket-friends').droppable({
						accept: "#friends-list > li",
						activeClass: "ui-state-highlight",
						drop: function(event, ui) {
							$.ajax({
								url: '/ajax/bucket/index',
								type: 'PUT',
								data: { 'uid': uid, 'bucket': bucket_id, 'friend_id': ui.draggable.data('fid'), 'friend_name': ui.draggable.data('name') },
								success: function(data) {
									if(data)
									{
										img_src = ui.helper.find('img').attr('src').replace('width=45', 'width=100').replace('height=45', 'height=100');
										ui.draggable.addClass('bucket-item').find('.text-right').toggleClass('text-right text-center').parent().find('img').attr('src', img_src);
										ui.draggable.appendTo('#bucket-friends').fadeIn();
									}
								}
							});
						}
				    });
				});
			});
		});
	}
};

$(document).ready(function($) {
	$('#master').toggleClass('container container-fluid');

	user.friends_list();
	user.buckets_list();

	var $products = $('#friends-list li');
	$('#friend-search').keyup(function() {
		var re = new RegExp($(this).val(), "i"); // "i" means it's case-insensitive
		$products.show().filter(function() {
			return !re.test($(this).text());
		}).hide();
	});

	var header_height = $('.navbar').height();
	var container_height = $('#master').css('marginTop').replace('px', '')*2;

	//$('#friends-list').css({'max-height': $(window).height() - header_height - container_height - $('.form-friends > .form-horizontal').height()});
	$('#user-bucket').height($(window).height() - header_height - container_height - 40);
	$('#list-buckets').height($(window).height() - header_height - container_height);

    $('#create-bucket > a').click(function(e) {
    	e.preventDefault();

    	$('#bucket-form').modal(options);
    });

	$('#create-bucket-button').click(function(e) {
		e.preventDefault();

		$.post('/ajax/bucket/index', {'id' : uid, 'name' : $('input[name="bucket-name"]').val()}, function(data) {
			if(data !== null)
			{
				user.buckets_list();
				$('#close-form-button').click();
			}
		});
	});
});