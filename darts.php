<?php

date_default_timezone_set('Europe/London');

require_once(dirname(__FILE__) . '/darts-config.php');

define('WWW', ROOT . '/www');
define('COMMON', ROOT . '/common');
define('LIB', ROOT . '/lib');
define('MODELS', ROOT . '/models');

require_once(LIB . '/db.php');

define('INITIAL_RATING', 100);
define('GAME_VALUE', 20);
define('MINIMUM_RATING', 1);

function q($s) {
    return htmlentities($s);
}

function s($s) {
    if (is_numeric($s)) {
        return (int) $s;
    }
    return "'" . addslashes($s) . "'";
}

function u($path, $absolute = false) {
    if ($path === true) {
        $url = $_SERVER['REQUEST_URI'];
    } else {
        $url = WWW_DIR . $path;
    }
    if ($absolute) {
        $url = 'http'
            . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on" ? 's' : '')
            . '://' . $_SERVER['SERVER_NAME'] . $url;
    }
    return $url;
}

function ddb($sql) {
    return db($sql, DB_DB, DB_HOST, DB_USR, DB_PWD, DB_DB);
}

function dStartTransaction() {
    return start_transaction(DB_DB, DB_HOST, DB_USR, DB_PWD, DB_DB);
}

function gainsAndLosses($game) {
    $s = q($game->winner()->name()) . ' +' . $game->change($game->winner()) . ', ';
    foreach ($game->losers() as $loser) {
        $s .= q($loser->name()) . ' ' . $game->change($loser) . ', ';
    }
    return chop($s, ', ');
}
