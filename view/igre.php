<?php
    require_once '_header.php';
?>

<div id="left">
    <div id="user">
        <img alt="Avatar" id="avatar_ne" src=<?php echo $avatar_src; ?>>
        <h1 id="username"><?php echo $username ?></h1>
    </div>
    <div id="games"></div>
</div>
<div id="middle">
    <!-- ovde će ić svi -->
</div>
<div id="right">
    <h2>Highscore</h2>
    <table id="tablica_highscore"></table>
    <br>
    <br>
    <h2>Reviews</h2>
    <table id="tablica_reviews"></table>
</div>

<script>
    $( document ).ready( iscrtaj_lijevo );
</script>

<?php
    require_once '_footer.php';
?>