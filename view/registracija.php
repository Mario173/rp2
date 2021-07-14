<!DOCTYPE html>
<html>

    <head>
        <title>Registracija</title>
        <meta charset="utf-8">
    </head>
    <body>

    <h1>Registracija na igre! :D</h1>

    <form method="post" action="<?php echo '/~vinkoben/Projekt/index.php?rt=registration/processRegistration'?>" >
        <br>
        <br>
        <label for="user" id="label">Username</label>
        <input name="username" type="text" value="" id="user" >

        <br>
        <br>
        <label for="password" id="label">Password</label>
        <input type="password" name="pass" value="" id="password" >

        <br><br>
        <label for="password2" id="label">Ponovi password</label>
        <input type="password" name="pass2" value="" id="password2" >

        <br><br>
        <label for="mail" id="label">Mail</label>
        <input type="text" name="mail" value="" id="mail" >

        <br><br>
        <input type="submit" value="Registriraj se" />

        <?php if(  isset($_GET['poruka']) ) echo '<p>' . $_GET['poruka'] .'</p>'; ?>

    </form>

    <br><br>
    <form method="post" action="<?php echo '/~vinkoben/Projekt/index.php'?>">
    <input type="submit" value="vrati se na login"/>
    </form>

    <br><br>
    </body>



</html>