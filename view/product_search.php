<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=product_search/searchResults">
	Unesi ime proizvoda koji vas zanima:
	<input type="text" name="product" />

	<button type="submit">Traži</button>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
