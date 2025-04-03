<!DOCTYPE html>
<?php
    require "fetch-notes.php";
    require "edit-note-script.php";
    require "delete-note.php";

    $delete_request = filter_input(INPUT_POST, "delete", FILTER_VALIDATE_BOOL);

    $notecode = filter_input(INPUT_GET, "notecode");
    $notecode = strtoupper($notecode);
    $valid_code = preg_match("/^[A-Z0-9]{6}$/", $notecode);
    
    $id = filter_input(INPUT_GET, "note_id", FILTER_VALIDATE_INT);

    $new_title = filter_input(INPUT_POST, "document-title");
    if ($new_title == false) {$new_title = "Untitled Document";};

    $new_contents = filter_input(INPUT_POST, "document-contents");

    $note = false;
    $delete_success = false;

    if($valid_code && $id){

        try {

            if ($delete_request) {
                delete_note($id, $notecode);
                $delete_success = true;
            }
    

            else {

                if (($new_contents) && strlen($new_title) < 256) {
                    update_note(
                        $id,
                        $new_title, 
                        $new_contents, 
                        $notecode
                    );
                    
                }

                $note = fetch_note($notecode, $id);

                $created_timestamp = strtotime( $note["created_at"]);
                $modified_timestamp = strtotime( $note["modified_at"]);

                $created_datestring = date('m/d/y, g:i A', $created_timestamp );
                $modified_datestring = date('m/d/y, g:i A', $modified_timestamp);
            }
        }
        
        catch (\Throwable $database_exception) {

        }
    }
?>
<html lang="en">
    <head>
        <title>Notational</title>
        <link rel="stylesheet" href="./styles/styles.css"/>
        <link rel="stylesheet" href="./styles/note-editor.css"/>
        <script>
            function resetScroll(input) {
                setTimeout(() => {
                    input.scrollLeft = 0; // Reset to the beginning
                }, 0);
            }
        </script>
    </head>
    <body>
        <?php if($note) { ?>
            <form id="note-editing-form" method="post">
                <button type="submit" disabled style="display: none" aria-hidden="true"></button>
                <div id="top-ui-div">
                    <div id="top-ui-left-div">
                        <input
                            type="text" 
                            value="<?php echo $note["title"]?>"
                            id="note-title"
                            placeholder="Note Title"
                            name="document-title"
                            onblur="resetScroll(this)"
                        />
                    </div>
                    <div id="time-div">
                        <div>
                            <p class="small">Note Created: <?php echo $created_datestring ?></p>
                            <p class="small">Last Modified: <?php echo $modified_datestring ?></p>
                        </div>
                        <input type="submit" value="Save" id="save-button"/>
                    </div>
                </div>
                <textarea name="document-contents" id="main-note-editor"><?php echo $note["contents"] ?></textarea>
            </form>
            <div id="toolbar">
                <div id="toolbar-inner-div">
                    <form action="./notes.php">
                        <input type="hidden" name="notecode" value="<?php echo $notecode ?>"/>
                        <button type="submit" title="Go Back">&larr;</button>
                    </form>
                    <form method="post">
                        <input type="hidden" name="notecode" value="<?php echo $notecode ?>"/>
                        <input type="hidden" name="id" value="<?php echo $id ?>"/>
                        <input type="hidden" name="delete" value="true"/>
                        <button type="submit"><img src="./assets/trash-can.svg" title="Delete this Note"/></button>
                    </form>
                </div>
            </div>
        <?php
            }

            elseif($delete_success) {
        ?>
            <div id="content-div">
                <h3>The note has been deleted.</h3>
                <br>
                <a href="./notes.php?notecode=<?php echo $notecode?>">&larr; Back to Notes</a>
            </div>
        <?php
            }

            else {
        ?>
            <div id="content-div">
                <h3>The received NoteCode and/or ID was not valid.</h3>
                <br>
                <a href="./">&larr; Try Again</a>
            </div>
        <?php
            }
        ?>
    </body>
</html>
