<?php 


return [
    'client_id' =>"AaVDqdSMEooh07ma4ilJkXSh7BgB277KF84ciMbkiIJ7rCaBLAUpXFNhCGAieG7L9jaMQ9co-8Oz8Uur",
    'secret' => "EBGqM57etUal4aVme3hTQG8UKbyVy9il8BizgZepLfmgZX_RKZRqt6oIWSYFBMzFC-4O-6_ew3ibVX-4",
    'settings' => array(
        'mode' => "sandbox",
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path().'/logs/paypal.log',
        'log.LogLevel' => 'ERROR', // PLEASE USE `FINE` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
    ),
];