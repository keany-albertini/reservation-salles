<?php
    /*
        Un formulaire de réservation de salle (reservation-form.php)
        Ce formulaire contient les informations suivantes : 
            titre, description, date de début, date de fin.
    */
    
    session_start();

    require_once('functions.php');
    require_once('pdo.php');
     $title = 'réserver';
    

    if(isset($_POST['valider']))
    {
        $titre = $_POST['titre'] ;
        $description = $_POST['description'] ;
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'] ;
        $id_utilisateur = $_SESSION['id']; 


        // Variable heure + jour début et fin pour les conditions

        $heure_debut_nombre = date_create($date_debut);
        $heure_debut = date_format($heure_debut_nombre ,'G'); // renvoi int 15 pour ex 15h00 
        $jour_debut = date_format($heure_debut_nombre ,'w'); // int 0 pour diamnche, 1 lundi etc...

        $heure_fin_nombre = date_create($date_fin);
        $heure_fin = date_format($heure_fin_nombre ,'G');
        $jour_fin = date_format($heure_fin_nombre ,'w');

        $interval = $heure_fin - $heure_debut ; 
        
        if(!empty($titre) && !empty($description) && !empty($date_debut) && !empty($date_fin)) // verif champs vide 
        {

            $connexion = new PDO('mysql:host=localhost;dbname=reservationsalles',"root","");
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;

            $sql = $connexion->prepare("SELECT COUNT(*) FROM reservations WHERE debut = :datedebut OR fin = :datefin"); 
            $sql->bindParam(':datedebut',$date_debut );
            $sql->bindParam(':datefin',$date_fin );

            $sql->execute(); 

            $resultat = $sql->fetchColumn() ;

            if($resultat == 0 && $jour_debut == $jour_fin && $interval <= 2 && $jour_debut > 0 && $jour_debut < 6 && $heure_debut >= 8 && $heure_debut <= 18 && $heure_fin >= 9 && $heure_fin <= 19 && $heure_fin > $heure_debut ) 
            {
                $requete = $connexion->prepare("INSERT INTO reservations(titre,description,debut,fin,id_utilisateur) VALUES (:titre,:description,:debut,:fin,:id_utilisateur)");
                $requete->bindParam(':titre',$titre );
                $requete->bindParam(':description',$description );
                $requete->bindParam(':debut',$date_debut );
                $requete->bindParam(':fin', $date_fin );
                $requete->bindParam(':id_utilisateur',$id_utilisateur );
    
                $requete->execute() ; 
    
                $resa = '<p class="valide"> Réservation effectué </p>' ;
                if($interval == 2)
                {
                    $new_date = date_create($date_debut);
                    date_modify($new_date,"+1 hour") ;

                    $date_debut = date_format($new_date,'Y-m-d H:i:s');
                    
                    $requete->execute() ; 

                }
            }
            elseif($jour_debut != $jour_fin)
            {
                $meme_jour = '<p class="error"> Veuillez selectionnez le même jour </p>';
            }
            elseif($interval > 2){
                $interval_error = '<p class="error"> Vous ne pouvez pas reservé plus de 2h </p>';
            }
            elseif($jour_debut == 0 OR $jour_debut == 6)
            {
                $jour_error = '<p class="error"> Les reservations se font uniquement du lundi au vendredi </p>' ; 
            }
            elseif($heure_debut < 8 OR $heure_debut > 18 OR $heure_fin < 9 OR $heure_fin > 19)
            {
                $crenau_error = '<p class="error"> Les reservations se font entre 8h et 19h </p>' ;
            }
            elseif($heure_fin <= $heure_debut)
            {
                $heure_error = '<p class="error"> Erreur : l\'heure de fin est inférieure à l\'heure du début </p>' ; 
            }
            else{
                $reser = '<p class="error"> Ce crénau horaire est déjà reservé ! </p>' ; 
            }
        }
        else{
            $champs = '<p class="error"> Veuillez remplir tous les champs </p>' ;
        }
    }
?>


<DOCTYPE! html>
<html>

    <?php require_once('templates/head.php') ?>

    <body>
<?php require_once('templates/header.php') ?>

        <main>
            <section id="formulaire">
                <article class="contenu_formulaire">
                    <form action="reservation-form.php" method="POST">

                        <label for="titre"> Titre : </label>
                        <input type="text" id="titre" name="titre">

                        <label for="des"> Description : </label>
                        <textarea id="des" name="description"></textarea>

                        <label for="date_debut"> Date de début : </label>
                        <input type="datetime-local" id="date_debut" name="date_debut">

                        <label for="date_fin"> Date de fin : </label>
                        <input type="datetime-local" id="date_fin" name="date_fin">

                        <?php 
                            if(isset($meme_jour))
                            {
                                echo $meme_jour ;
                            }
                            elseif(isset($interval_error))
                            {
                                echo $interval_error ;
                            }
                            elseif(isset($jour_error))
                            {
                                echo $jour_error ;
                            }
                            elseif(isset($crenau_error))
                            {
                                echo $crenau_error ;
                            }
                            elseif(isset( $heure_error))
                            {
                                echo  $heure_error ;
                            }
                            elseif(isset($reser))
                            {
                                echo $reser ;
                            }
                            elseif(isset($champs))
                            {
                                echo $champs ;
                            }
                            elseif(isset($resa))
                            {
                                echo $resa ; 
                            }

                        ?>

                        <input type="submit" value="Envoyer" name="valider">

                    </form>
                </article>

            </section>
        </main>
<?php require_once('templates/footer.php') ?>

    </body>
</html>