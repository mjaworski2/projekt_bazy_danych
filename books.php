    <?php include_once('templates.php');
    include_once('connect.php');
    include_once('functions.php');
    getStyles();
    getHeader();
    ?> <div class="container-fluid">
        <div class="main">
            <?php
            $allBooks = 'SELECT tytul, autor, rok, nazwa, wydawnictwo, isbn, count(tytul) as ilosc from availableBooks 
            JOIN kategorie USING(id_kategoria) GROUP BY tytul, autor, rok, nazwa, wydawnictwo, isbn, 
            availableBooks.id_kategoria, kategorie.id_kategoria ORDER BY tytul';
            //$allBooks = 'SELECT * FROM availableBooks';
            //echo $allBooks;
            $result = $pdo->query($allBooks);
            displayBooks($result, $pdo);
            ?>
        </div>
    </div>
    <?php
    getFooter();
    ?>