<?php
return [
    'ParamConverter' => [
        'converters' => [
            \ParamConverter\EntityParamConverter::class,
            \ParamConverter\DateTimeParamConverter::class,
            \ParamConverter\BooleanParamConverter::class,
            \ParamConverter\IntegerParamConverter::class
        ]
    ]
];