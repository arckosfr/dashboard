<?php
$json = file_get_contents('service.json');
$data = json_decode($json, true);

foreach ($data as $item) { ?>

    <div class="col-sm-4 col-xs-12 col-centered">
		<div class="thumbnail tile <?= $item[color] ?> text-center">
			<a href="<?= $item[lien] ?>" class="fa-links">
			<h1><?= $item[titre] ?></h1>
			<i class="fa fa-3x <?= $item[icone] ?>"></i>
			</a>
		</div>
	</div>

<?php } ?>

