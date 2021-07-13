<?php

//require_once 'igreController.php';


if( isset($_POST['q'])){
    //$imena = [ "Ana", "Ante", "Boris", "Maja", "Marko", "Mirko", "Slavko", "Slavica" ];
    $q = $_POST[ "q" ];

    $gs = new GameService();

    $imena = $gs->getAllUsernames();

    // Protrči kroz sva imena i vrati HTML kod <option> za samo ona 
    // koja sadrže string q kao podstring.
    foreach( $imena as $ime )
        if( strpos( $ime, $q ) !== false )
            echo "<option value='" . $ime . "' />\n";
}
/*
if( isset($_POST['game']) ) {
    $temp = new IgreController();
    switch ( $_POST['game'] ) {
        case 'memory':
            $temp->generiraj_memory();
            break;
        case 'potapanje_brodova':
            if( isset($_POST['funkcija']) ) {
                if( $_POST['funkcija'] === 'generiraj' ) {
                    $temp->generiraj_potapanje();
                } else if( $_POST['funkcija'] === 'provjeri' ) {
                    $temp->provjeri_potapanje();
                }
            }
            break;
        case 'vješala':
            $temp->generiraj_vjesala();
            break;
        default:
            break;
    };
} 

*/

?>