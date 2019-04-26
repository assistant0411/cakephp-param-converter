# Param Converter

CakePHP v3.x plugin for converting request parameters to objects. These objects replace the original parameters before dispatching the controller action and hence they can be injected as controller method arguments.

Heavily inspired by [Symfony ParamConverter](https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html)

## Install

Using Composer:

```
composer require softius/cakephp-param-converter
```

You then need to load the plugin. You can use the shell command:

```
bin/cake plugin load ParamConverter
```

## Usage

Adjustments on application level are only necessary if you need to remove or / add new param converters.

### Configuration

By default, the plugin provides and registers two converters that can be used to convert request parameters to DateTime and Entity instances.
Converters can be removed / added by adjusting the following configuration:

``` php
<?php
// config/param_converter.php
return [
    'ParamConverter' => [
        'converters' => [
            \ParamConverter\EntityParamConverter::class,
            \ParamConverter\DateTimeParamConverter::class,
        ]
    ]
];
```

### Creating a converter

All converters must implement the `ParamConverterInterface`.

## Security

If you discover any security related issues, please email softius@gmail.com instead of using the issue tracker.

## Credits

- [Iacovos Constantinou][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[link-author]: https://github.com/softius
[link-contributors]: ../../contributors