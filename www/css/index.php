<?php

require_once(dirname(__FILE__) . '/../../darts.php');

header('Content-type: text/css');

?>

body {
    background-image: url(<?= u('/img/darts.jpg') ?>);
    background-position: center top;
    background-repeat: no-repeat;
    background-size: 100%;
}

.content {
    background-color: #000;
    margin-bottom: 4em;
    margin-top: 2em;
    opacity: 0.7;
    border: 1px white solid;
}

table {
    width: 100%;
}

tr {
    height: 2.8em;
}

th {
    text-align: left;
}

<?php
for ($i = 5; $i <= 100; $i += 5) {
    ?>
    .span-<?= $i ?> {
        width: <?= $i ?>%;
    }
    <?php
}
?>

/* Numbers in tables. */
.n {
    text-align: right;
}


/* Clearfix */
clearfix:after {
    content:"";
    display:table;
    clear:both;
}

/* Game Input Page */

a.player, a.winner {
    display: block;
}

.selected {
    color: red;
}

.selector .winner {
    color: #666;
    float: left;
    visibility: hidden;
}

.selector.selected .winner {
    visibility: visible;
}

.selector.selected .winner.selected {
    color: #f00;
}

.submit-game {
    visibility: hidden;
}

.submit-game a {
    color: #fff;
    padding: 1em;
}
