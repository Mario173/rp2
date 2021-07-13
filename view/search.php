<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<div id = "search_div">


<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=search/searchResults">
	Unesi ime igrača:
	<input id = "search_textbox" type="text" list="datalist_imena" name="product_name" />
	<datalist id="datalist_imena"></datalist>
	<button id = "search_button" type = "submit">Traži</button>
</form>

</div>

<script>
    $( document ).ready( suggest_names );
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
