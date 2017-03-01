
$( document ).ready(function() {
  // Handler for .ready() called.

	// This must be applied to a form (or an object inside a form).
	jQuery.fn.addHidden = function (name, value) {
	    return this.each(function () {
        	var input = $("<input>").attr("type", "hidden").attr("name", name).val(value);
        	$(this).append($(input));
    	});
	};

	

	$('.php-excel-form-add-btn').click(function(){
		console.log("add btn click");
		if ($('#item-count') ){
			$('#item-count').val(parseInt($('#item-count').val(),10)+1);
			$('#php-excel-form-save').val("add");
			$('.php-excel-form').submit();
		}
	});

	$('.php-excel-form-del-btn').click(function($obj){
		
		if ($('#item-count') ){
			$count = parseInt($('#item-count').val(),10)-1;
			console.log("add btn click"+$count);
			if ( $count>=0 ){
				$delid = $(this).data('id');
				console.log($delid);
				$('#item-count').val($count);
				$('#php-excel-form-save').val("del");
				//$('.php-excel-form').submit();
			}
		}
	});


});