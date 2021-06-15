<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=add/newProduct'?>">

Unesite ime proizvoda: 

<input type="text" name="name" value="" />

<br>
<br>

Unesite opis proizvoda: 

<textarea name="description" id="description" rows="4" cols="40"></textarea>

<br>
<br>

Unesite cijenu proizvoda: 

<input type="text"  name="price" value="" />


<input type="submit" id="btnSubmit" name="btnSubmit" value="Dodaj" />

</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>


