<?php include_once('templates.php') ?>
<?php include_once('connect.php') ?>
<?php include_once('functions.php') ?>
<?php
getStyles();
getHeader();
?>

<div class="container-fluid">
    <div class="main">
        <form action="readerAdded.php" method="POST">
            <div class="row">
                <div class="form-group col-6">
                    <label>Imię</label>
                    <input type="text" class="form-control" placeholder="Imię" name="imie" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label>Nazwisko</label>
                    <input type="text" class="form-control" placeholder="Nazwisko" name="nazwisko" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    <label>Email</label>
                   <input type="email" class="form-control" placeholder="czytelnik@example.com" name="email" required>
                </div>
                <div class="form-group"></div>

                <div class="form-group col-sm-3">
                    <label>Telefon</label>
                    <input type="tel" class="form-control" placeholder="telefon" name="telefon" required>
                </div>
                
            </div>
            <button type="submit" class="btn btn-outline-success">Dodaj</button>
        </form>
    </div>
</div>

<?php
getFooter();
?>