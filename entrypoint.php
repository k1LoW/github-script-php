<?php
if (file_exists('/opt/composer/vendor/autoload.php')) {
    require_once('/opt/composer/vendor/autoload.php');
    $github = new \Github\Client();
    $github->authenticate(getenv('GITHUB_TOKEN'), null, \Github\AuthMethod::ACCESS_TOKEN);
}

if (getenv('GITHUB_EVENT_PATH') !== "") {
    $context = json_decode(getenv('GITHUB_EVENT_PATH'), false);
}
var_dump($context);

require('_script.php');
