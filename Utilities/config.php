<?php

$google_client = new Google_Client();
$google_client->setClientId($_ENV['GOOGLE_IDCLIENT']);
$google_client->setClientSecret($_ENV['GOOGLE_SECRET_KEY']);
$google_client->setRedirectUri('http://'.$_ENV['HOST'].':'.$_ENV['PORT'].'/'.$_ENV['GOOGLE_REDIRECT_RESOURCE']);
$google_client->addScope('email');
$google_client->addScope('profile');
?>
