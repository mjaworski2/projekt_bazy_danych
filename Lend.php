<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php getStyles(); ?>
<?php
getHeader();
?>
<div class="container-fluid">
    <div class="main">
        <form action="bookLended.php" method="POST">
            <div class="row">
                <div class="form-group col-12">
                    <label>Tytuł</label>
                    <input type="text" class="form-control" placeholder="Tytuł" name="tytul" value="<?php echo $_GET['tytul'] ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12">
                    <label>Autor</label>
                    <input type="text" class="form-control" placeholder="Autor" name="autor" value="<?php echo $_GET['autor'] ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label>Numer ISBN</label>
                    <input type="number" class="form-control" placeholder="ISBN" maxlength="13" name="isbn" value="<?php echo $_GET['isbn'] ?>" readonly>
                </div>
                <div class="form-group col-6">
                    <label>ID książki</label>
                    <input type="number" class="form-control" name="id_ksiazka" value="<?php echo $_GET['id_ksiazka'] ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Czytelnik</label>
                    <select required multiple class="form-control" name="id_czytelnik">
                        <?php
                        $allReaders = 'SELECT * FROM czytelnik';
                        $resultReaders = $pdo->query($allReaders);
                        print_r($resultReaders);
                        foreach ($resultReaders as $reader) {
                        ?>
                            <option><?php echo $reader['id_czytelnik'], '-', $reader['imie'], ' ', $reader['nazwisko'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Data wypożyczenia</label>
                    <input class="form-control" type="date" name="data_wypozyczenia" required value="<?php echo date("Y-m-d") ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Data zwrotu</label>
                    <input class="form-control" type="date" name="data_zwrotu" required value="<?php echo date("Y-m-d", strtotime("+1 month")) ?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    <button type="submit" class="btn btn-outline-success">Wypożycz</button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php
getFooter();
?>