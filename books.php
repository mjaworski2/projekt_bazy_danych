    <?php include_once('templates.php');
    include_once('connect.php');
    include_once('functions.php');
    getStyles();
    getHeader();
    ?> <div class="container-fluid">
        <div class="main">
            <?php
            $allBooks = 'SELECT tytul, autor, rok, nazwa, wydawnictwo, isbn, count(tytul) as "ilosc" from ksiazka JOIN kategorie USING(id_kategoria) GROUP BY tytul, autor, rok, nazwa, wydawnictwo, isbn, 
            ksiazka.id_kategoria, kategorie.id_kategoria ORDER BY tytul';
            $result = $pdo->query($allBooks);
            //$result = [['tytul' => 'Tytuł', 'autor' => 'Jakub Tkacz', 'rok' => '1998']];
            displayBooks($result, $pdo);
            ?>
        </div>
    </div>
    <?php
    getFooter();
    ?>