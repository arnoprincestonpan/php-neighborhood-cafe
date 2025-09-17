<?php
/*
TITLE: Database Setup
FILE: db_setup.php
PURPOSE: To setup the database, assuming the server is not going to have data-filled beforehand.
*/

try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("CREATE TABLE IF NOT EXISTS shops(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        address TEXT NOT NULL,
        rating REAL,
        hours_open TEXT,
        food_availability TEXT,
        image_link TEXT,
        neighbourhood TEXT
        )
    ");

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>