<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<h2>Detalji o proizvodu</h2>

<table>

<tr><th>Prodavac</th><th>Ime proizvoda</th><th>Opis</th><th>Cijena</th><th>Prosječna ocjena</th></tr>

<?php
echo '<tr>' .
			     '<td>' . $seller->username . '</td>' .
			     '<td>' . $product->name . '</td>' .
			     '<td>' . $product->description . '</td>' .
				 '<td>' . $product->price . '</td>' .
				 '<td>' . $average_rating . '</td>' .
			     '</tr>';

?>

</table>

<h2>Recenzije proizvoda</h2>
<table>
	<tr><th>Korisnik</th><th>Ocjena</th><th>Komentar</th></tr>
	<?php 
		foreach( $reviewList as $review )
		{
			echo '<tr>' .
			     '<td>' . $review['user']->username . '</td>' .
			     '<td>' . $review['sale']->rating . '</td>' .
			     '<td>' . $review['sale']->comment . '</td>' .
			     '</tr>';
		}
	?>
</table>
<br>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=products/buyProduct'?>">
<button type="submit"<?php if(!$canBuy) echo 'disabled' ?>>Kupi!</button>
</form>

<br>
<br>




<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=products/reviewProduct'?>">

<h2>Ocjenite proizvod</h2>

<select name="rating" id="rating">
					<option selected="selected" disabled="disabled">Please select...</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
</select>

<br>
<br>

<textarea name="comment" id="comment" rows="4" cols="40"></textarea>

<br>
<br>

<input type="submit" id="btnSubmit" name="btnSubmit" value="Ocjeni" <?php if(!$hasBought) echo 'disabled' ?> />

</form>

