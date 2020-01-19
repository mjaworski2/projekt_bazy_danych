<?php 
function displayBooks($result, $pdo){
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
                        $ksiazkaID = $pdo->query("SELECT id_ksiazka FROM ksiazka WHERE isbn = '" . $book['isbn'] . "' LIMIT 1")->fetch();
                        ?>
                        <a class="btn btn-outline-success btn-lg" href="<?php
                                echo "./Lend.php?tytul=" . $book['tytul'] . "&autor=" . $book['autor'] . "&isbn=" . $book['isbn'] .
                                        "&id_ksiazka=" . $ksiazkaID['id_ksiazka']; ?>">Lend</a>
                    </div>
                </div>
            </div>
        <?php }
}

?>