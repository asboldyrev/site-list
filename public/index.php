<?php
function ExtractDomain($Host, $Level = 2, $IgnoreWWW = false) {
	$Parts = explode(".", $Host);
	if ($IgnoreWWW and $Parts[ 0 ] == 'www') {
		unset($Parts[ 0 ]);
	}
	$Parts = array_slice($Parts, -$Level);

	return implode(".", $Parts);
}

if (file_exists('/etc/dnsmasq.conf')) {
	$pattern = '/^address=\/([\w]*)\/127\.0\.0\.1/m';
	$conf = file_get_contents('/etc/dnsmasq.conf');
	preg_match_all($pattern, $conf, $matches);
	$root_domain = $matches[1][0];
} else {
	$root_domain = 'loc';
}
?>

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
		<?php
			$path = "../../";
			$exceptions = [ '.', '..', 'access_log', 'list', '.Trash-1000', '.idea', '.Trash-1000', 'lost+found' ];

			$list = scandir($path);
			$list = array_diff($list, $exceptions);

			$domain = $_SERVER[ 'HTTP_HOST' ];

			if (is_int(mb_strpos($domain, '.' . $root_domain))) {
				$domain = ExtractDomain($_SERVER[ 'HTTP_HOST' ], 1);
			} else {
				$domain = ExtractDomain($_SERVER[ 'HTTP_HOST' ]);
			}
		?>
		<div class="row mt20px">
			<div
				class="col-xs-10 col-sm-8 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-2 col-md-offset-3 col-lg-offset-4">
				<h3 class="text-center">Список сайтов на <?php echo $_SERVER[ 'HTTP_HOST' ] ?></h3>

				<?php if ($domain == $root_domain) { ?>
					<div class="panel panel-default">
						<div class="list-group">
							<a class="list-group-item" target="_blank" href="http://localhost/phpmyadmin">
								<span class="icon">
									<?php
									$data = file_get_contents('http://localhost/phpmyadmin/favicon.ico');
									$base64 = 'data:image/ico;base64,' . base64_encode($data);
									?>
										<img src="<?php echo $base64; ?>" alt="">
								</span>
								phpMyAdmin
							</a>
						</div>
					</div>
				<?php } ?>
				
				<div class="panel panel-default">
					<div class="list-group">
						<?php foreach ($list as $dir) { ?>

							<div class="list-group-item">
								<div class="buttons-group">
									<a
										class="buttons"
										href="http://<?php echo $dir . '.' . $domain ?>"
										target="_blank"
									>
								<span class="icon">
									<?php
									$data = '';

									if (file_exists($path . $dir . '/public/img/layout/favicon.png')) {
										$data = file_get_contents($path . $dir . '/public/img/layout/favicon.png');

									} elseif (file_exists($path . $dir . '/public/img/favicon.png')) {
										$data = file_get_contents($path . $dir . '/public/img/favicon.png');

									} elseif (file_exists($path . $dir . '/public/favicon.png')) {
										$data = file_get_contents($path . $dir . '/public/favicon.png');

									} elseif (file_exists($path . $dir . '/public/assets/favicon.png')) {
										$data = file_get_contents($path . $dir . '/public/assets/favicon.png');

									}

									$base64 = 'data:image/png;base64,' . base64_encode($data);

									?>

									<?php if($data) { ?>
										<img src="<?php echo $base64; ?>" alt="">
									<?php } ?>
								</span>
										<?php echo $dir ?>
									</a>
									<?php if (is_dir($path . $dir . '/vendor/chunker/base/') || is_dir($path . $dir . '/chunker/')) { ?>
										<a
											href="http://<?php echo $dir . '.' . $domain . '/admin' ?>"
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