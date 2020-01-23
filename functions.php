<?php
function displayBooks($result, $pdo, $toLend)
{
    if ($toLend === true) {
        foreach ($result as $book) {

?>
            <div class="book">
                <div class="row">
                    <div class="col-sm-6 basicInfo">
                        <div class="bookTitle"><?php echo $book['tytul'] ?></div>
                        <div class="bookAuthor">
                            <?php echo $book['autor'] . ", " . $book['rok'] ?></div>
                        <div class=" bookGenre"><?php echo $book['nazwa'] ?></div>
                        <div class="bookAdditionalInfo"><?php echo $book['wydawnictwo'] ?></div>
                        <div class="bookAdditionalInfo">ISBN: <?php echo $book['isbn'] ?></div>
                        <div class="bookAdditionalInfo">Ilość: <?php echo $book['ilosc'] ?></div>
                    </div>
                    <div class="col-sm-3 bookLend">
                        <?php
                        $ksiazkaID = $pdo->query("SELECT id_ksiazka FROM availableBooks  WHERE isbn = '" . $book['isbn'] . "' LIMIT 1")->fetch();
                        ?>
                        <a class="btn btn-outline-success btn-lg" href="<?php
                                                                        echo "./Lend.php?tytul=" . $book['tytul'] . "&autor=" . $book['autor'] . "&isbn=" . $book['isbn'] .
                                                                            "&id_ksiazka=" . $ksiazkaID['id_ksiazka']; ?>">Wypożycz</a>
                    </div>
                </div>
            </div>
        <?php

        }
    }
    if ($toLend === false) {
        foreach ($result as $book) {
        ?>
            <div class="book">
                <div class="row">
                    <div class="col-3 basicInfo">
                        <div class="bookTitle"><?php echo $book['tytul'] ?></div>
                        <div class="bookAuthor">
                            <?php echo $book['autor'] . ", " . $book['rok'] ?></div>
                        <div class=" bookGenre"><?php echo $book['nazwa'] ?></div>
                        <div class="bookAdditionalInfo"><?php echo $book['wydawnictwo'] ?></div>
                        <div class="bookAdditionalInfo">ISBN: <?php echo $book['isbn'] ?></div>
                        <div class="bookAdditionalInfo">Id: <?php echo $book['id_ksiazka'] ?></div>
                    </div>
                    <div class="col-3 basicInfo dates">
                        <div>Od: <?php echo $book['data_odbioru']?></div>
                        <div>Do: <?php echo $book['data_zwrotu']?></div>
                    </div>
                </div>
            </div>
    <?php

        }
    }
}

function successfulAction($meassage)
{
    ?>
    <div class="align-middle main">
        <div class="d-flex justify-content-center">
            <h1><?php echo $meassage ?></h1>
        </div>
        <div class="d-flex justify-content-center">
            <a href="./books.php" class="links">Wróć do dostępnych książek</a>
        </div>
        <div class="d-flex justify-content-center">
            <a href="./currentOrders.php" class="links">Przeglądaj zamówenia</a>
        </div>
        <div class="d-flex justify-content-center">
            <a href="./readers.php" class="links">Czytelnicy</a>
        </div>
    </div>
<?php
}

?>