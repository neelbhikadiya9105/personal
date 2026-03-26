<?php

include __DIR__ . "/../../data/DbContext.php";

$Context = new DbContext();
$Band = new Band();


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // load band from db using id from query string
    $Band = $Context->GetBand($_GET["id"]);
}

else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // delete band from db
    if ($Context->DeleteBand($_POST["hidBandID"])) {
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
    <title>Band Delete</title>
</head>
<body>
    <h3>Delete Band</h3>

    <?php if (isset($error)) { echo "<p>{$error}</p>"; } ?>

    <p>Are you sure you want to delete the band: <strong><?php echo $Band->Name; ?></strong>?</p>

    <form method="post">
        <input type="hidden" name="hidBandID" value="<?php echo $Band->BandID; ?>">

        <input type="submit" value="Yes, Delete!">
    </form>

    <ul>
        <li><a href="/pages/bands/edit.php?id=<?php echo $Band->BandID; ?>">Cancel</a></li>
        <li><a href="/">Return to Home Page</a></li>
    </ul>
</body>
</html>
