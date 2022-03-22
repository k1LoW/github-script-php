<?php

if (getenv('GITHUB_EVENT_PATH') !== "") {
    $context = json_decode(getenv('GITHUB_EVENT_PATH'), false);
}

require('_script.php');
