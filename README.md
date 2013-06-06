Cisco Systems GitlabBundle
==========================

The GitlabBundle offers basic integration of the API introduced in Gitlab 2.7

So far only the Gitlab API versions v2 and v3 are implemented.
It should be easy to include the Github API v3. Merge requests welcome.

## Installation

Add the following lines to your composer.json:

```
{
    "repositories": [
        {
            "type": "vcs",
            "url": "http://github.com/CiscoVE/GitlabBundle.git"
        }
    ],
    "require": {
        "cisco-systems/gitlab-bundle": "*"
    }
}
```

Tell Composer to update your vendor directory:

```composer.phar update "cisco-systems/gitlab-bundle"```

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new CiscoSystems\GitlabBundle\CiscoSystemsGitlabBundle(),
    );
}
```

Update your schema:

```
php app/console doctrine:schema:update --force
```

Alternatively run the `doctrine:schema:udpate` command with the `--dump-sql`
flag and use the generated SQL command directly.

Congratulations! You're ready to use the GitlabBundle!

## Basic Usage

``` php
<?php

// Get credentials containing a user's token, a Gitlab host and an API version, e.g. via a form

$access = $this->getDoctrine()->getRepository( 'CiscoSystemsGitlabBundle:Access' )->find( $someId );

// Obtain an API implementation instance for provided credentials

$api = $this->get( 'gitlab' )->getApi( $access );

// Call methods defined in CiscoSystems\GitlabBundle\API\ApiInterface

$projects = $api->getProjects();

$issues = $api->getIssues();

```

Complete examples can be found in the built-in controllers.

## Configuration

Your users will need to enter a Gitlab host and private token
in their profile before they can use the API. This bundle
offers a controller and templates for doing so which only
need to be included in your routing, and/or overridden in your
application.

# Storage

This bundle currently requires the Doctrine ORM. I may
decide to make it storage agnostic in a future version.
