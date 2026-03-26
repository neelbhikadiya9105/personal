<?php

include __DIR__ . "/../../data/DbContext.php";

$Context = new DbContext();
$Album = new Album();
$ListOfBands = array();


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // load album from db using id from query string
    $Album = $Context->GetAlbum($_GET["id"]);
    $ListOfBands = $Context->GetAllBands();

    if (count($ListOfBands) == 0) {
        $error = "No Bands in Database.";
    }
}

else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // input validation
    if (empty(trim($_POST["txtTitle"])) || empty(trim($_POST["txtReleaseDate"]))) {
        $error = "Title and Release Date required.";
    }

    if (!isset($error)) {
        // get POST data from form
        $Album->AlbumID = $_POST["hidAlbumID"];
        $Album->Title = trim($_POST["txtTitle"]);
        $Album->ReleaseDate = $_POST["txtReleaseDate"];
        $Album->BandID = $_POST["ddlBandID"];

        // update album in db
        if ($Context->UpdateAlbum($Album)) {
            // success
            header("Location: http://proj1a/");
            exit();
        }
        else {
            $error = "POST error.";
        }
    }
    else {
        // reload album values and band list so form keeps values
        $Album->AlbumID = $_POST["hidAlbumID"];
        $Album->Title = trim($_POST["txtTitle"]);
        $Album->ReleaseDate = $_POST["txtReleaseDate"];
        $Album->BandID = $_POST["ddlBandID"];
    }

    // if invalid, load list of bands again:
    $ListOfBands = $Context->GetAllBands();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Edit</title>
</head>
<body>
    <h3>Edit Album</h3>

    <?php if (isset($error)) { echo "<p>{$error}</p>"; } ?>

    <form method="post">
        <input type="hidden" name="hidAlbumID" value="<?php echo $Album->AlbumID; ?>">

        <label for="txtTitle">Title</label>
        <input type="text" id="txtTitle" name="txtTitle" value="<?php echo $Album->Title; ?>">
        <br>

        <label for="txtReleaseDate">Release Date</label>
        <input type="date" id="txtReleaseDate" name="txtReleaseDate" value="<?php echo $Album->ReleaseDate; ?>">
        <br>

        <label for="ddlBandID">Band</label>
        <select id="ddlBandID" name="ddlBandID">
            <?php
                foreach ($ListOfBands as $b) {
                    $selected = ($b->BandID == $Album->BandID) ? "selected" : "";
                    echo "<option value=\"{$b->BandID}\" {$selected}>{$b->Name}</option>";
                }
            ?>
        </select>

        <input type="submit" value="Save!">
    </form>

    <ul>
        <li><a href="/pages/albums/delete.php?id=<?php echo $Album->AlbumID; ?>">Delete this Album</a></li>
        <li><a href="/">Return to Home Page</a></li>
    </ul>
</body>
</html>
