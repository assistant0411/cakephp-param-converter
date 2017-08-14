CakePHP Plugin Template
=======================

About
-----

Template for building CakePHP 3 plugins.

Developed by [Qobo](https://www.qobo.biz), used in [Qobrix](https://qobrix.com).

Usage
-----

Pull the template code into your plugin:

```
cd my-plugin
git pull https://github.com/QoboLtd/cakephp-plugin-template master
```

Make sure your `composer.json` has something like this:

```
"autoload": {
    "psr-4": {
        "Foobar\\": "src"
    }
},
"autoload-dev": {
    "psr-4": {
        "Foobar\\Test\\": "tests",
        "Cake\\Test\\": "./vendor/cakephp/cakephp/tests"
    }
}
```

If you do change your `composer.json` file, don't forget to run
either `composer update` or at least `composer dump-autoload`.

Change the following:

1. Uncomment the `$pluginName` line in `tests/bootstrap.php` and change `Foobar` to the name of your plugin.
2. Change the `Foobar` namespace to your plugin's in the following files:
  1. `tests/config/routes.php`
  2. `tests/App/Controller/AppController.php`
  3. `tests/App/Controller/UsersController.php`
  4. `tests/Fixture/UsersFixture.php`
3. Put your tests into `tests/TestCase`.
4. Put your fixtures into `tests/Fixture`.
5. Run `vendor/bin/phpunit`

If you know of any better way to do this please open an issue on GitHub or, better even, send a pull request.
