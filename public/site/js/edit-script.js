$(document).ready(function () {

	//Scanner Data updates
	var products = localStorage.getItem('tableData');

	if (products) {

		productData = JSON.parse(products);
		$.each(productData, function(index,row) {
			var tabdata = '<tr data-id="'+row.id+'">'+
	                        '<td>'+Number(index+1)+'</td>'+
	                        '<td>'+row.section_no+'</td>'+
	                        '<td>'+row.cut_length+'</td>'+
	                        '<td>'+row.alloy+'</td>'+
	                        '<td>'+row.lot_no+'</td>'+
	                        '<td>'+row.surface+'</td>'+
	                        '<td>'+row.weight+'</td>'+
	                        '<td>'+row.pcs+'</td>'+
	                        '<td>'+row.pack_date+'</td>'+
	                        // '<td><button class="remove-btn btn btn-danger btn-sm">X</button></td>'+
	                    '</tr>';
			$('#scan-data').append(tabdata);
		});
	}

	$(document).on('click', '#scan-btn', function() {

		$("#scan-btn").attr("disabled", true);
		var result = scanText.decodedText;
		var data = result.split("|");

		if ((data.length - 1) === 7) {

			var storedData = localStorage.getItem('tableData');
			var dataLength = 0;
			if (storedData) {
				tableData = JSON.parse(storedData);
				dataLength = tableData.length;
			}

			var tabdata = '<tr data-id="'+Number(dataLength+1)+'">'+
	                        '<td>'+Number(dataLength+1)+'</td>'+
	                        '<td>'+data[0]+'</td>'+
	                        '<td>'+data[1]+'</td>'+
	                        '<td>'+data[2]+'</td>'+
	                        '<td>'+data[3]+'</td>'+
	                        '<td>'+data[4]+'</td>'+
	                        '<td>'+data[5]+'</td>'+
	                        '<td>'+data[6]+'</td>'+
	                        '<td>'+data[7]+'</td>'+
	                        '<td><button class="remove-btn btn btn-danger btn-sm">X</button></td>'+
	                    '</tr>';
	        var backdata = {
	        	id: 'new'+ Number(dataLength+1),
	    		section_no: data[0],
	    		cut_length: data[1],
	    		alloy: data[2],
	    		lot_no: data[3],
	    		surface: data[4],
	    		weight: data[5],
	    		pcs: data[6],
	    		pack_date: data[7]
	    	};

	        tableData.push(backdata);
	        localStorage.setItem('tableData', JSON.stringify(tableData));
			$('#scan-data').append(tabdata);
			$('#qrScannerModal').modal('hide');
		} else {
			Swal.fire({
                title: 'Error!',
                text: 'Invalid QR Code',
                icon: 'error',
                confirmButtonText: 'OK'
            })
		}
	});

	$(document).on("click", ".remove-btn", function () {
        let row = $(this).closest("tr");
        let id = row.data("id");

        tableDatas = localStorage.getItem('tableData');
        tableData = JSON.parse(tableDatas);
        tableData = tableData.filter(item => item.id != id);

        // Update localStorage
        localStorage.setItem("tableData", JSON.stringify(tableData));

        // Remove row from DOM
        row.remove();
    });

	$(document).on('click', '#save_records', function() {

		$("#save_records").attr("disabled", true);

		var packingData = localStorage.getItem('tableData');
		var formData = new FormData();

		formData.append('packing_data', packingData);
		formData.append('packing_id', $('#packing_id').val());
		formData.append('customer_id', $('#customer_id').val());
		formData.append('vehicle_no', $('#vehicle_no').val());
		formData.append('pl_no', $('#pl_no').val());
		formData.append('billing_date', $('#billing_date').val());
		formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

		// ajax adding data to database
	    $.ajax({
	    	url: save_packing_route,
	        type: "POST",
	        data: formData,
	        processData: false,
	        contentType: false,
	        cache: false,
	        beforeSend: function () {
	        	$(".help-block").empty();
	          	$("#save_records").attr("disabled", true);
	          	$("#save_records").html('<div class="spinner-border text-light" role="status"></div>');
	        },
	        success: function (data) {
	          	$("#save_records").attr("disablzed", false);
	          	$("#save_records").html("Save Record");
	          	localStorage.removeItem('tableData');
	          	localStorage.removeItem('page_local');
				$('#scan-data').html('');
	          	
	          	if(data.code == '200') {
		          	Swal.fire({
		                title: 'Success!',
		                text: data.message,
		                icon: 'success',
		                confirmButtonText: 'OK'
		            }).then((result) => {
					    if (result.isConfirmed) {
					        location.href = reload_route; // Reloads the page
					    }
					});
		        } else {
		        	Swal.fire({
		                title: 'Error!',
		                text: data.message,
		                icon: 'error',
		                confirmButtonText: 'OK'
		            }).then((result) => {
					    if (result.isConfirmed) {
					        location.reload(); // Reloads the page
					    }
					});
		        }
	        },
	        error: function (jqXHR) {
	          	var errors = jqXHR.responseJSON;
	          	if (jqXHR.status === 401)
	            	//redirect if not authenticated category.
	            	window.location.reload();
	          	if (jqXHR.status === 422) {
	            	$.each(errors.message, function (key, value) {
	              		var fieldKey = key.replace(/\./g, "_");
	              		$("#" + fieldKey)
	                	.next(".help-block")
	                	.html(value[0])
	                	.removeClass("d-none"); // showing only the first error.
	            	});
	          	} else {
	          		Swal.fire({
		                title: 'Error!',
		                text: errors.message,
		                icon: 'error',
		                confirmButtonText: 'OK'
		            });
	          	}
	          	$("#save_records").attr("disabled", false);
	          	$("#save_records").html("Save Record");
	        },
	    });
	});

	$(document).on('click', '#reset_records', function() {
		$("#reset_records").attr("disabled", true);
		localStorage.removeItem('tableData');
		localStorage.removeItem('page_local');
		$('#scan-data').html('');
		$("#reset_records").attr("disabled", false);
	});
	// Scanner Data updates
	
	//clock function
	function updateClock() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;

        $("#current-time").html('<i class="far fa-clock"></i> '+timeString);
    }

    // Update the clock every second
    setInterval(updateClock, 1000);

    // Initialize the clock
    updateClock();
	//clock function
});