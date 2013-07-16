<?php

require_once(dirname(__FILE__) . '/../../darts.php');;
require_once(COMMON . '/header-footer.php');;


function main() {
    $s = head();
    if (isset($_POST['name'])) {
        $s .= addUser($_POST['name']);
    } else {
        $s .= addUserForm();
    }
    $s .= foot();
    echo $s;
}

function addUserForm() {
    ob_start();
    ?>
    <form method="post">
        <label for="name">Name</label>
        <input type="text" name="name"/>
    </form>
    <?php
    return ob_get_clean();
}

function addUser($name) {
    $sql = 'INSERT INTO player (name) VALUES (' . s($name) . ')';
    ddb($sql);
    return '<p>' . q($name) . ' added.</p>';
}

main();

