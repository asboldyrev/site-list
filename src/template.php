<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Список сайтов</title>
	<link rel="shortcut icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="/css/app.css">

	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<div class="mt20px">
		<h3>Список сайтов на <?= $_SERVER[ 'HTTP_HOST' ] ?></h3>
	</div>
	<div class="mt20px">
		Сортировать по:
		<?php if($sort == 'name') { ?>
			<span>Названию</span>
		<?php } else { ?>
			<a href="?sort=name">Названию</a>
		<?php } ?>

		<?php if($sort == 'update') { ?>
			<span>Времени</span>
		<?php } else { ?>
			<a href="?sort=update">Времени</a>
		<?php } ?>
	</div>

	<div class="row mt20px">
		<div class="list-group">

			<?php foreach ($list as $site) { ?>

				<div class="list-group-item">
					<div class="buttons-group">
						<a
							class="buttons"
							href="<?= $site->getUrl() ?>"
							target="_blank"
						>
						<?php if ($site->iconPath) { ?>
							<span class="icon">
									<img src="<?= $site->getIconPath(); ?>" alt="">
							</span>
						<?php } ?>
							<?= $site->name ?>
						</a>
						<?php if ($site->isChunker) { ?>
							<a
								href="<?= $site->getUrl('/admin') ?>"
								target="_blank"
								class="buttons"
							>Админка</a>
						<?php } ?>
					</div>
				</div>

			<?php } ?>
		</div>
	</div>
</div>
</body>
</html>