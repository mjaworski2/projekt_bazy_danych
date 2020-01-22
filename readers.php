<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php
getStyles();
getHeader();
?>
<div class="container-fluid">
    <div class="main">
        <a href="./addReader.php" type="button" class="btn btn-secondary btn-lg active add">Dodaj nowego czytelnika</a>
        <?php
        $allReaders = 'SELECT * FROM czytelnik';
        //$allBooks = 'SELECT * FROM availableBooks';
        //echo $allBooks;
        $result = $pdo->query($allReaders);
        foreach ($result as $reader) {
        ?>

            <div class="book">
                <div class="row">
                    <div class="col-sm-6 basicInfo">
                        <div class="names"><?php echo $reader['imie'] . " " . $reader['nazwisko'] ?></div>
                        <div class="readerAdditionalInfo"><?php echo $reader['email'] ?></div>
                        <div class="readerAdditionalInfo"><?php echo $reader['telefon'] ?></div>
                        <div class="readerAdditionalInfo">
                            <a class="links" href="./readersBooks.php?id=<?php echo $reader['id_czytelnik'] ?>">Wypożyczone książki</a>
                        </div>
                    </div>
                    <div class="col-sm-3 readerDelete">
                        <a class="btn btn-outline-danger btn-lg" href="./deleteReader.php?id=<?php echo $reader['id_czytelnik'] ?>">Usuń</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php
getFooter();
?>