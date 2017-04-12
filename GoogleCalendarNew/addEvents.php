<?php

    require 'quickstart.php';

    $client = getClient();
    $service = new Google_Service_Calendar($client);

    $name = 'testTask';
    $deadline;
    $timeNeeding;
    $dayRange = 1;
    $priority = 'high';

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
        'summary' => 'TestMultiple',
        'start' => array(
            'dateTime' => '2017-04-14T03:00:00-02:00',
            'timeZone' => 'Europe/Amsterdam',
        ),
        'end' => array(
            'dateTime' => '2017-04-14T05:00:00-02:00',
            'timeZome' => 'Europe/Amsterdam',
        ),
    ));

    $calendarId = 'csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com';
    $event = $service->events->insert($calendarId, $event);
    printf('Event created: %s\n', $event->htmlLink);

?>