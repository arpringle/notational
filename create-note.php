<?php
    $notecode = filter_input(INPUT_GET, "notecode");
    $notecode = strtoupper($notecode);
    $valid_code = preg_match("/^[A-Z0-9]{6}$/", $notecode);
?>
<!DOCTYPE html>
<html>
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
        <?php
            if($valid_code) {
        ?>
        <form id="note-editing-form" method="post" action="note-creation-page.php?notecode=<?php echo $notecode ?>">
            <button type="submit" disabled style="display: none" aria-hidden="true"></button>
            <div id="top-ui-div">
                <div id="top-ui-left-div">
                    <input
                        type="text"
                        id="note-title"
                        placeholder="Note Title"
                        name="document-title"
                        maxlength="255"
                        onblur="resetScroll(this)"
                    />
                </div>
                <div id="save-button-container-div">
                    <input type="submit" value="Create" id="save-button"/>
                </div>
            </div>
            <textarea name="document-contents" id="main-note-editor"></textarea>
        </form>
        <div id="toolbar">
            <div id="toolbar-inner-div">
                <form action="./notes.php">
                    <input type="hidden" name="notecode" value="<?php echo $notecode ?>"/>
                    <button type="submit" title="Go Back">&larr;</button>
                </form>
            </div>
        </div>
        <?php
            }

            else {
        ?>
        <div id="content-div">
                <h3>The received NoteCode was not valid.</h3>
                <br>
                <a href="./">&larr; Try Again</a>
        </div>
        <?php
            }
        ?>
    </body>
</html>