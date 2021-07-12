<?php
    require_once '_header.php';
?>

<div id="top">
    <div id="user">
        <img alt="Avatar" id="avatar" src="view/avatar.webp">
        <h1 id="username"><?php echo $username ?></h1>
    </div>
    <div id="games"></div>
</div>
<div id="bottom-left">
    <h3>My highscores: </h3>
    <ul id="highscores">
        <!-- inače priko neke skripte povuci -->
        <?php 
            foreach($high_scores as $high){
                echo "<li><b>" . $high['name'] . "</b>" . " " . $high['high_score']  . " " . $high['date_achieved'] . "</li>";
            }
        ?>
    </ul>
    <h3>My achievements: </h3>
    <ul id="achievements">
        <!-- priko nekog .js file-a ili neke skripte povuci -->
    </ul>
</div>
<div id="bottom-right">
<h3>My reviews: </h3>
    <ul id="reviews">

    </ul>
</div>

<?php
    require_once '_footer.php';
?>