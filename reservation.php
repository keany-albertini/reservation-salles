<?php
    session_start();
    
    require_once('functions.php');
    require_once('pdo.php');
    require_once('semaine.php');
    require_once('evenements.php');

    $title = 'réservation';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body class="container">
        <?php require_once('templates/header.php') ?>
        <main>
        <h1>Réservation</h1>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>