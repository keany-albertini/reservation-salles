<?php
    class Events {

        /**
         * Retourne un array avec tous les événements compris entre deux dates
         * UTILISATION DE debut pour les sélectionner
         * @param DateTime $start
         * @param DateTime $end
         * @return array
         */
        public function getEventsBetween(DateTime $start, DateTime $end): array {
            $pdo = new PDO('mysql:host=localhost;dbname=reservationsalles', 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            $sql = "SELECT 
                    reservations.id, reservations.titre, reservations.debut, reservations.fin, utilisateurs.login 
                    FROM reservations JOIN utilisateurs 
                    WHERE debut BETWEEN '{$start->format('Y-m-d 08:00:00')}' AND '{$end->format('Y-m-d 19:00:00')}'
                    AND utilisateurs.id = reservations.id_utilisateur
            ";
            // var_dump_pre($sql, '$sql');
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            return $results;
        }

        /**
         * Retourne un array avec tous les événements compris entre deux dates, INDEXÉ PAR JOUR
         * UTILISATION DE debut pour les sélectionner
         * @param DateTime $start
         * @param DateTime $end
         * @return array
         */
        public function getEventsBetweenByDay(DateTime $start, DateTime $end): array {
            $events = $this->getEventsBetween($start, $end);
            $days = [];
            // var_dump_pre($events, 'events[38]: $events');
            foreach ($events as $event) {
                $date = explode(' ', $event['debut'])[0];
                // var_dump($date);
                if (!isset($days[$date])) {
                    $days[$date] = [$event];
                } else {
                    $days[$date][] = [$event];
                }
            }
            return $days;
        }
        /**
         * Retourne un array avec tous les événements compris entre deux dates, INDEXÉ PAR JOUR
         * UTILISATION DE debut pour les sélectionner
         * @param DateTime $start
         * @param DateTime $end
         * @return array
         */
        public function getEventsBetweenByDayTime(DateTime $start, DateTime $end): array {
            $events = $this->getEventsBetween($start, $end);
            $days = [];
            // var_dump_pre($events, 'events[60]: $events');
            foreach ($events as $event) {
                // $date = explode(' ', $event['debut'])[0];
                // var_dump($date);
                // if (!isset($days[$date])) {
                //     // $days[$date] = [$event];
                // } else {
                    $days[$event['debut']] = $event;
                    // var_dump_pre($days, '$days');
                    // die();
                // }
            }
            // var_dump_pre($days, 'events70, $days');
            return $days;
        }
        /**
         * prend deux 'Y-m-d H:i:s' en entrée et renvoie la durée en heures
         * @param string $start
         * @param string $end
         * @return int
         */
        public function timeLength(string $start, string $end): int {
            $tempOne = new DateTime($start);
            $tempTwo = new DateTime($end);
            
            $length = date_diff($tempOne, $tempTwo);
            return $length->h;
        }
    }