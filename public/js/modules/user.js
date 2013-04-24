/*
* TODO
*	Function to remove items from the bucket
*	Function to delete buckets
*	Friends list refreshed on bucket change
*	Friends list hidde friends on bucket open with friends
*/

var user = {

	/*
	* user.friends_list()
	* function to retrieve the list and initialize the drag&drop
	*/
	friends_list : function() {

		// Retrieve the actual friend list
		$.get(base_url+'ajax/user/friends_list', function(data) {
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

		    // let the friends-list items be draggable
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

		    // funtion to sort friends list
			var $friends = $('#friends-list li');
			$('#friend-search').keyup(function() {
				var re = new RegExp($(this).val(), "i"); // "i" means it's case-insensitive
				$friends.show().filter(function() {
					return !re.test($(this).text());
				}).hide();
			});

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

	/*
	* user.buckets_list()
	* function to retrieve the bucket and open them
	*/
	buckets_list : function() {
		$.get(base_url+'ajax/bucket/list/'+uid, function(data) {

			// Create the array with the buckets, and insert it the DOM
			var list = [];
			$(data).each(function(i, v) {
				list.push('<h2 id="open-bucket"> <a href="#" data-id="'+v['id']+'"> '+v['name']+' <i class="icon-th"></i> </a> </h2>');
			});
			$('#list-buckets').html(list);

			// Bucket name clicked, open it
			$('#open-bucket > a').click(function(e) {

				e.preventDefault();

				var bucket_title = $(this).text();
				var bucket_id = $(this).data('id');

				// Insert the markup related to the bucket
				$('#user-bucket').html(
					'<div id="bucket-title" class="row-fluid">'+
						'<h2 class="pull-left"> Bucket: '+bucket_title+'</h2>'+
						//'<h2 class="pull-right"> No friends added </h2>'+
					'</div>'+
					'<ul id="bucket-friends" class="row-fluid" data-id="'+bucket_id+'" style="height:90%; margin:0;"></ul>'
				);

				// Retrieve bucket contents
				$.get(base_url+'ajax/bucket/index/'+bucket_id, function(data) {
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
						});
					}

					// let the trash be droppable, accepting the friends-list items
				    $('#bucket-friends').droppable({
						accept: "#friends-list > li",
						activeClass: "ui-state-highlight",
						drop: function(event, ui) {
							$.ajax({
								url: base_url+'ajax/bucket/index',
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

	var header_height = $('.navbar').height();
	var container_height = $('#master').css('marginTop').replace('px', '')*2;

	//$('#friends-list').css({'max-height': $(window).height() - header_height - container_height - $('.form-friends > .form-horizontal').height()});
	$('#user-bucket').height($(window).height() - header_height - container_height - 40);
	//$('#menu-buckets').height($(window).height() - header_height - container_height);

    $('#create-bucket > a').click(function(e) {
    	e.preventDefault();

    	$('#bucket-form').modal(options);
    });

	$('#create-bucket-button').click(function(e) {
		e.preventDefault();

		$.post(base_url+'ajax/bucket/index', {'id' : uid, 'name' : $('input[name="bucket-name"]').val()}, function(data) {
			if(data)
			{
				user.buckets_list();
				$('#close-form-button').click();
			}
		});
	});
});