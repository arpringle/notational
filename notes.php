<!DOCTYPE html>
<?php
    require "fetch-notes.php";
    require "stringhelpers.php";

    $notecode = filter_input(INPUT_GET, "notecode");
    $notecode = strtoupper($notecode);
    $valid_code = preg_match("/^[A-Z0-9]{6}$/", $notecode);   

    $notes = false;
    $database_exception = false;

    if($valid_code){

        try {
            $notes = fetch_notes($notecode);
        }

        catch (\Throwable $database_exception) {
            
        }
    }
?>
<html lang="en">
    <head>
        <title>Notational</title>
        <link rel="stylesheet" href="./styles/styles.css"/>
        <link rel="stylesheet" href="./styles/notes.css"/>
    </head>
    <body>
        <main>
            <?php
                // IF NOTECODE IS INVALID, DISPLAY THE FOLLOWING
                if (!$valid_code) {
            ?>

            <div id="content-div"">
                <h3>Sorry, the given NoteCode is invalid.</h3>
                <br>
                <a href="./">&larr; Try Again?</a>
            </div>

            <?php        
                }
            ?>

            <?php
                // IF THE DB CONNECTION FAILS, DISPLAY THE FOLLOWING
                if ($database_exception) {
            ?>
            <div id="content-div">
                <h3>There was an error connecting to the database.</h3>
                <p>(If you are the system administrator, check your config)</p>
                <br>
                <a href="./">&larr; Try Again?</a>
            </div>
            <?php
                }
            ?>

            
            <?php
                // IF CODE IS VALID BUT THERE ARE NO NOTES, DISPLAY THE FOLLOWING
                if (is_array($notes)) {
                    if (count($notes) === 0) {
            ?>
            <h1 id="notecode-header">{<?php echo $notecode ?>}</h1>
            <div id="content-div">
                <h3>There have been no notes written under this NoteCode yet!</h3>
                <br>
                <a href="./create-note.php?notecode=<?php echo $notecode?>">Author a New Note</a>
                <br>
                <br>
                <a href="./">&larr; Go Back</a>
            </div>
            <?php
                    }
                }
            ?>

            
            <?php
                //IF THERE ARE NO ERRORS AND NOTES EXIST, DISPLAY THE FOLLOWING
                if (is_array($notes)) {
                    if (count($notes) > 0) {      
            ?>
            <h1 id="notecode-header">{<?php echo $notecode ?>}</h1>
            <h3>Notes for the above-listed NoteCode:</h3>
            <div id="notes-grid">
                <?php
                        foreach ($notes as $note) {
                ?>
                <a 
                    class="notes-tile-link" 
                    href="./edit-note.php?note_id=<?php
                        echo $note["id"] . "&notecode=" . $notecode
                    ?>"
                >
                    <div class="notes-tile">
                        <h3><?php echo $note["title"]?></h3>
                        <p><?php echo ellipsize($note["contents"]) ?></p>
                    </div>
                </a>
            <?php
                        }
            ?>
                <a class="notes-tile-link" href="./create-note.php?notecode=<?php echo $notecode?>">
                    <div class="notes-tile">
                        <h3>Write a New Note</h3>
                        <img src="./assets/plus.svg"/>
                    </div>
                </a>
            </div>
            <?php
                    }
                }
            ?>
        </main>
    </body>
</html>