<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=products/showReviews'?>">
	<table>
		<tr><th>Ime</th><th>Opis</th><th>Cijena</th></th><th>Vidi Recenzije</th></tr>
		<?php 
			foreach( $productsList as $product )
			{
				echo '<tr>' .
				     '<td>' . $product->name . '</td>' .
				     '<td>' . $product->description . '</td>' .
					 '<td>' . $product->price . '</td>' .
				     '<td><button type="submit" name="product_id" value="product_' . $product->id . '">Vidi!</button></td>' .
				     '</tr>';
			}
		?>
	</table>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
