<?php

require_once 'igreController.php';

if( isset($_POST['game']) ) {
    $temp = new IgreController();
    switch ( $_POST['game'] ) {
        case 'memory':
            $temp->generiraj_memory();
            break;
        default:
            break;
    };
} 

?>