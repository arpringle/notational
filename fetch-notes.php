<?php
require "database-connect.php";

// Function to fetch all notes for a NoteCode
function fetch_notes($notecode): array {

    $pdo = db_connect();

    $raw_sql = "SELECT * FROM notes WHERE code=:notecode";
    $prepared_statement = $pdo->prepare($raw_sql);
    $prepared_statement->execute(["notecode" => $notecode]);
    $notes = $prepared_statement->fetchAll();

    return $notes;
}


// Function to fetch one note by its NoteCode and ID
function fetch_note($notecode, $id): array {

    $pdo = db_connect();

    $raw_sql = "SELECT * FROM notes WHERE code=:notecode AND id=:id";
    $prepared_statement = $pdo->prepare($raw_sql);
    $prepared_statement->execute(["notecode" => $notecode, "id" => $id]);
    $note = $prepared_statement->fetch();

    return $note;
}
?>