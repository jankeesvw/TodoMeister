$(function() {
	$( ".sortable" ).sortable({
	 	placeholder: "sortablePlaceholder",
	   	connectWith: ".sortable",


	   	update: function(event, ui) {
			resizeColorBlocks();
		
			// update the time in the item
			ui.item.find("#time").html("(0 minutes ago)");
			
			$('.column').each(function(index) {


			var totalNumberTodos = $(this).find('li').length;
				$(this).find('.numberOfTodos').html(totalNumberTodos);
			});
		
			data = '';
			$('ul.sortable').each(function(index) {
			    data += '&column'+ (index+1) + '=' + $(this).sortable( "toArray" );
			});
		
			$.ajax({
				type: "POST",
				url: order_update_url,
				data: "item="+ui.item.attr('id') + data,
				success: function(html){
					$('body').addClass('dontReload');				
				}
			});
		}
	});
	$('.edit_button').click(function() {
		editElement($(this).parent().parent().parent());
	});
	
	// edit a todoitem when a user clicks the text
	$('.editable').dblclick(function() {
		editElement($(this));
	});
	
	function editElement(item){
		if(item.hasClass('editable')){
			item.removeClass('editable');
			id = item.attr('id');
			originaltext = item.find('.original').html();
			replacetext = '';
			replacetext += '<form method="post" action="'+text_update_url+'">';
			replacetext += '<textarea name="todo" type="text">'+originaltext+'</textarea>';
			replacetext += '<input name="id" type="hidden" value="'+id+'">';
			replacetext += '<input style="width: 100%;" type="submit" value="save" / >';
			replacetext += '</form>';
			item.children('p').html(replacetext);
			item.children('.actions').hide();
			item.children('.footer').hide();
			resizeColorBlocks();
		};
	}

	
	$.fn.colorPicker.defaultColors =  ['BE7CBA','6460AF','83AFDC','3A804A','E9EB4A','F4AE48','EB3D36','A8773E','000000','FF00FF','CCCCCC'];

	$('.color_picker').colorPicker();
	resizeColorBlocks();
	
	// handle color changes
	$('.color_picker').change(function() {
		var id =  $(this).attr('name');
		var color =  $(this).attr('value');
		
		$.ajax({
		   type: "POST",
		   url: color_update_url+'/'+id,
		   data: "color="+color,
		   success: function(html){
				$('body').addClass('dontReload');
			}
		 });
	});
	
	
	// the url can contain a # and a status number, this gives input to right field
	urlparts = window.location.href.split('#');
	urlparts.shift();
	if(urlparts.length > 0){
		selector = '.column.status'+urlparts[0]+' input:text.todo';
		$(selector).focus();
	}
});


