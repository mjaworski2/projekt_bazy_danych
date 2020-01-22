<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php include_once('functions.php') ?>
<?php
getStyles();
getHeader();

$czytelnikID = substr($_POST['id_czytelnik'], 0, 1);
$ksiazkaID = $_POST['id_ksiazka'];
$odbior = $_POST['data_wypozyczenia'];
$zwrot = $_POST['data_zwrotu'];


if ($odbior < $zwrot) {
    $lendBook = "INSERT INTO zamowienie (id_czytelnik, id_ksiazka, data_odbioru, data_zwrotu) VALUES ('" . $czytelnikID . "', '" . $ksiazkaID . "', '"
        . $odbior . "', '" . $zwrot . "')";
    echo $lendBook;
    if ($pdo->exec($lendBook) === false) {
        print_r($pdo->errorInfo());
        echo "Error while inserting to db";
        die();
    } else {
        successfulAction("Książka wypożyczona!");
    };
} else {
?>
    <h1>Niepoprawne daty</h1>
<?php
}

getFooter();
?>