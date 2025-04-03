<?php

function update_note($id, $title, $contents, $notecode): void {

// Fetch the config values; if, for some reason, they are not available, terminate immediately.
$config = require ('config.php');
if (!$config) {die;};

$pdo = new PDO(
    "mysql:host=".$config["db_host"].";dbname=".$config["db_name"],
    $config["db_user"],
    $config["db_pass"]);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$raw_sql = "UPDATE notes SET

                title = :title,
                contents = :contents,
                modified_at = current_timestamp()
            
            WHERE id=:id AND code=:notecode";

$prepared_statement = $pdo->prepare($raw_sql);

$prepared_statement->execute([
    "title" => htmlspecialchars($title),
    "contents" => htmlspecialchars($contents),
    "id" => $id,
    "notecode" => $notecode
]);

}
?>