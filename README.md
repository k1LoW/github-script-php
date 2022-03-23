# github-script-php

This action makes it easy to write PHP scripts in the workflow, just like [actions/github-script](https://github.com/actions/github-script).

In order to use this action, a `script` input is provided. The value of that input should be the body of an function call. The following arguments will be provided:

- `$github` A pre-authenticated [knplabs/github-api](https://github.com/knplabs/github-api) client
- `$context` An OpenStruct instance containing the context of the workflow run
