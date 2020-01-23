<?php include_once('templates.php') ?>
<?php include('connect.php') ?>
<?php
getStyles();
getHeader();

$allOrders = "SELECT * FROM zamowienie JOIN ksiazka USING(id_ksiazka) JOIN czytelnik USING(id_czytelnik) WHERE czy_zwrocona is false";
$result = $pdo->query($allOrders);
?>
<div class="container-fluid">
    <div class="main">
    <?php
    foreach ($result as $order) {
    ?>
        <div class="row">
            <div class="col-2 basicInfo">
                <div class="bookTitle"><?php echo $order['tytul'] ?></div>
                <div class="bookAuthor">
                    <?php echo $order['autor'] . ", " . $order['rok'] ?></div>
                <div class="bookAdditionalInfo">ID: <?php echo $order['id_ksiazka'] ?></div>
                <div class="bookAdditionalInfo">ISBN: <?php echo $order['isbn'] ?></div>
            </div>
            <div class="col-2 basicInfo">
                <div class="bookTitle">Czytelnik:</div>
                <div class="bookAdditionalInfo"><?php echo $order['imie'] . " " . $order['nazwisko'] ?></div>
                <div class="bookAdditionalInfo">ID: <?php echo $order['id_czytelnik'] ?></div>
            </div>
            <div class="col-2 basicInfo">
                <div class="bookTitle">Wypożyczone:</div>
                <div class="bookAdditionalInfo">Od: <?php echo $order['data_odbioru'] ?></div>
                <div class="bookAdditionalInfo">Do: <?php echo $order['data_zwrotu'] ?></div>
            </div>
             <div class="col-2 basicInfo">
                <a class="btn btn-outline-danger btn-lg" href="./giveBackBook.php?id_zamowienie=<?php echo $order['id_zamowienie'] ?>">Oddaj ksiazke</a>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?php
getFooter();
?>