#!/bin/bash
set -e

echo ${INPUT_SCRIPT}

github_action_path=$(cd $(dirname $0); pwd)
image=php:${INPUT_PHP_VERSION}

rm -f _script.php
echo ${INPUT_SCRIPT} >> _script.php

if [[ ! ${INPUT_SCRIPT} =~ ^\<\?php ]]; then
    sed -i '1s/^/<?php\n/' _script.php
fi

docker run --rm \
  --volume "${github_action_path}":/action \
	--volume "${GITHUB_WORKSPACE}":/app \
	--workdir /app \
	--network host \
	--env-file <( env | cut -f1 -d= ) \
	${image} bash /action/entrypoint.sh
