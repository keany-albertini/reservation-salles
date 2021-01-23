<?php
    session_start();
    
    require_once('functions.php');
    require_once('pdo.php');
    $title = 'réservations';

    $connexion = new PDO('mysql:host=localhost;dbname=reservationsalles',"root","");
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ; 

    $requete = $connexion->prepare('SELECT login,titre,description,debut,fin
                                            FROM utilisateurs 
                                                INNER JOIN reservations
                                                    ON utilisateurs.id = reservations.id_utilisateur
                                                        WHERE id_utilisateur = :id ' 
    );

    $requete->bindParam(':id', $_GET['id']); 
    $requete->execute() ;

    $result = $requete->fetch() ;

    $login = $result['login'] ; 
    $titre = $result['titre'] ;
    $description = $result['description'] ;
    $debut = $result['debut'] ;
    $fin = $result ['fin'] ;

?>

<DOCTYPE! html>
<html>
   <?php require_once('templates/head.php') ?>

    <body>
       <?php require_once('templates/header.php') ?> 

        <main>
            <section id="infos_resa">
                <h1> Informations de la réservation </h1>
                <article class="contenu_infos_resa">
                    <div class="infos">
                        <p><span> Nom : </span><?php echo $login ; ?> </p>
                        <p><span> Titre de l'événement : </span><?php echo $titre ; ?> </p>
                        <p><span> Description : </span><?php echo $description ; ?> </p>
                        <p><span> Date de début : </span><?php echo $debut ; ?> </p>
                        <p><span> Date de fin : </span><?php echo $fin ; ?> </p>
                    </div>

                </article>    

            </section>  
            

        </main>

        <?php require_once('templates/header.php') ?>
    </body>         


</html>    