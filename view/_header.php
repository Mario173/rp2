<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>ebuy</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
	<h1><?php echo $title; ?></h1>

	<nav>
		<ul>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=products">Popis svih proizvoda koje prodaješ</a></li>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=add">Dodaj novi proizvod za prodaju</a></li>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=products/bought">Popis proizvoda koje si kupio</a></li>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=search">Traži proizvode</a></li>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=logout">Logout</a></li>
		</ul>
	</nav>
