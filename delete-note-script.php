<?php
require "database-connect.php";

function delete_note($id, $notecode): void {

    $pdo = db_connect();

    $raw_sql = "DELETE FROM notes WHERE id=:id AND code=:notecode";

    $prepared_statement = $pdo->prepare($raw_sql);

    $prepared_statement->execute([
        "id" => $id,
        "notecode" => $notecode
    ]);

}
?>