<?php
require "database-connect.php";


// Function to add a new note to the database
function add_note($notecode, $title, $contents): array {

$pdo = db_connect();

$raw_sql = "INSERT INTO notes (code, title, contents) VALUES (
            :code,
            :title,
            :contents
        );";

$prepared_statement = $pdo->prepare($raw_sql);

echo $notecode;

$prepared_statement->execute([
    "title" => htmlspecialchars($title),
    "contents" => htmlspecialchars($contents),
    "code" => $notecode
]);

return ["id" => $pdo->lastInsertId(), "code" => $notecode] ;

}
?>