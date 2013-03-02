<?php

require_once(dirname(__FILE__) . '/../darts.php');

function standingsTable($players) {
    $players = sortPlayers($players);
    $s = '<p>Click players\' names to add a result.</p>';
    $s .= '<table>';
    $s .= '<tr>'
        . '<th class="span-20"></th>'
        . '<th class="span-25">Name</th>'
        . '<th class="span-5">Rating</th>'
        . '<th class="span-5">Played</th>'
        . '<th class="span-5">Streak</th>'
        . '<th class="span-40"></th>'
        . '</tr>';
    foreach ($players as $player) {
        $s .= standingsRow($player);
    }
    $s .= '</table>';
    $s .= '<div class="submit-game"><a href="#">SUBMIT</a> <span class="potential-result"></span></div>';
    return $s;
}

function standingsRow($player) {
    $s = '<tr class="selector">';
    $s .= '<td><a class="winner" href="#">LOSER</a></td>';
    $s .= '<td><a class="player" data-id="' . q($player->id()) . '" href="#">'
        . q($player->name()) . '</a></td>';
    $s .= '<td class="n">' . q($player->rating) . '</td>';
    $s .= '<td class="n">' . q($player->played) . '</td>';
    $s .= '<td class="n">' . q($player->streak) . '</td>';
    $s .= '<td></td>';
    $s .= '</tr>';
    return $s;
}

function gamesTable($games) {
    $games = array_reverse($games); // Latest at the top please.
    $s = '<table>';
    $s .= '<tr>'
        . '<th class="span-20">Date</th>'
        . '<th class="span-80">Result</th>'
        . '</tr>';
    foreach ($games as $game) {
        $s .= gamesRow($game);
    }
    $s .= '</table>';
    return $s;
}

function gamesRow($game) {
    $s = '<tr>';
    $s .= '<td>' . q(date('F jS', $game->date())) . '</td>';
    $s .= '<td>' . gainsAndLosses($game) . '</td>';
    $s .= '</tr>';
    return $s;
}

function sortPlayers($players) {
    $sorted = array();
    foreach ($players as $player) {
        $sorted[$player->rating . ' ' . $player->name()] = $player;
    }
    krsort($sorted, SORT_NUMERIC);
    return $sorted;
}
