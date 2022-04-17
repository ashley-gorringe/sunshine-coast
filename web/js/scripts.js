$("#startDate").flatpickr({
	minDate: "today",
	altInput: true,
    altFormat: "F j Y",
    dateFormat: "Y-m-d",
});
$("#startDate").on('change',function(event){
	event.preventDefault();
	var startDate = new Date($('#startDate').val());
	startDate.setDate(startDate.getDate() + 1);
	var minEndDate = moment(startDate).format('YYYY-MM-DD');
	console.log(minEndDate);

	$('#endDate').prop('disabled', false);
	$('#endDate').val('');
	$("#endDate").flatpickr({
		minDate: minEndDate,
		altInput: true,
    	altFormat: "F j Y",
    	dateFormat: "Y-m-d",
	});
});

$("#purchaseDate").flatpickr({
	enableTime: true,
	altInput: true,
    altFormat: "F j Y - H:i",
    dateFormat: "Y-m-d H:i",
	defaultDate: moment().format('YYYY-MM-DD HH:mm'),
});

$( document ).on('submit','.process-form',function(event){
    console.log( $( this ).serialize() );
    event.preventDefault();

	var submitButton = $(this).find(':submit');
	var originalSubmitText = $(submitButton).html();
    submitButton.html(originalSubmitText + ' <i class="fas fa-spinner fa-pulse"></i>');

	$(this).find('.form-control').removeClass( "invalid" );
    $.ajax({
        type: "POST",
        url: '/process.php',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
            console.log(response);
            if(response.status == 'error'){
                if(typeof response.errorFields !== "undefined"){
                    var errorFields = response.errorFields;
                    errorFields.forEach(function(errorFieldsItem) {
						var fieldName = errorFieldsItem['field_name'];
						var fieldErrorMessage = errorFieldsItem['error_message'];
						var fieldElement = '[name="'+fieldName+'"]';
                        $(fieldElement).addClass( "invalid" );
                        $(fieldElement).siblings('.form-error').html( fieldErrorMessage );
                    });
                }
				swal({
					title: "Hold up!",
					text: response.message,
					icon: "error",
				});

				submitButton.html(originalSubmitText);
            }else if(response.status == 'success'){
                submitButton.html(originalSubmitText);

                if(typeof response.successRedirect !== 'undefined'){
                    window.location.href = response.successRedirect;
                }
                if(typeof response.successCallback !== 'undefined'){
                    console.log('Callback Function: '+response.successCallback);
                    window[response.successCallback](response.successCallbackParams);
                }
                if(typeof response.message !== 'undefined'){
					swal({
						text: response.message,
					});
                }
            }
        }
    });
});
$('#addRoom').click(function(event){
	event.preventDefault();
	$.getJSON('/rooms.json',function(data){
		var items = '';
		$.each(data,function(key, value){
			//console.log(value['room_number']);
			if(value['wheelchair_access'] == 1){
				var wheelchair = ' - Wheelchair';
			}else{
				var wheelchair = '';
			}
			items += '<option value="'+value['room_id']+'">'+value['room_number']+' - '+value['room_type']+wheelchair;
		});

		$('#rooms').append(`
			<div class="row mt-3">
				<div class="col-9">
					<div class="form-group">
						<label>Select Room</label>
						<select class="form-control" name="rooms[]">
						<option value="">Please Select</option>
						`+items+`
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label>No. of People</label>
						<input class="form-control" name="people[]" type="number" value="1" min="1" max="6" />
					</div>
				</div>
			</div>
			`);
	});
});

$('#bookingPay').click(function(event){
	event.preventDefault();
	alert('Pay');
});

function deleteBooking(booking_id){
	$.ajax({
        type: "POST",
        url: '/process.php',
        data: "action=booking-delete&booking="+booking_id,
        dataType: 'json',
        success: function(response){
            console.log(response);
            if(response.status == 'error'){
				swal({
					title: "Hold up!",
					text: response.message,
					icon: "error",
				});
            }else if(response.status == 'success'){
                window.location.href = response.successRedirect;
            }
        }
    });
}

$('#bookingCancel').click(function(event){
	event.preventDefault();
	var booking_id = $('#bookingCancel').data('booking');
	swal({
		icon: "warning",
		title: "Are you sure?",
		text: "Once canceled, you will not be able to recover this booking.",
		buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			deleteBooking(booking_id);
		}
	});
});
$('#bookingDelete').click(function(event){
	event.preventDefault();
	var booking_id = $('#bookingCancel').data('booking');
	swal({
		icon: "warning",
		title: "Are you sure?",
		text: "Once deleted, you will not be able to recover this booking.",
		buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			deleteBooking(booking_id);
		}
	});
});
