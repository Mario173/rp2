<?php
    require_once '_header.php';
?>

<div id="left">
    <div id="user">
        <img alt="Avatar" id="avatar" src="view/avatar.webp">
        <h1 id="username">Username</h1>
    </div>
    <div id="games"></div>
</div>
<div id="middle">
    <!-- ovde će ić svi -->
</div>
<div id="right">
    <h2 style="height: 50px;">Highscore</h2>
    <table id="tablica_highscore"></table>
</div>

<script>
    $( document ).ready( iscrtaj_lijevo );
</script>

<?php
    require_once '_footer.php';
?>