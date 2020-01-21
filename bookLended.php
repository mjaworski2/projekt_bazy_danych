<?php include_once('templates.php') ?>
<?php
getStyles();
getHeader();
?>
<div class="align-middle main">
    <div class="d-flex justify-content-center">
        <h1>Książka wypożyczona!</h1>
    </div>
    <div class="d-flex justify-content-center">
        <a href="./books.php" class="links"> Wróć do dostępnych książek</a>
    </div>
    <div class="d-flex justify-content-center">
        <a href="./orders.php" class="links"> Przeglądaj zamówenia</a>
    </div>
</div>
<?php
getFooter();
?>