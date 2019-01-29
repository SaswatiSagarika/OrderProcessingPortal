/**
 * This is js file for product UI 
 *
 * @author Saswati
 *
 * @category Js file
 */


 var indexModule = (function () {
	/**
	* function to create table records for products
	*
	* var products
	*
	*return body
	*/
	var createTableRecordsForProducts = function (products) {
		var body = '';
		$('#mytablebody').empty();
		$.each(products, function(key, product){

			body += 
			'<tr>'+
			'<td>' + product.sku + '</td>'+
			'<td>' + product.name + '</td>'+
			'<td>'+
			'<input type="text" name="quantity_'+product.sku+'"  value="'+product.quantity +'" class="qty_'+product.sku+'" style="text-align:center;width:30px;height:34px;border:none;"/>'+
			'</td>'+
			'<td>$' + product.total + '.00</td>'+
			'<td><p id="' + product.sku + '" class="remove-product">X</p></td>'+
			'</tr>';
			
		});
		
		$("#mytablebody").html(body);
		return body;
	};

    /**
	* function to  products Array
	*
	* var sku
	*
	*return product
	*/
	var createProductsArray = function (sku) {

		var name = $(".product_name_"+sku).val();
		var price = $('.product_price_'+sku).val();
		var id = $('.product_id_'+sku).val();
		var qty = $('.qty_'+sku).val();
		var total = price* qty;
		if (parseInt(qty) !== 0) {
			var product = {
				sku: sku,
				id: id,
				name: name,
				quantity: qty,
				price: price, 
				total: total
			};
		} else {
			product = '<strong>Warning! Yo, you are trying to add '+
			qty+' quantity of '+
			name+' product. Please add quanttity more that 0 to add the product to the cart</strong>';
		}
		return product;
	};

    /**
	* function to create the json from the form data passed from the place order
	*
	* var products
	* var customer
	*
	* return body
	*/
	var createArrayFromRecords = function (products, customer) {
		var lines = [];
		var total = 0;
		$.each(products, function(key, product){

			var line = {
				Amount: product.total,
				DetailType: "SalesItemLineDetail",
				SalesItemLineDetail: {
					ItemRef:{
						value: product.id,
						name: product.name  
					},
					UnitPrice: product.price,
					Qty:product.quantity
				}
			};
			total +=product.total;
			lines.push(line);
		});
		var orderData = {
			
			TotalAmt: total,
			Line: lines,
			CustomerRef: {
				value: customer.value,
				name: customer.name  
			}			
		};
		
		var formData = JSON.stringify(orderData );
		return formData;
	};

    /**
	* function to increase the qty and price if the product is already present in the cart
	*
	* var products
	* var product
	*
	* return body
	*/
	var searchProductDuplicate = function (products, product) {

		var isAdded = false;
		$.each(products, function(key, value){

			if (value.sku == product.sku) {

				value.quantity = parseInt(product.quantity) + parseInt(value.quantity);
				value.total = value.quantity * value.price;
				isAdded = true;
			}
		});
		return isAdded;
	};
    /**
	* function to remove the clicked row
	*
	* var products
	* var sku
	*
	* return products
	*/
	var removeTableRecordsForProducts = function (products, sku) {

		$.each(products, function(key, value){
			if (sku == value.sku) {
				products.splice(key, 1);
			}
		});
		return products;
	};

    /**
	* function to show alert message as per type
	*
	* var message
	* var type
	* var place
	*
	* return message
	*/
	var alertMessage = function (message, type, place) {
		var body;
		switch (type) { 
			case 'success': 
			body = '<div class="alert alert-'+type+' alert-dismissible" role="alert">'
			break;
			case 'warning': 
			body = '<div class="alert alert-'+type+' alert-dismissible" role="alert">'
			break;
			case 'error': 
			body = '<div class="alert alert-'+type+' alert-dismissible" role="alert">'
			break;
			default:
			body = '<div class="alert alert-'+type+' alert-dismissible" role="alert">'
		}

		body += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
			'<span aria-hidden="true">&times;</span></button>'+
			message+
			'</div>';
		if (place === 'modal'){
			$("#modal-message").append(body);
		} else {
			$("#message").append(body);
		}


		$(".alert").first().hide().fadeIn(200).delay(2000).fadeOut(1000, function () { $(this).remove(); });
	}


	return {
		createTableRecordsForProducts,
		searchProductDuplicate,
		removeTableRecordsForProducts,
		createArrayFromRecords,
		createProductsArray,
		alertMessage
	}
})();

$(document).ready(function () {
	$('.add-to-cart').attr('disabled',true);

	var products = [];
	var customer;
	/**
	* function to add products to cart 
	* 
	*/
	$('.add-to-cart').on('click', function(event) {
		
		var productCode = $(this).attr('id');
		var product = indexModule.createProductsArray(productCode);
		//check if object is retruned or not
		if (typeof(product) === 'object'){

			//serached for duplicate
			var data = indexModule.searchProductDuplicate(products, product);
			if(data == false) {
				products.push(product);
			}
			//add new record
			indexModule.createTableRecordsForProducts(products);
			var message = '<strong>'+product.name+' successfully added to cart</strong>';
			indexModule.alertMessage(message, 'success');
		} else {
			indexModule.alertMessage(product, 'error');
		}

	});
	/**
	* function to show and remove the rows to the cart modal
	*/
	$('#cart').on('click', function(event) {
		//check if cart is empty or not
		if(products.length === 0) {
			// var message = "<h4>Humph!!! Cart is Empty.</h4>";
			// indexModule.alertMessage(message, 'warning');
			$('#mytablebody').html('<div style="text-align:center;"><h3>Cart is empty.</h3><button class="btn btn-warning">Continue Shopping</button></div>');
		}

		//open the modal
		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false
		});

		//remove the row
		$('.remove-product').on('click', function(event) {
			$(this).parent().parent().remove();
			var sku = $(this).attr('id');
			products = indexModule.removeTableRecordsForProducts(products, sku);
			// indexModule.createTableRecordsForProducts(products);
		});
		//show dropdown value
		$(".dropdown-menu li a").click(function(){
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
	/**
	* function to increment the value
	*/
	$('.qtyplus').click(function(e){
        // Stop acting like a button
        e.preventDefault();

        // Get the field name
        var fieldName = $(this).attr('field');
        //get the button id
        var id = fieldName.substr(fieldName.indexOf("_") + 1);
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());

        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
            $('button[id='+id+']').attr('disabled',false);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
            console.log(id);
            $('button[id='+id+']').attr('disabled',true);
        }
    });

	/**
	* function to decrement the value
	*/
	$(".qtyminus").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var fieldName = $(this).attr('field');
        //get the button id
        var id = fieldName.substr(fieldName.indexOf("_") + 1);
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
            $('button[id='+id+']').attr('disabled',false);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
            $('button[id='+id+']').attr('disabled', true);
        }

    });

	/**
	* function to place order
	*/
	$(".place-order").click(function(){	

		if(!customer){
			var message = '<strong>Please select the consumer for whom you are placing this order.</strong>';
			indexModule.alertMessage(message, 'error','modal');
			return;
		}
		var formData = indexModule.createArrayFromRecords(products, customer);
		$.ajax({  	
			url:        "/api/order",  	
			type:       "POST",  	
			data: 		 formData,	
			dataType:   "json",
			contentType: "application/json; charset=utf-8",
			async:      true,	
			success: function(data) {  	
				console.log(data);
				indexModule.alertMessage(product, 'success');
			},  	
			error : function(xhr, textStatus, errorThrown) {  	
				console.log(errorThrown);
            }  	
        }); 		

	});  

});
