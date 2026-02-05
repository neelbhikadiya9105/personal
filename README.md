# personal
<?php
$host = $_SERVER["SERVER_NAME"];
$message = "Message in a Bottle";

$my_string = "";
$my_int = 42;
$my_float = -2.35;
$my_bool = false;
$my_array = [];
$my_object = date_create();
$my_null = null;

$my_array["myclass"] = 42;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>First PHP</title>
</head>
<body>

  <h2><?php echo $host; ?></h2>
  <h1>Week 5</h1>

  <?php echo "<p>" . $message . "</p>"; ?>
  <p><?php echo $message; ?></p>

  <?php
  if (is_int($my_int)) {
    echo "<p>We have a integer</p>";
    echo "<p>" . gettype($my_int) . "</p>";
  }

  echo "<p>Boolean dump:</p>";
  var_dump($my_bool);
  echo "<br>";

  echo "<p>Object dump:</p>";
  var_dump($my_object);
  echo "<br><br>";

  $my_int = (string) $my_int;

  if (is_string($my_int)) {
    echo "<p>This is a string</p>";
    echo "<p>" . gettype($my_int) . "</p>";
  }
  ?>

</body>
</html>
