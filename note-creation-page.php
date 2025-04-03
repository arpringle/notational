<?php
    require "add-note.php";

    $notecode = filter_input(INPUT_GET, "notecode");
    $notecode = strtoupper($notecode);
    $valid_code = preg_match("/^[A-Z0-9]{6}$/", $notecode);
    
    $note_title = filter_input(INPUT_POST, "document-title");
    if ($note_title == false) {$note_title = "Untitled Document";};
    $note_contents = filter_input(INPUT_POST, "document-contents");

    if ($valid_code) {
        $note = add_note($notecode, $note_title, $note_contents);
        header("Location: ./edit-note.php" . "?notecode=" . $note["code"] . "&note_id=" . $note["id"]);
        die();
    }

    else {
        header("Location: ./");
        die();
    }
?>