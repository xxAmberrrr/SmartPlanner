<?php

    require 'quickstart.php';

    $client = getClient();
    $service = new Google_Service_Calendar($client);

    $name = 'testTask';
    $planningTimeAvailable;
    $deadline;
    $timeNeeding;
    $daysNeeding = 3;
    $priority = 'high';

    //To do: 
    //check date function php to set date deadline,
    //check random php,
    //plan between $planningTimeAvailable (9 to 5),
    //plan random in the weeks till $deadline

    $calendarId = 'csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com';

    for($i = 0; $i < $daysNeeding; $i++) {
        $event = new Google_Service_Calendar_Event(array(
        'summary' => $name,
        'start' => array(
            'dateTime' => '2017-04-15T09:00:00-07:00',
            'timeZone' => 'Europe/Amsterdam',
        ),
        'end' => array(
            'dateTime' => '2017-04-15T17:00:00-07:00',
            'timeZone' => 'Europe/Amsterdam',
        ),
        ));

        $event = $service->events->insert($calendarId, $event);
        printf('Event(s) created: %s\n', $event->htmlLink);
    }

?>