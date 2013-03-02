<?php

require_once(dirname(__FILE__) . '/../darts.php');
require_once(MODELS . '/game.php');
require_once(MODELS . '/player.php');

function data() {
    list($games, $players, $game, $gameId) = array(array(), setupPlayers(), null, null);
    foreach (allPlayed() as $played) {
        if ($gameId != $played['game_id']) {
            if (!is_null($game)) {
                updatePlayers($players, $game);
                $games[] = $game;
            }
            $game = new Game($played['game_id'], $played['date']);
            $gameId = $game->id();
        }
        // We copy players here because we want a snapshot of them as they
        // played this match not a reference to their final record.
        if ($played['winner']) {
            $game->setWinner($players[$played['player_id']]->copy());
        } else {
            $game->addLoser($players[$played['player_id']]->copy());
        }
    }
    if ($gameId) {
        updatePlayers($players, $game);
        $games[] = $game;
    }
    return array($players, $games);
}

function updatePlayers($players, $game) {
    foreach ($game->players() as $p) {
        $player = $players[$p->id()];
        $player->rating += $game->change($player);
        $player->played += 1;
        if ($game->winner()->id() === $player->id()) {
            $player->streak += 1;
        } else {
            $player->streak = 0;
        }
    }
    return $players;
}

function standings() {
    list($players) = data();
    return $players;
}

function games() {
    list($players, $games) = data();
    return $games;
}

function allPlayed() {
    $sql = 'SELECT UNIX_TIMESTAMP(g.date) AS `date`, pd.game_id, pd.player_id, pd.winner '
        . 'FROM played AS pd '
        . 'INNER JOIN game AS g ON pd.game_id = g.id '
        . 'ORDER BY g.date, g.id, pd.id';
    return ddb($sql);
}

function setupPlayers() {
    $players = array();
    $sql = 'SELECT id, name FROM player ORDER BY id';
    foreach (ddb($sql) as $row) {
        $players[$row['id']] = new Player($row['id'], $row['name']);
    }
    return $players;
}
