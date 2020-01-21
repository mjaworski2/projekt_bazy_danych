    <?php
    include_once('templates.php');
    include_once('connect.php');
    include_once('functions.php');
    ?>
    <?php getStyles(); ?>
    <?php
    getHeader();
    ?> <div class="container-fluid">
        <div class="main">
            <?php
            $searchedBooks = 'SELECT tytul, autor, rok, nazwa, wydawnictwo, isbn, count (tytul) as "ilosc" FROM availableBooks JOIN kategorie USING(id_kategoria)';

            $firstCondition = true;

            if (isset($_GET["tytul"]) && !empty($_GET["tytul"]))
                if ($firstCondition == true) {
                    $searchedBooks .= " WHERE tytul='" . $_GET["tytul"] . "'";
                    $firstCondition = false;
                } else {
                    $searchedBooks .= " AND tytul='" . $_GET["tytul"] . "'";
                }

            if (isset($_GET["rok"]) && !empty($_GET["rok"]))
                if ($firstCondition == true) {
                    $searchedBooks .= " WHERE rok='" . $_GET["rok"] . "'";
                    $firstCondition = false;
                } else
                    $searchedBooks .= " AND rok='" . $_GET["rok"] . "'";

            if (isset($_GET["autor"]) && !empty($_GET["autor"]))
                if ($firstCondition == true) {
                    $searchedBooks .= " WHERE autor='" . $_GET["autor"] . "'";
                    $firstCondition = false;
                } else
                    $searchedBooks .= " AND autor='" . $_GET["autor"] . "'";

            if (isset($_GET["kategoria"]) && !empty($_GET["kategoria"]))
                if ($firstCondition == true) {
                    $searchedBooks .= " WHERE nazwa='" . $_GET["kategoria"] . "'";
                    $firstCondition = false;
                } else
                    $searchedBooks .= " AND nazwa='" . $_GET["kategoria"] . "'";

            if (isset($_GET["wydawnictwo"]) && !empty($_GET["wydawnictwo"]))
                if ($firstCondition == true) {
                    $searchedBooks .= " WHERE wydawnictwo='" . $_GET["wydawnictwo"] . "'";
                    $firstCondition = false;
                } else
                    $searchedBooks .= " AND wydawnictwo='" . $_GET["wydawnictwo"] . "'";

            if (isset($_GET["isbn"]) && !empty($_GET["isbn"]))
                if ($firstCondition == true) {
                    $searchedBooks .= " WHERE isbn='" . $_GET["isbn"] . "'";
                    $firstCondition = false;
                } else
                    $searchedBooks .= " AND isbn='" . $_GET["isbn"] . "'";

            $searchedBooks .= ' GROUP BY tytul, autor, rok, nazwa, wydawnictwo, isbn, 
            availableBooks.id_kategoria, kategorie.id_kategoria ORDER BY tytul';
            //echo $searchedBooks;
            $result = $pdo->query($searchedBooks);
            if (is_null($result)) { ?>
                <h1><?php echo ("Brak rezultatów"); ?></h1>
                brak
            <?php
            } else {
                displayBooks($result, $pdo);
            }
            ?>
        </div>
    </div>
    <?php
    getFooter();
    ?>