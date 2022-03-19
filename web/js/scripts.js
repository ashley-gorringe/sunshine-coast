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
