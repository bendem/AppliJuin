<div class="row-fluid">
	<div class="span12">
		<form action="<?= url($req) ?>" method="post" class="form-horizontal">
			<input type="text" name="produit[1]">
			<input type="submit">
		</form>
		<a href="#" id="add" class="btn"><span class="icon-plus"></span></a>
	</div>
</div>

<script>
	jQuery(function($) {
		var num = 1;
		$('#add').click(function() {
			$('form').append($('<input/>').attr({
				type : 'text',
				name : 'produit[' + num + ']'
			}));
		});
	})
</script>
