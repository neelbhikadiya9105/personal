<?php

include __DIR__ . "/data/DbContext.php";

$Context = new DbContext();
$ListOfAlbumBands = array();
$search = "";

if (isset($_GET["txtSearch"])) {
    $search = trim($_GET["txtSearch"]);
    $ListOfAlbumBands = $Context->GetAlbumsAndBands($search);
}
else {
    $ListOfAlbumBands = $Context->GetAlbumsAndBands();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project 1 - Record Collection</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive;
            background-color: burlywood;
        }
    </style>
</head>
<body>
    <h1>Record Collection</h1>

    <h3>Links:</h3>
    <ul>
        <li><a href="/pages/bands/create.php">Create Band</a></li>
        <li><a href="/pages/albums/create.php">Create Album</a></li>
    </ul>

    <h3>Search:</h3>
    <form method="get" action="/">
        <label for="txtSearch">Search string:</label>
        <input type="text" id="txtSearch" name="txtSearch" value="<?php echo $search; ?>">
        <input type="submit" value="Search!">
    </form>

    <h3>Results:</h3>
    <table>
        <tr>
            <th>Band</th>
            <th>Year</th>
            <th>Album</th>
        </tr>
        <?php foreach ($ListOfAlbumBands as $ab) { ?>
        <tr>
            <td><a href="/pages/bands/edit.php?id=<?php echo $ab->BandID; ?>"><?php echo $ab->Name; ?></a></td>
            <td><?php echo substr($ab->ReleaseDate, 0, 4); ?></td>
            <td><a href="/pages/albums/edit.php?id=<?php echo $ab->AlbumID; ?>"><?php echo $ab->Title; ?></a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
