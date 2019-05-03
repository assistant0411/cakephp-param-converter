<?php
return [
    'ParamConverter' => [
        'converters' => [
            \ParamConverter\EntityParamConverter::class,
            \ParamConverter\DateTimeParamConverter::class,
            \ParamConverter\FrozenDateTimeParamConverter::class,
            \ParamConverter\BooleanParamConverter::class,
            \ParamConverter\IntegerParamConverter::class,
            \ParamConverter\FloatParamConverter::class
        ]
    ]
];