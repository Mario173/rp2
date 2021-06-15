<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>ebuy</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>

<h1>Prijavite se na ebuy</h1>

<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/processLogin'?>">

Korisničko ime: 

<input type="text" name="username" value="" />

<br>
<br>


Lozinka: 


<input type="password"  name="password" value="" />

<br>
<br>

<input type="submit" id="btnSubmit" name="btnSubmit" value="Prijava" />

</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>

