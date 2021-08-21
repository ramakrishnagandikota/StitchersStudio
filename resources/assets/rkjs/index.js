/*!
 * rSelect version 1.0
 * Author: Rama krishna
 *	Plugin Name : rSelect
 * Released under the MIT license
 * Released date : 25th Aug 2020
 */
 (function( $ ) {
 
    $.fn.rSelect = function(options) {
		
		// Tag # represents only one element initiliazed, tag .(dot) represents multiple elements initiliazed.
		if(options.id){
			var tag = '#';
			var el = options.id
		}else{
			var tag = '.';
			var el = options.class
		}
		
		if(options.placeholder){
			var ph = options.placeholder;
		}else{
			var ph = 'Select a value';
		}
		
		if(options.min){
			var minNum = options.min;
		}else{
			var minNum = 0;
		}
		
		if(options.errorMsg){
			var errorMessage = options.errorMsg;
		}else{
			var errorMessage = 'You have entered wrong input.';
		}
		
		if(options.allow == 'numbers'){
			var allow = 'number';
		}else{
			var allow = '';
		}
		
		var first_value,last_value;
		
		
		$(tag+''+el).each(function(i){
			var $this = $(this);
			$(this).hide();
			var name = $(this).attr('name');
			var sid = $(this).attr('id');
			var cls = $(this).attr('class');
			var value = $(this).children("option:selected").val();
			
			var input = '<input type="text" class="'+cls+' myselect '+allow+'" placeholder="'+ph+'" data-id="'+i+'" id="myselect'+i+'" data-search value="'+value+'" />\
			<span style="color:red;" id="error'+i+'"></span>\
			<div id="results'+i+'" class="results" style="display:none;"></div>';
			$(this).parent('div').append(input);
			
			var len = $this.find('option').length;
			var allValues = new Array;
			var opt = '<ul class="list-group">';
			$this.find('option').each(function(j){
				
				allValues.push($(this).val());
				
				if (j === 0) {
				  first_value = $(this).val();
				}
				
				if (j === (len - 1)) {
				  last_value = $(this).val();
				}
				
				//console.log('first',$(this).first().val());
				//console.log('last',$(this).last().val());
			
			
				var link = $( this );
			opt+='<li class="list-group-item" data-filter-item data-filter-name="'+link.val()+'"><a href="javascript:;" data-sid="'+sid+'" class="selectValue" data-value="'+link.val()+'" data-id="'+i+'" >'+link.val()+'</li>';
			});
			opt+= '</ul>';
			$('#results'+i).html(opt);
			
			$("#myselect"+i).keyup(function(){
				$("#results"+i).show();
				var id = $(this).attr('data-id');
				var searchVal = $(this).val();
				var filterItems = $('#results'+id+' [data-filter-item]');
				
				var keycode = (window.event) ? event.keyCode : e.keyCode;
					if (keycode == 13){
						$(".results").hide();
					}

				if ( searchVal != '' ) {
					filterItems.addClass('hidden');
					$('#results'+id+' [data-filter-item][data-filter-name^="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
					
					
					
					if(jQuery.inArray(searchVal,allValues) !== -1){
						$("#error"+i).html('');
						$('#myselect'+i).removeClass('error').addClass('success');
						$("#"+sid).val(searchVal);
					}else{
						$('#myselect'+i).removeClass('success').addClass('error');
						$("#error"+i).html(errorMessage);
						$("#results"+i).hide();
					}

				} else {
					filterItems.removeClass('hidden');
					$("#results"+id).hide();
					$('#myselect'+i).removeClass('error').addClass('success');
					$("#error"+id).html('');
				}
				
				if($("#results"+id+" li").not( document.getElementsByClassName( "hidden" ) ).length == 0){
					$("#results"+id).hide();
					$('#myselect'+id).removeClass('success').addClass('error');
					$("#error"+id).html(errorMessage);
				}
				
				//PresTab(i);
			});
			
			/*$("#myselect"+i).keydown(function(){
				var idd = i;
				var keycode = (window.event) ? event.keyCode : e.keyCode;
					if (keycode == 9){
						$('#myselect'+idd).focus();
					}
			}); */
			
			
			$(document).on('click','.selectValue',function(){
				
				var id = $(this).attr('data-id');
				var sid = $(this).attr('data-sid');
				var data = $(this).attr('data-value');
				
				sendDataonClick(id,sid,data,i,allValues,errorMessage)
			});
			
			
		});
		
			$('body').click(function(){
				$(".results").hide();
			});
			
			$('.myselect').on('keyup', function() {
				var id = $(this).attr('data-id');
				//$("#results"+id).show();
				var searchVal = $(this).val();
				var filterItems = $('#results'+id+' [data-filter-item]');
				
				if ( searchVal != '' ) {
					filterItems.addClass('hidden');
					$('#results'+id+' [data-filter-item][data-filter-name^="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
				} else {
					filterItems.removeClass('hidden');
					$("#results"+id).hide();
				}
				
				if($("#results"+id+" li").not( document.getElementsByClassName( "hidden" ) ).length == 0){
					$("#results"+id).hide();
				}
			});
			
			$('.number').keypress(function(event) {
			  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			  }
			});
 
        return this;
    };
 
}( jQuery ));


document.addEventListener('keydown',function(event){
	
	var keycode = (window.event) ? event.keyCode : e.keyCode;
	if (keycode == 9){
		$(".results").hide();
	}
	
	if (keycode == 13){
		$(".results").hide();
	}
});

function sendDataonClick(id,sid,data,i,allValues,errorMessage){
	$("#myselect"+id).val(data);
	$("#results"+id).hide();
	$("#"+sid).val(data);
	
	if(data){
		//console.log(data,allValues);
		if(jQuery.inArray(data,allValues) !== -1){
			$("#error"+id).html('');
			$('#myselect'+id).removeClass('error').addClass('success');
		}else{
			//console.log('You have entered wrong number.');
			$('#myselect'+id).removeClass('success').addClass('error');
			$("#error"+id).html(errorMessage);
			return;
		}
	}
}

/*
function PresTab(id,e)
{
   var keycode = (window.event) ? event.keyCode : e.keyCode;
   if (keycode == 9){
	   var idd = id + 1;
	   //$('#myselect'+idd).focus();
	$("#results"+id).hide();
   }
   //alert('tab key pressed');
}*/