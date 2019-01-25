/**
 * This is js file for order UI 
 *
 * @author Saswati
 *
 * @category Js file
 */

$(document).ready(function () {

	$(".cust li a").click(function(){
	  	$(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
	  	$(this).parents(".dropdown").find('.btn').val($(this).data('value'));
	  	var value = $(this).attr('id');
	  	var name = $(this).text();
	  	customer = {
			name: name,
			value: value,
		};
	});
});