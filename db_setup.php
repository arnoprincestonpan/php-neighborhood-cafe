<?php
/*
TITLE: Database Setup
FILE: db_setup.php
PURPOSE: To setup the database, assuming the server is not going to have data-filled beforehand.
*/

try {
    $db = new PDO('sqlite:database.sqlite');
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>