<?php

include __DIR__ . "/../../data/DbContext.php";

$Context = new DbContext();
$Band = new Band();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // input validation
    if (empty(trim($_POST["txtName"]))) {
        $error = "Name required";
    }

    if (!isset($error)) {
        // get POST data from form
        $Band->Name = trim($_POST["txtName"]);

        // insert band into db
        if ($Context->CreateBand($Band)) {
            // success
            header("Location: http://proj1a/"); // redirect to home page
            exit();
        }
        else {
            $error = "POST error.";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Band Create</title>
</head>
<body>
    <h3>Create a New Band</h3>

    <?php if (isset($error)) { echo "<p>{$error}</p>"; } ?>

    <form method="post">
        <label for="txtName">Name</label>
        <input type="text" id="txtName" name="txtName" value="">
        <br>

        <input type="submit" value="Create!">
    </form>

    <ul>
        <li><a href="/">Return to Home Page</a></li>
    </ul>
</body>
</html>