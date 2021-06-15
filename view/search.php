<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=search/searchResults">
	Unesi ime proizvoda koji vas zanima(case-sensitive):
	<input type="text" name="product_name" />

	<button type="submit">Traži</button>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
