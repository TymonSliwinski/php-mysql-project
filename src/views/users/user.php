<?php

if (isset($_SESSION['user'])) {
    $user = json_decode($_SESSION['user']);
    echo "<h1>Welcome, $user->email</h1>";
    echo "<br>";
    echo "<a href='/users?logout'>Log out</a>";
    echo "<br>";
    if (isset($_SESSION['company'])) {
        // echo `
        // <form action=
        // `;
    }
} else {
    echo "<h1>Welcome, guest</h1>";
}
?>