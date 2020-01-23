<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php include_once('functions.php') ?>
<?php
getStyles();
getHeader();

$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$email = $_POST['email'];
$telefon = $_POST['telefon'];

$addReader = "INSERT INTO czytelnik (imie, nazwisko, telefon, email) VALUES ('" . $imie . "', '" . $nazwisko . "', '"
    . $email . "', '" . $telefon . "')";
if ($pdo->exec($addReader) === false) {
    print_r($pdo->errorInfo());
    echo "Error while inserting to db";
    die();
} else {
    successfulAction("Czytelnik dodany!");
};
getFooter();
?>