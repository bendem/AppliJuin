<?php $title_for_layout = 'Information sur le stock' ?>

<div class="row-fluid">
	<div class="span12">
		<p>
			Le dépôt n°<?= labelize($d['numDepot']) ?>, <?= labelize($d['nomDepot']) ?>, dont le responsable
			est <?= $d['responsableDepot'] ? labelize($d['responsableDepot']) : labelize('personne') ?>,
			situé <?= labelize($d['adresseDepot']) ?>
			à <?= labelize($d['villeDepot']) ?> contient
			<?= labelize($d['quantite']) ?> <?= $d['uniteProduit'] ?>
			du produit n°<?= labelize($d['numProduit']) ?>, <?= labelize($d['nomProduit']) ?>.
		</p>
	</div>
</div>
