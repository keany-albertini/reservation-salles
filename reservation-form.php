<?php
    /*
        Un formulaire de réservation de salle (reservation-form.php)
        Ce formulaire contient les informations suivantes : 
            titre, description, date de début, date de fin.
    */
    session_start();
    
    // DEBUG
    $one = '<br />';
    $two = $one . $one;

    require_once('pdo.php');
    require_once('functions.php');

    $title = 'formulaire de réservation';

    // DEBUG
    print_r_pre($_SESSION, '18: $_SESSION:');
    echo breakingLine();
    print_r_pre($_POST, '20: $_POST:');
    echo breakingLine();


    if ( isset($_POST['cancel']) ) 
    {
        header('Location: deconnexion.php');
        return;
    }
    if ( isset($_POST['submit'])) 
    {
        // pas de titre
        if (empty($_POST['title'])) 
        {
            $_SESSION['error'] = 'Vous devez entrer un titre pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // pas de date
        elseif (empty($_POST['date'])) 
        {
            $_SESSION['error'] = 'Vous devez choisir un jour pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // pas d'heure du début
        elseif (empty($_POST['startTime'])) 
        {
            $_SESSION['error'] = 'Vous devez choisir une heure de début pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // pas heure de fin
        elseif (empty($_POST['endTime'])) 
        {
            $_SESSION['error'] = 'Vous devez choisir une heure de fin pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // âs de description
        elseif (empty($_POST['description'])) 
        {
            $_SESSION['error'] = 'Vous devez écrire une description pour votre réservation.';
            header('Location: reservation-form.php');
            return;
        }
        // OK, CONTINUE
        else 
        {
            $dateArray = explode('-', $_POST['date']);
            $dateFormatted =implode('/',$dateArray);
            $startTimeArray = explode(':', $_POST['startTime']);
            $endTimeArray = explode(':', $_POST['endTime']);
            $timestamp = strtotime($_POST['date']);
            $dayOfWeek = date('N', $timestamp);

            // si c'est le week-end
            if ($dayOfWeek == 6 || $dayOfWeek == 7) 
            {
                $_SESSION['error'] = 'Vous ne pouvez pas faire de réservations le Samedi ou le Dimanche.';
                header('Location: reservation-form.php');
                return;
            }
            // heure de fin avant heure du debut
            elseif ($endTimeArray[0] <= $startTimeArray[0]) 
            {
                $_SESSION['error'] = 'L\'heure de fin de votre réservation n\'est pas valide, elle finit avant d\'avoir commencé.';
                header('Location: reservation-form.php');
                return;
            }
            // 
            elseif ($endTimeArray[1] != '00' || $startTimeArray[1] != '00') 
            {
                $_SESSION['error'] = 'Vous ne pouvez utiliser que des heures.';
                header('Location: reservation-form.php');
                return;
            }
            else 
            {
                $timestampNow = time();
                $dateTime = $_POST['date'] . ' ' .$_POST['startTime'] . ':00';
                $resDateTime = strtotime($dateTime);

                if ($resDateTime <= $timestampNow) 
                {
                    $_SESSION['error'] = 'Vous avez fait une réservation dans le passé. 
                                        Merci de faire les corrections nécessaires.';
                    header('Location: reservation-form.php');
                    return;
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php') ?>
    <body class="container">
        <?php require_once('templates/header.php') ?>
        <main>
            <h1>Formulaire de réservation de salle</h1>
            <p>ici vous pouvez réserver une salle</p>
            <?php
                if (isset($_SESSION['error'])) 
                {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
                elseif ( isset($_SESSION['success']) ) 
                {
                    echo '<p class="success">' . $_SESSION['success'] . '</p>';
                    unset($_SESSION['success']);
                }
                if (!isset($_SESSION['logged']) || !$_SESSION['logged']) :
                    echo '<p class="error">Vous devez etre connecté pour pouvoir réserver</p>';
                else :
            ?>

            <p>
                Vous ne pouvez réserver que 
            </p>
            <form method="POST">
                <label for="title">Titre:</label>
                <input type="text" name="title" id="title" /><br />

                <label for="date">date:</label>
                <input type="date" name="date" id="date"/><br />

                <label for="timeStart">heure de début:<br /><small>de 8:00 à 19:00</small></label>
                <input type="time" id="timeStart" name="startTime" min="08:00" max="19:00" /><br />

                <label for="timeEnd">heure de fin:<br /><small>de 9:00 à 20:00</small></label>    
                <input type="time" id="timeEnd" name="endTime" min="09:00" max="20:00" /> <br />

                <label for="description">Desciption:</label> <br />
                <textarea name="description" id="description" cols="33" rows="10" maxlength="65535"></textarea/><br />

                <input type="submit" name='cancel' value="annuler">
                <input type="reset" name='reset' value="Réinitialiser">
                <input type="submit" name='submit' value="Valider">
            </form>
            <?php
                endif;
            ?>
        
        </main>
        <?php require_once('templates/footer.php') ?>
        
    </body>
</html>