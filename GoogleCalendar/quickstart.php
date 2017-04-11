
<?php
require_once __DIR__ . '/vendor/autoload.php';


define('APPLICATION_NAME', 'Google Calendar API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/calendar-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR)
));

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
// $calendarId = 'csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com';
// $optParams = array(
//   'maxResults' => 10,
//   'orderBy' => 'startTime',
//   'singleEvents' => TRUE,
//   'timeMin' => date('c'),
// );
// $results = $service->events->listEvents($calendarId, $optParams);

// if (count($results->getItems()) == 0) {
//   print "No upcoming events found.\n";
// } else {
//   print "Upcoming events:\n";
//   foreach ($results->getItems() as $event) {
//     $start = $event->start->dateTime;
//     if (empty($start)) {
//       $start = $event->start->date;
//     }
//     printf("%s (%s)\n", $event->getSummary(), $start);
//   }
// }

//List of calendars
$calendarList = $service->calendarList->listCalendarList();

$calendars = array();
$calendarsSelected = array();

array_push($calendarsSelected, '228iua7de1js8if439cgsgk4dc@group.calendar.google.com'); //MT3C
array_push($calendarsSelected, 'xxamberrrr12@gmail.com'); //Amber Hoogland
array_push($calendarsSelected, 'ihl73aqpljlu9u67srth0657s8@group.calendar.google.com'); //School
array_push($calendarsSelected, 'csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com'); //SmartPlanner
array_push($calendarsSelected, 'k6m04v2tp7ortm5ol5kg8clkuk@group.calendar.google.com'); //Werk

$optParams = array(
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
  'timeMin' => date('c'),
);

while(true) {
  // foreach ($calendarList->getItems() as $calendarListEntry) {
  //   array_push($calendarsSelected, $calendarListEntry->getId());
  // }

  for($i = 0; $i < count($calendarsSelected); $i++) {
    $results = $service->events->listEvents($calendarsSelected[$i], $optParams);

    foreach($results->getItems() as $event) {
      $start = null;

      if(isset($event->start->dateTime)) {
        $start = $event->start->dateTime;
      }

      if(empty($start)) {
        if(isset($event->start->date)) {
          $start = $event->start->date;
        }
      }

      printf("%s (%s)\n", $event->getSummary(), $start);
    }

    // for($j = 0; $j < count($results); $j++) {
    //   print_r($results[$j]->getSummary());
    // }
  }

  $pageToken = $calendarList->getNextPageToken();
  if ($pageToken) {
    $optParams = array('pageToken' => $pageToken);
    $calendarList = $service->calendarList->listCalendarList($optParams);
  } else {
    break;
  }
}

?>