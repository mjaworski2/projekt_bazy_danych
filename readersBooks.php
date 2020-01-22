<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php include_once('functions.php'); ?>
<?php
getStyles();
getHeader();

$readerID = $_GET['id'];
$allReadersBooks = "SELECT id_ksiazka, tytul, autor, rok, nazwa, wydawnictwo, isbn, data_odbioru, data_zwrotu FROM ksiazka 
            JOIN kategorie USING(id_kategoria) JOIN zamowienie USING(id_ksiazka) WHERE id_czytelnik = $readerID AND data_zwrotu > CURRENT_DATE::date";

$result = $pdo->query($allReadersBooks);
?>
<div class="container-fluid">
    <div class="main">
        <?php
        displayBooks($result, $pdo, false);
        ?>
    </div>
</div>
<?php
getFooter();
?>