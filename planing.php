<?php
session_start();
include("functions.php");

?>
<!DOCTYPE html>
<html>
<?php
    require_once('functions.php');
    require_once('pdo.php');
    $title = 'planing';
   require_once('templates/head.php');
    
?>
    <body>
    <?php require_once('templates/header.php') ?>

        <main>
            <article class="contenu_planning">
                <div class="tableau">
                    <table>
                        <thead>
                            <h1> Planning réservation tables </h1>
                        </thead>
                        <tbody>
                            <tr>
                                <th> Semaine numéro ? </th>
                                <td class="jour"> Lundi </td>
                                <td class="jour"> Mardi </td>
                                <td class="jour"> Mercredi </td>
                                <td class="jour"> Jeudi </td>
                                <td class="jour"> Vendredi </td>
                            </tr>
                            <?php
                                for($heure = 8 ; $heure <= 19 ; $heure++) // boucle pour les lignes des heures
                                {
                                    echo '<tr></tr>'; 
                                    for($jour = 0 ; $jour <= 5 ; $jour++) // boucle pour les crénaux de chaque jour 
                                    {
                                        if($jour == 0)
                                        {
                                            echo '<th>' .$heure.'h </th>';
                                        }
                                        else{
                                            checkHoraire($jour,$heure) ; 
                                        }
                                    }
                                }
                            ?>

                        </tbody>
                    </table>
                </div>
            </article>    
        </main>            
        <?php
            require_once("templates/footer.php");
        ?>
    </body>
</html>