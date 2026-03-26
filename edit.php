<?php

include __DIR__ . "/../../data/DbContext.php";

$Context = new DbContext();
$Band = new Band();


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // load band from db using id from query string
    $Band = $Context->GetBand($_GET["id"]);
}

else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // input validation
    if (empty(trim($_POST["txtName"]))) {
        $error = "Name required.";
    }

    if (!isset($error)) {
        // get POST data from form
        $Band->BandID = $_POST["hidBandID"];
        $Band->Name = trim($_POST["txtName"]);

        // update band in db
        if ($Context->UpdateBand($Band)) {
            // success
            header("Location: http://proj1a/");
            exit();
        }
        else {
            $error = "POST error.";
        }
    }
    else {
        // reload band so form keeps values
        $Band->BandID = $_POST["hidBandID"];
        $Band->Name = trim($_POST["txtName"]);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Band Edit</title>
</head>
<body>
    <h3>Edit Band</h3>

    <?php if (isset($error)) { echo "<p>{$error}</p>"; } ?>

    <form method="post">
        <input type="hidden" name="hidBandID" value="<?php echo $Band->BandID; ?>">

        <label for="txtName">Name</label>
        <input type="text" id="txtName" name="txtName" value="<?php echo $Band->Name; ?>">
        <br>

        <input type="submit" value="Save!">
    </form>

    <ul>
        <li><a href="/pages/bands/delete.php?id=<?php echo $Band->BandID; ?>">Delete this Band</a></li>
        <li><a href="/">Return to Home Page</a></li>
    </ul>
</body>
</html>
