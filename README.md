Requirements
------------
1. PHP 5.3+

Installation
------------

1. Configure env variables:

```apache
SetEnv DB_ENGINE mysql
SetEnv DB_HOST localhost
SetEnv DB_NAME sample
SetEnv DB_USER root
SetEnv DB_PASSWORD ""
SetEnv DB_CHARSET "utf-8"
SetEnv ENVIRONMENT "development" # /test/production
SetEnv TEST_URL "http://test/sample/"
```

2. Import database schema `app/schema.sql`.

3. It's ready!

Running examples (tests)
------------------------

1. Install [Composer](http://getcomposer.org/doc/00-intro.md).

2. Install required dependencies through **Composer**.

3. Configure env variables pointing to test database.

4. Configure `codeception.yml` and `tests/*.suite.yml`.

5. Run [Codeception](http://codeception.com) examples:

`./vendor/bin/codecept run`

Configuration Sample
--------------------

Add following line to `/etc/hosts/` file:

`127.0.0.1	test`

Add a `.htaccess` file or configure your Apache with:

```apache
SetEnv DB_ENGINE mysql
SetEnv DB_HOST localhost
SetEnv DB_USER root
SetEnv DB_PASSWORD ""
SetEnv DB_CHARSET "utf-8"

SetEnvIf Host test ENVIRONMENT=test
SetEnvIf Host test DB_NAME=sample_test

# SetEnvIfNoCase sometimes doesn't work, so...
SetEnvIf Host localhost ENVIRONMENT=development
SetEnvIf Host localhost DB_NAME=sample
```