<?php

require_once(dirname(__FILE__) . '/../darts.php');;
require_once(COMMON . '/header-footer.php');
require_once(COMMON . '/results.php');
require_once(COMMON . '/table.php');

function main() {
    $s = head();
    $s .= body();
    $s .= foot();
    echo $s;
}

function body() {
    $s = '';
    $s .= '<h2>Standings</h2>';
    $s .= standingsTable(standings());
    $s .= '<h2>Games</h2>';
    $s .= gamesTable(games());
    return $s;
}

main();
