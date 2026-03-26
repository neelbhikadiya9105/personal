<?php

include __DIR__ . "/../../data/DbContext.php";

$Album = new Album();
$Context = new DbContext();
$ListOfBands = array();


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $ListOfBands = $Context->GetAllBands();

    if (count($ListOfBands) == 0) {
        $error = "No Bands in Database";
    }
}

else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // input validation
    if (empty(trim($_POST["txtTitle"])) || empty(trim($_POST["txtReleaseDate"]))) {
        $error = "Name and Release Date Required.";
    }

    // if valid, attempt to create band
    if (!isset($error)) {
        // map values from POST to Album
        $Album->Title = trim($_POST["txtTitle"]);
        $Album->ReleaseDate = $_POST["txtReleaseDate"];
        $Album->BandID = $_POST["ddlBandID"];

        if ($Context->CreateAlbum($Album)) {
            header("Location: http://proj1a/");
            exit();
        }
        else {
            $error = "POST error.";
        }
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
    <title>Album Create</title>
</head>
<body>
    <h3>Create a New Album</h3>

    <?php if (isset($error)) { echo "<p>{$error}</p>"; } ?>

    <form method="post">
        <label for="txtTitle">Title</label>
        <input type="text" id="txtTitle" name="txtTitle" value="">
        <br>

        <label for="txtReleaseDate">Release Date</label>
        <input type="date" id="txtReleaseDate" name="txtReleaseDate" value="">
        <br>

        <label for="ddlBandID">Band</label>
        <select id="ddlBandID" name="ddlBandID">
            <?php
                foreach ($ListOfBands as $b) {
                    echo "<option value=\"{$b->BandID}\">{$b->Name}</option>";
                }
            ?>
        </select>

        <input type="submit" value="Create!">
    </form>

    <ul>
        <li><a href="/">Return to Home Page</a></li>
    </ul>
</body>
</html>