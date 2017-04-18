<?php

    //require 'quickstart.php';
    require 'getEvents.php';

   // $name = 'testTask';
    $planningTimeAvailable;
    //$deadline = '2017-04-28';
    $timeNeeding;
   // $daysNeeding = 3;
    //$dateNow = date('Y-m-d');

    //$minTime = '09:00:00';
    //$maxTime = '17:00:00';

    function rand_date($min_date, $max_date, $min_time, $max_time) {
        $min_epoch = strtotime($min_date);
        $max_epoch = strtotime($max_date);
        $min_time_epoch = strtotime($min_time);
        $max_time_epoch = strtotime($max_time);

        $rand_epoch = rand($min_epoch, $max_epoch);
        $rand_time_epoch = rand($min_time_epoch, $max_time_epoch);

        $date = date('Y-m-d', $rand_epoch);
        $time = date('H:i:s', $rand_time_epoch);

        return $date . 'T' . $time;
    }
    
    function addEvent($eventName, $days, $deadline, $minTime, $maxTime) {
        $client = getClient();
        $service = new Google_Service_Calendar($client);

        $calendarId = 'csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com';

        for($i = 0; $i < $days; $i++) {
            $dateStart = rand_date(date('Y-m-d'), $deadline, $minTime, $maxTime);

            $event = new Google_Service_Calendar_Event(array(
                'summary' => $eventName,
                'start' => array(
                    'dateTime' => $dateStart,
                    'timeZone' => 'Europe/Amsterdam',
                ),
                'end' => array(
                    'dateTime' => date('Y-m-d\TH:i:s',strtotime('+2 hours',strtotime($dateStart))),
                    'timeZone' => 'Europe/Amsterdam',
                ),
            ));

            $event = $service->events->insert($calendarId, $event);
            printf('Event(s) created: %s\n', $event->htmlLink);
        }
    }

    addEvent('Test task Amber', 4, '2017-04-28', '09:00:00', '17:00:00');

    


?>