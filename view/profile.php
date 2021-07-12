<?php
    require_once '_header.php';
?>

<div id="top">
    <div id="user">
        <img alt="Avatar" id="avatar" src="view/avatar.webp">
        <h1 id="username">Username</h1>
    </div>
    <div id="games"></div>
</div>
<div id="bottom-left">
    <h3>My highscores: </h3>
    <ul id="highscores">
        <!-- inače priko neke skripte povuci -->
        <li><b>Potapanje brodova:</b> 130</li>
        <li><b>Memory:</b> 104</li>
        <li><b>Vješala:</b> 135</li>
        <li><b>Križić-kružić:</b> 50</li>
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