<?php $title_for_layout = '404' ?>

<?php
$nyan = array(
	'america', 'balloon', 'daft',
	'dub', 'elevator', 'fiesta',
	'gb', 'j5', 'jamaicnyan',
	'jazz', 'mexinyan', 'newyear',
	'nyaninja', 'pikanyan', 'retro',
	'sad', 'slomo', 'smurf',
	'tacnayn', 'technyancolor', 'vday',
	'nyan', 'wtf'
);

$nyan = $nyan[rand(0, sizeof($nyan) - 1)];
?>
<div class="row-fluid">
	<div class="span12">
		<h2>La page n'a pas été trouvée...</h2>
		<p>
			En la cherchant, nous avons trouvé <em>ceci</em> :
		</p>
		<div>
			<?php boum(); ?>
		</div>
		<audio autoplay loop>
			<source src="<?php echo webroot('sounds/mp3/' . $nyan . '.mp3') ?>" type="audio/mpeg">
			Votre navigateur ne supporte pas le son...
		</audio>
	</div>
</div>
