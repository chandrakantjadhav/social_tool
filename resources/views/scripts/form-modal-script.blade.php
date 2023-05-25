<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"> -->

<script type="text/javascript">

 $(document).ready(function() {
	var modalId = $('#confirmForm');
	
	modalId.on('show.bs.modal', function (e) {
		event.preventDefault();
		var modalClass = $(e.relatedTarget).attr('data-modalClass') || '';
		var submitText = $(e.relatedTarget).attr('data-submit');
		var message = $(e.relatedTarget).attr('data-message');
		var title = $(e.relatedTarget).attr('data-title');
		var form = $(e.relatedTarget).closest('form');
		var id =  $(e.relatedTarget).closest('form').attr('id');
		console.log(id);
		// var self = $(this);
		// console.log(form);
		// form.alterClass('modal-*', modalClass);
		// self.find('.modal-body p').text(message);
		
		$('#dataInput').val(id);
		// self.find('.modal-footer #confirm')
		// 	.text(submitText)
			// .data('form', form);
	});

	modalId.find('#confirm').on('click', function(){
		event.preventDefault();
		var id ='#' + $('#dataInput').val();
		$('#confirmForm').hide();
		$(id).submit();
	});


	

});
</script>