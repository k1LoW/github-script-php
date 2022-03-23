<?php
if (file_exists('/opt/composer/vendor/autoload.php')) {
    require_once('/opt/composer/vendor/autoload.php');
    $github = new \Github\Client();
    $github->authenticate(getenv('GITHUB_TOKEN'), null, \Github\AuthMethod::ACCESS_TOKEN);
}

if (getenv('GITHUB_EVENT_PATH')) {
    $context = new stdClass();
    $context->payload = json_decode(file_get_contents(getenv('GITHUB_EVENT_PATH'), false));

    $context->event_name = getenv('GITHUB_EVENT_NAME');
    $context->sha = getenv('GITHUB_SHA');
    $context->ref = getenv('GITHUB_REF');
    $context->workflow = getenv('GITHUB_WORKFLOW');
    $context->action = getenv('GITHUB_ACTION');
    $context->actor = getenv('GITHUB_ACTOR');
    $context->job = getenv('GITHUB_JOB');
    $context->run_number = getenv('GITHUB_RUN_NUMBER') ? (int) getenv('GITHUB_RUN_NUMBER') : null;
    $context->run_id = getenv('GITHUB_RUN_ID') ? (int) getenv('GITHUB_RUN_ID') : null;
    $context->api_url = getenv('GITHUB_API_URL') || 'https://api.github.com';
    $context->server_url = getenv('GITHUB_SERVER_URL') || 'https://github.com';
    $context->graphql_url = getenv('GITHUB_GRAPHQL_URL') || 'https://api.github.com/graphql';

    // repo
    $context->repo = new stdClass();
    if (getenv('GITHUB_REPOSITORY')) {
        $ownerrepo = explode('/', getenv('GITHUB_REPOSITORY'));
        $context->repo->owner = $ownerrepo[0];
        $context->repo->repo = $ownerrepo[1];
    } else {
        $context->repo->owner = $context->payload->repository->owner->login;
        $context->repo->repo = $context->payload->repository->name;
    }

    // issue
    if ($context->payload) {
        if ($context->payload->issue && $context->payload->issue->number) {
            $number = $context->payload->issue->number;
        } else if ($context->payload->pull_request && $context->payload->pull_request->number) {
            $number = $context->payload->pull_request->number;
        } else if ($context->payload->number) {
            $number = $context->payload->number;
        }
        if ($number) {
            $context->issee = new stdClass();
            $context->issue->number = $number;
            if ($context->repo) {
                $context->issue->owner = $context->repo->owner;
                $context->issue->repo = $context->repo->repo;
            }
        }
    }    
}

require('_script.php');
