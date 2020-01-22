<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php include_once('functions.php') ?>
<?php
getStyles();
getHeader();

$readerID = $_GET['id'];
$deleteReader = "DELETE FROM czytelnik WHERE id_czytelnik = '$readerID'";

if ($pdo->query($deleteReader) === false) {
    print_r($pdo->errorInfo());
    echo "Błąd podczas usuwania użytkownika";
    die();
} else {
    successfulAction("Czytelnik usunięty!");
}

?>
<?php
getFooter();
?>