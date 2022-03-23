# github-script-php

This action makes it easy to write PHP scripts in the workflow, just like [actions/github-script](https://github.com/actions/github-script).

In order to use this action, a `script` input is provided. The value of that input should be the body of an function call. The following arguments will be provided:

- `$github` A pre-authenticated [knplabs/github-api](https://github.com/knplabs/github-api) client
- `$context` An OpenStruct instance containing the context of the workflow run

## Examples

### Print the available attributes of context

ref: [actions/github-script example](https://github.com/actions/github-script#print-the-available-attributes-of-context)

``` yaml
- name: View context attributes
  uses: k1LoW/github-script-php@v0
  with:
    script: var_dump($context);
```

### Comment on an issue

ref: [actions/github-script example](https://github.com/actions/github-script#comment-on-an-issue)

``` yaml
on:
  issues:
    types: [opened]

jobs:
  comment:
    runs-on: ubuntu-latest
    steps:
      - uses: k1LoW/github-script-php@v0
        with:
          script: |
            $owner = $context->repo->owner;
            $repo = $context->repo->repo;
            $number = $context->issue->number;
            $comment = '👋 Thanks for reporting!';
            $github->api('issue')->comments()->create($owner, $repo, $number, array('body' => $comment));
```

## References

- [actions/github-script](https://github.com/actions/github-script): Write workflows scripting the GitHub API in JavaScript


