<?php
try{
    $pdo = new PDO('pgsql:host=localhost;dbname=db_proj_borek_jaworski', 'projekt', 'projekt');
}
catch(PDOException $e){
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>