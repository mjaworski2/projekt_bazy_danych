<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php include_once('functions.php') ?>
<?php
getStyles();
getHeader();

$orderID = $_GET['id_zamowienie'];
$updateOrder = "UPDATE zamowienie SET czy_zwrocona='true', data_zwrotu=current_date WHERE id_zamowienie = '$orderID'";

if ($pdo->query($updateOrder) === false) {
    print_r($pdo->errorInfo());
    echo "Błąd podczas oddawania ksiazki";
    die();
} else {
    successfulAction("Ksiazka zostala oddana");
}

?>
<?php
getFooter();
?>