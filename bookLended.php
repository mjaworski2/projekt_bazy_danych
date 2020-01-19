<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php
getHeader();

$czytelnikID = substr($_POST['id_czytelnik'], 0, 1);
$ksiazkaID = $_POST['id_ksiazka'];
$odbior = $_POST['data_wypozyczenia'];
$zwrot = $_POST['data_zwrotu'];


if ($odbior < $zwrot) {
    $lendBook = "INSERT INTO zamowienie (id_czytelnik, id_ksiazka, data_odbioru, data_zwrotu) VALUES ('" . $czytelnikID . "', '" . $ksiazkaID . "', '"
        . $odbior . "', '" . $zwrot . "')";
    $insert = $pdo->query($lendBook);
    echo $insert;
} else {
?>
    <h1>Niepoprawne daty</h1>
<?php
}

getFooter();
?>