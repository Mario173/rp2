<?php
    require_once '_header.php';
?>

<div id="top">
    <div id="user">
        <img alt="Avatar" id="avatar" src="view/avatar.webp">
        <h1 id="username"><?php echo $username ?></h1>
    </div>
    <div id = "level_and_exp">
        <div class = "level"> <p>Level <?php echo $level ?></p> </div>
        <div class="w3-light-grey" style = "width:100px;">
            <div class="w3-blue" style= <?php echo "height:10px;width:" . $percentage . "%" ?>></div>
        </div>
    </div>
    <div id="games"></div>
</div>
<div id="bottom-left">
    <h3>My highscores: </h3>
    <ul id="highscores">
        <!-- inače priko neke skripte povuci -->
        <?php 
            foreach($high_scores as $high){
                echo "<li><b>" . $high['name'] . "</b>" . ": " . $high['high_score']  . ", achieved: " . $high['date_achieved'] . "</li>";
            }
        ?>
    </ul>
    <h3>My achievements: </h3>
    <ul id="achievements">
        <?php 
            foreach($achievements_array as $achievement){
                echo "<li><b>" . $achievement[0] . "</b>" . ": " . $achievement[1] . "</li>";
            }
        ?>
        <!-- priko nekog .js file-a ili neke skripte povuci -->
    </ul>
</div>
<div id="bottom-right">
<h3>My reviews: </h3>
    <ul id="reviews">
        <?php 
            foreach($reviews_array as $review){
                $content = "<li><b>" . $review[0] . "</b>" . ": ";
                for($i = 0; $i < $review[1]; $i++) {
                    $content .= '<i class="far fa-star"></i>';
                }
                $content .= " " . $review[2] . "</li>";
                echo $content;
            }
        ?>
    </ul>
</div>

<?php
    require_once '_footer.php';
?>