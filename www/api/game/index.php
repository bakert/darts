<?php

require_once(dirname(__FILE__) . '/../../../darts.php');

function main() {
    header('Content-type: application/json');
    if (!valid($_POST)) {
        header('HTTP/1.0 400 Bad Request');
        return;
    }
    if (!addGame($_POST['winner'], $_POST['players'])) {
        header('HTTP/1.0 500 Internal Server Error');
        return;
    }
    echo json_encode(array());
}

function valid() {
    return isset($_POST['winner']) && is_array($_POST['players']);
}

function addGame($winner, $players) {
    $conn = dStartTransaction();
    $sql = 'INSERT INTO game (`date`) VALUES (NOW())';
    transact_db($sql, $conn);
    $sql = 'SELECT MAX(id) AS id FROM game';
    $rs = ddb($sql);
    $gameId = $rs[0]['id'];
    foreach ($players as $player) {
        $winnerV = $winner == $player ? 1 : 0;
        $sql =  'INSERT INTO played (player_id, game_id, winner) '
            . 'VALUES (' . s($player) . ', ' . s($gameId) . ', ' . $winnerV . ')';
        transact_db($sql, $conn);
    }
    return commit($conn);
}

main();
