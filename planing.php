<?php
    /*
        Une page permettant de voir le planning de la salle (planning.php) :
        Sur cette page on voit le planning de la semaine avec l’ensemble des réservations effectuées. 
        Le planning se présente sous la forme d’un tableau avec les jours de la semaine en cours. 
        Dans ce tableau, il y a en colonne les jours et les horaires en ligne. 
        Sur chaque réservation, il est écrit le nom de la personne 
        ayant réservé la salle ainsi que le titre. 
        Si un utilisateur clique sur une réservation, il est amené sur une page dédiée.
        Les réservations se font du lundi au vendredi et de 8h et 19h. 
        Les créneaux ont une durée fixe d’une heure.
    */

    require_once('functions.php');
    require_once('pdo.php');
    require_once('semaine.php');
    require_once('evenements.php');

    date_default_timezone_set ('Europe/Paris');

    $title = 'planning';

    $eventsFromDB = new Events();

    $actWeek = new Week($_GET['day'] ?? null, $_GET['month'] ?? null, $_GET['year'] ?? null);
    
    $startingDayWeek = $actWeek->getStartingDay();

    $end = (clone $startingDayWeek)->modify('+ 5 days - 1 second');

    $events = $eventsFromDB->getEventsBetweenByDay($startingDayWeek, $end);

?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php'); ?>
    <body>
        <?php require_once('templates/header.php'); ?>
        <main>
        <div class="calendar__nav">            
            <a href="planning.php?day=<?= $actWeek->previousWeek()->day; ?>&month=<?= $actWeek->previousWeek()->month; ?>&year=<?= $actWeek->previousWeek()->year; ?>" class="btn btn-primary">&lt;</a>
            <h1>planning: <?= $actWeek->monthToString(); ?></h1>
            <a href="planning.php?day=<?= $actWeek->nextWeek()->day; ?>&month=<?= $actWeek->nextWeek()->month; ?>&year=<?= $actWeek->nextWeek()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
        <table class="calendar__table">
            <colgroup>
                <col style="background-color:#ddd;">
                <col span="5">
                <col span="2" style="background-color:#ddd;">
            </colgroup>
            <tr>
                <th class="calendar__hour">horaires</th>

                <?php for ($i = 0; $i < 7; ++$i): ?>
                    <?php
                        $date = (clone $startingDayWeek)->modify('+ ' . $i . ' days');
                        $eventsForDay = $events[$startingDayWeek->format('Y-m-d')] ?? []; 
                    ?>

                    <th class="<?= ($i < 5) ? 'calendar__weekday': 'calendar__weekend'; ?>"><?= $actWeek->getWeekDays($i); ?> <?= $actWeek->mondaysDate + $i; ?></th>
                <?php endfor; ?>
            </tr>
            <?php for ($i = 0; $i < 11; ++$i): ?> 
                <tr>
                    <th><?= $time = ($i + 8) . ':00'; ?></th>
                    <?php for ($j = 0; $j < 7; ++$j): ?>
                        <td> 
                            <?php
                                $dateTime = $date->format('Y-m-d') .  ' ' . $time . ':00';
                                echo $dateTime, '<br />';
                                foreach ($eventsForDay as $event) 
                                {
                                    echo 'debut: ' . $event['debut'];
                                    if ($dateTime == $event['debut']) 
                                    {
                                        echo 'OK';
                                    }
                            ?>                            
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>
    </main>
    <?php require_once('templates/footer.php') ?>
    </body>
</html>