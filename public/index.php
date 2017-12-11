<?php
	function ExtractDomain($Host, $Level = 2, $IgnoreWWW = false) {
		$Parts = explode(".", $Host);
		if($IgnoreWWW and $Parts[0] == 'www') unset($Parts[0]);
		$Parts = array_slice($Parts, -$Level);
		return implode(".", $Parts);
	}
?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Список сайтов</title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="/css/app.css">

	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
</head>
<body>
<?php
	$list = scandir("../../");
	$list = array_diff($list, ['.', '..', 'access_log', 'list', '.Trash-1000']);

	$domain = $_SERVER['HTTP_HOST'];

	if (is_int(mb_strpos($domain, '.dev'))) {
		$domain = ExtractDomain($_SERVER['HTTP_HOST'], 1);
	} else {
		$domain = ExtractDomain($_SERVER['HTTP_HOST']);
	}
?>
	<div class="row mt20px">
		<div class="col-xs-10 col-sm-8 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-2 col-md-offset-3 col-lg-offset-4">
			<h3 class="text-center">Список сайтов на <?php echo $_SERVER['HTTP_HOST'] ?></h3>

			<div class="panel panel-default">
				<div class="list-group">
					<?php foreach ($list as $dir) { ?>
						<a
							class="list-group-item"
							href="http://<?php echo $dir . '.' . $domain ?>"
							target="_blank"
						><?php echo $dir ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>