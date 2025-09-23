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
        neighbourhood TEXT,
        pricing INTEGER
        )
    ");

    $db->exec("CREATE TABLE IF NOT EXISTS comments(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        shop_id INTEGER,
        email TEXT NOT NULL,
        comment TEXT NOT NULL,
        created_at TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (shop_id) REFERENCES shops(id) on DELETE CASCADE
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS users(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        role TEXT NOT NULL
    )");

    echo "Database setup complete! Tables 'shops', 'comments', and 'users' are available.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>