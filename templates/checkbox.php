<div class="control-group <?= isset($specOptions['state']) ? $specOptions['state'] : '' ?>">
	<?php if(isset($specOptions['label'])): ?>
		<label class="control-label" for="<?= isset($specOptions['id']) ? $specOptions['id'] : 'form_' . $name ?>"><?= $specOptions['label'] ?></label>
	<?php endif; ?>
	<div class="controls">
		<input type="hidden" name="<?= $name ?>" value="">
		<input type="checkbox" name="<?= $name ?>" id="<?= isset($specOptions['id']) ? $specOptions['id'] : 'form_' . $name ?>" <?php foreach($options as $k => $v) echo $k . '="' . $v . '"'; ?>>
		<?php if(isset($specOptions['help'])): ?>
			<span class="help-inline">
				<?= $specOptions['help'] ?>
			</span>
		<?php endif; ?>
	</div>
</div>
