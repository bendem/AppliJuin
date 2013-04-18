<?php $title_for_layout = "Ajout de dépôt" ?>

<div class="row-fluid">
	<div class="span12">
		<form action="<?= url($req) ?>" method="post" class="form-horizontal">

			<?php
			foreach($post as $k => $v) {
				if(isset($v['type'])) {

					$type = $v['type'];
					unset($v['type']);
					if($type == 'select') {
						echo form_select($k, $v);
					} elseif($type == 'radio') {
						echo form_radio($k, $v);
					}
				} else {
					echo form_input($k, $v);
				}
			}
			?>

			<div class="form-actions">
				<input type="submit" class="btn">
				<input type="reset" class="btn btn-danger">
			</div>
		</form>
	</div>
</div>
