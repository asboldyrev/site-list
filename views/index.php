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
	<div class="row mt20px">
		<div
			class="col-xs-10 col-sm-8 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-2 col-md-offset-3 col-lg-offset-4">
			<h3 class="text-center">Список сайтов на <?= host() ?></h3>
			<div class="panel panel-default">
				<div class="list-group">
					<?php foreach ($sites->getSites() as $site) { ?>

						<div class="list-group-item">
							<div class="buttons-group">
								<a
									class="buttons"
									href="<?= $site->getUrl($domain) ?>"
									target="_blank"
								>
								<span class="icon">
									<?php if ($site->hasIcon()) { ?>
										<img src="<?= $site->getIcon(); ?>" alt="">
									<?php } ?>
								</span>
									<?= $site->getName() ?>
								</a>
								<?php if ($site->hasAdmin()) { ?>
									<a
										href="<?= $site->getAdminUrl($domain) ?>"
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
	</div>
</div>
</body>
</html>