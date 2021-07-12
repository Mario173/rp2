<?php

require_once 'igreController.php';

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

?>