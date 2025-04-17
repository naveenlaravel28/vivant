$(document).ready(function() {
    var tz = jstz.determine();
    var timezone = tz.name();
    $.post(base_url+'ajax/set_timezone',{timezone:timezone},function(res){
        // console.log(res);
      });


    $( "#mobile_no" ).autocomplete({
        source: function( request, response ) {
            
            $.ajax({
                url: base_url+"ajax/search_mobile_no",
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('#mobile_no').val(ui.item.label); // display the selected text
            $('#customer_name').val(ui.item.customer_name);
            $('#customer_id').val(ui.item.customer_id);
            
            return false;
        }
    });


});
function delivery_time(val){
	$('.dt').removeClass('active');
	$('#delivery_time').val(val);
	$('#dt_'+val).addClass('active');
	
}

function search_product_group(id){
	$('.pg').removeClass('active');
	$('#product_group').val(id);
	$('#pg_'+id).addClass('active');
	get_products()
}

function search_product_type(id){
	$('.pt').removeClass('active');
	$('#product_type').val(id);
	$('#pt_'+id).addClass('active');
	get_products()
}
get_products();
function get_products(){

			var product_group=$('#product_group').val();
			var product_type=$('#product_type').val();

	       $.ajax({
                type:'POST',
                url:base_url+'user/billing/getProducts',
                data:{product_group:product_group,product_type:product_type},
                beforeSend:function(){
                    $('.load-more').show();
                },
                success:function(response){
                	var html='';
                    if (response) {
                        var obj = $.parseJSON(response);
                        $(obj.data).each(function () {
                            if(this.product_category=='2'){
                            var product_price_type='<i class="fas fa-wrench"></i>';
                            }else{
                                var product_price_type='<i class="fas fa-rupee-sign"></i>';
                            }

                        	html +='<div onclick="add_product('+this.id+')" class="col-md-2 col-sm-12 filter-item">'+
                                    '<div class="single-project-style5 custom-shadow">'+
                                        '<div class="img-holder">'+
                                                '<img src="'+this.product_image+'" class="img-fluid" alt="">'+
                                                '<span>'+product_price_type+' '+this.product_price+'</span>'+
                                        '</div>'+
                                        '<div class="title mt-2">'+
                                            '<h3>'+this.product_name+'</h3>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                        });

                       

                        $("#productList").html(html);

                    }
                }
            });

}

function add_product(id){
	$.post(base_url+'user/billing/addCart',{id:id},function(){
		get_cartItems();
	});
}
function get_cartItems(){
	$.ajax({
			type:'GET',
            url:base_url+'user/billing/get_cartItems',
            beforeSend:function(){
                
            },
            success:function(response){
            	var html='';
                if (response) {

                    var obj = $.parseJSON(response);
                    if(obj.data!=''){
                    $(obj.data).each(function () {

                    	if(this.product_category=='2'){
                    		var price_type='<input type="text" class="form-control" value="'+this.product_price+'" onblur="updateCartPrice(this, \''+this.product_rowid+'\')">';
                    	}else{
                    		var price_type=this.product_price;
                    	}

                        html +='<tr>'+
                                '<td scope="row">'+this.rowno+'</td>'+
                                '<td>'+
                                    '<div class="text-truncate">'+this.product_name+
                                    '</div>'+
                                 '</td>'+
                                '<td>'+
                                   '<div class="form-group custom-group">'+
                                      '<input type="text" value="'+this.product_description+'" class="form-control" onkeyup="updateCartdescription(this, \''+this.product_rowid+'\')" id="desc">'+
                                   '</div>'+
                                '</td>'+
                                '<td>'+'<div class="form-group custom-group">'+price_type+'</div>'+'</td>'+
                                '<td>'+
                                   '<div id="input_div" class="qty-style-wrapper d-flex align-items-center">'+
                                      '<input class="circle-style" type="button" value="-" id="moins" onClick="decrement_quantity(\''+this.product_rowid+'\')">'+
                                      '<input type="text" class="form-control" id="input-quantity-'+this.product_rowid+'" value="'+this.product_qty+'">'+
                                      '<input class="circle-style" type="button" value="+" id="plus" onClick="increment_quantity(\''+this.product_rowid+'\')">'+
                                   '</div>'+
                                   '<div id="notice" style="color:red;"></div>'+
                                '</td>'+
                                '<td>'+this.product_price*this.product_qty+'</td>'+
                                '<td><a href="javascript:void(0);" onclick="delete_cart(\''+this.product_rowid+'\')" class="btn btn-sm btn-white p-0 text-danger"><i class="far fa-trash-alt"></i></a></td>'+
                             '</tr>';
                                               
                    $("#cartList").html(html);

                });
                }else{
                    $("#cartList").html('');
                }

                $('.cart_total_amount').html(obj.total_amount);
                $('.cart_total_products').html(obj.total_products);
            }
        }
    });
}

function delete_cart(id)
    {
        if(confirm('Are you sure delete this product?'))
        {
            // ajax delete data to database
            $.ajax({
                url : base_url+"user/billing/delete_cart/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    get_cartItems()
                },
                error:function(){
                    get_cartItems()
                 }
            });

        }
    }

    function increment_quantity(cart_id) {
	  var inputQuantityElement = $("#input-quantity-"+cart_id);
	  var newQuantity = parseInt($(inputQuantityElement).val())+1;
	  updateCartItem(cart_id, newQuantity);
	}

	function decrement_quantity(cart_id) {
	    var inputQuantityElement = $("#input-quantity-"+cart_id);
	    if($(inputQuantityElement).val() > 1) 
	    {
	    var newQuantity = parseInt($(inputQuantityElement).val()) - 1;
	    updateCartItem(cart_id, newQuantity);
	    }
	}


function updateCartItem(rowid, qty){
	$.get(base_url+'user/billing/updateItemQty', {rowid:rowid, qty:qty}, function(resp){
	    if(resp == 'ok'){
	        get_cartItems()
	    }
	});
}
function updateCartPrice(obj, rowid){

	if(obj.value >= 0){
		$.get(base_url+'user/billing/updateCartPrice', {rowid:rowid, price:obj.value}, function(resp){
	    if(resp == 'ok'){
	        get_cartItems()
	    }
	   });
	}else{
		 toastr.error('Amount is invalid');
	}

	
}

function updateCartdescription(obj, rowid){

    if(obj.value !=''){
        $.get(base_url+'user/billing/updateCartdescription', {rowid:rowid, description:obj.value}, function(resp){});
    }
    
}

function cancel_bill(){
    $.get(base_url+'user/billing/cancel_bill',function(resp){get_cartItems()});
}

function print_bill(){

    $("#customer_form").validate({
                rules: {
                     customer_name: {
                        required: true,
                        minlength: 3,
                    },
                    mobile_no: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        digits: true,
                    },
                    customer_id: "required",
                  },
                messages: {
                    customer_name: {
                        required: 'Please enter customer name',
                        minlength: 'Name must be minimum 3 characters'
                    },
                    mobile_no: {
                        required: 'Please enter mobile no',
                        minlength: 'Mobile no is invalid',
                        maxlength: 'Mobile no is invalid',
                        digits: 'Mobile no is invalid',
                        
                    },
                    customer_id: "Customer id is required",
                                        
                }
                
            });

    if ($('#customer_form').valid()) // check if form is valid
        {

	        // ajax delete data to database
            $.ajax({
                url : base_url+"user/billing/print_bill",
                type: "POST",
                data:{delivery_time:$('#delivery_time').val(),mobile_no:$('#mobile_no').val(),customer_name:$('#customer_name').val(),customer_id:$('#customer_id').val(),bill_no:$('#bill_no').val()},
                success: function(res)
                {
                    var obj = JSON.parse(res);
                    if (obj.status === 200)
                    {
                        // toastr.success(obj.msg);
                        // window.open(base_url+'user/billing/bill_print/'+obj.bill_id,"_blank", "width=1500,height=650");
                        // window.location.reload();
                        toastr.success(obj.msg);
                        bill_print(obj.bill_id);
                        setTimeout(function(){ window.location.reload(); }, 6000); 
                    } 
                    else
                    {
                        toastr.error(obj.msg);
                    }
                },
                error:function(){
                    
                 }
            });

    }
}

function bill_print(id){
      window.open(base_url+'user/billing/bill_print/'+id);
      setTimeout(function(){ window.open(base_url+'user/billing/admin_print/'+id); }, 3000);
}