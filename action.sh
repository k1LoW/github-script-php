#!/bin/bash
set -e

github_action_path=$(cd $(dirname $0); pwd)
image=php:${INPUT_PHP_VERSION}

echo "FROM ${image}" > Dockerfile
cat _Dockerfile >> Dockerfile
docker build -t github-script-php -f Dockerfile . 

rm -f _script.php
if [[ ! ${INPUT_SCRIPT} =~ ^\<\?php ]]; then
    echo "<?php" >> _script.php
fi
echo ${INPUT_SCRIPT} >> _script.php

INPUT_SCRIPT="" # for docker: poorly formatted environment: variable '**' contains whitespaces.

docker run --rm \
  --volume "${github_action_path}":/action \
	--volume "${GITHUB_WORKSPACE}":/app \
  --volume /home/runner/work:/home/runner/work \
	--workdir /app \
	--network host \
	--env-file <( env | cut -f1 -d= ) \
	github-script-php bash /action/entrypoint.sh
