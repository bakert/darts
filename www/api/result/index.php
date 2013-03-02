<?php

require_once(dirname(__FILE__) . '/../../../darts.php');
require_once(COMMON . '/results.php');
require_once(MODELS . '/game.php');
require_once(MODELS . '/player.php');

function main() {
    header('Content-type: application/json');
    if (!valid($_POST)) {
        header('HTTP/1.0 400 Bad Request');
        return;
    }
    echo json_encode(array('result' => result($_POST['winner'], $_POST['players'])));
}

function valid() {
    return isset($_POST['winner']) && is_array($_POST['players']);
}

function result($w, $ps) {
    $players = standings();
    $winner = $players[$w];
    $losers = array();
    foreach ($ps as $playerId) {
        if ($playerId !== $w) {
            $losers[] = $players[$playerId];
        }
    }
    $game = new Game(null, time(), $winner, $losers);
    return gainsAndLosses($game);
}

main();
