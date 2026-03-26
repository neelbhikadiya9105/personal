<?php

include __DIR__ . "/../../data/DbContext.php";

$Context = new DbContext();
$Album = new Album();


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // load album from db using id from query string
    $Album = $Context->GetAlbum($_GET["id"]);
}

else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // delete album from db
    if ($Context->DeleteAlbum($_POST["hidAlbumID"])) {
        // success
        header("Location: http://proj1a/");
        exit();
    }
    else {
        $error = "POST error.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Delete</title>
</head>
<body>
    <h3>Delete Album</h3>

    <?php if (isset($error)) { echo "<p>{$error}</p>"; } ?>

    <p>Are you sure you want to delete the album: <strong><?php echo $Album->Title; ?></strong>?</p>

    <form method="post">
        <input type="hidden" name="hidAlbumID" value="<?php echo $Album->AlbumID; ?>">

        <input type="submit" value="Yes, Delete!">
    </form>

    <ul>
        <li><a href="/pages/albums/edit.php?id=<?php echo $Album->AlbumID; ?>">Cancel</a></li>
        <li><a href="/">Return to Home Page</a></li>
    </ul>
</body>
</html>
