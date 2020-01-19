<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php getStyles(); ?>
<?php
getHeader();
?>
<div class="container-fluid">
    <div class="main">
        <form action="search_result.php" method="GET">
            <div class="form-group">
                <label>Tytuł</label>
                <input type="text" class="form-control" placeholder="Tytuł" name="tytul">
            </div>
            <div class="form-group">
                <label>Autor</label>
                <input type="text" class="form-control" placeholder="Autor" name="autor">
            </div>
            <div class="row">

                <div class="form-group col-sm-3">
                    <label>Kategoria</label>
                    <select multiple class="form-control" name="kategoria">
                        <?php
                        $allCategories = 'SELECT nazwa FROM kategorie';
                        $resultCategories = $pdo->query($allCategories);
                        print_r($resultCategories);
                        foreach ($resultCategories as $category) {
                        ?>
                            <option><?php echo $category['nazwa'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group"></div>

                <div class="form-group col-sm-3">
                    <label>Rok wydania</label>
                    <input type="number" class="form-control" max="2020" min="1800" placeholder="rok" name="rok">
                </div>
                <div class="form-group col-sm-3">
                    <label for="">Wydawnictwo</label>
                    <input type="text" class="form-control" placeholder="Wydawnictwo" name="wydawnictwo">
                </div>
                <div class="form-group col-sm-3">
                    <label>Numer ISBN</label>
                    <input type="number" class="form-control" placeholder="ISBN" maxlength="13" name="isbn">
                </div>
            </div>
            <button type="submit" class="btn btn-outline-success">Search for books</button>
        </form>
    </div>
</div>


<?php
getFooter();
?>