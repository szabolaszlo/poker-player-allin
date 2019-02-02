<?php

$old_error_handler = set_error_handler("myErrorHandler");

function myErrorHandler($errno, $errstr, $errfile, $errline){
    echo 0;
}

require_once('player.php');

$player = new Player();

switch($_POST['action'])
{
    case 'bet_request':
        echo $player->betRequest(json_decode($_POST['game_state'], true));
        break;
    case 'showdown':
        $player->showdown(json_decode($_POST['game_state'], true));
        break;
    case 'version':
        echo Player::VERSION;
}
