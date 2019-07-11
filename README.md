# Phalcon validation

Useful tool for Phalcon\Validation for easiest way to validate your data

### Installation
```
composer require izica/phalcon-validation
```

### Api
Izica\Validation
* `__construct($arOptions)`  -- example below
* `validate($arData)`
* `static make($arData, $arOptions)`

Izica\ValidationRule
* `static required($arOptions: optional)` -- Phalcon\Validation\Validator\PresenceOf
* `static numeric($arOptions: optional)` -- Phalcon\Validation\Validator\Numericality
* `static email($arOptions: optional)` -- Phalcon\Validation\Validator\Email
* `static url($arOptions: optional)` -- Phalcon\Validation\Validator\Url
* `static callback($arOptions)` -- Phalcon\Validation\Validator\Callback
* `static length($arOptions)` -- Phalcon\Validation\Validator\StringLength
* `static unique($arOptions)` -- Phalcon\Validation\Validator\UniquenessValidator
* `static between($arOptions)` -- Phalcon\Validation\Validator\Between
* `static file($arOptions)` -- Phalcon\Validation\Validator\File
* `static date($arOptions)` -- Phalcon\Validation\Validator\Date
* `static regex($arOptions)` -- Phalcon\Validation\Validator\Regex

### Notice
[https://docs.phalconphp.com/3.4/en/api/phalcon_validation_validator_numericality]
`$arOptions` which passed in static functions, for example `static numeric($arOptions)`,
used as params for `new Numericality($arOptions)`;

You can use it like this
```
$validation = new Validation([
    'num' => [Validation::numeric(['message' => ':field is not numeric')],
]);
```

### Usage
```php
use Izica\Validation;
use Izica\ValidationRule;
use Phalcon\Mvc\Controller;

class ExampleController extends Controller {
    public function indexAction() {
        $validation = new Validation([
            'email' => [ValidationRule::required(), ValidationRule::email()],
            'num' => [ValidationRule::required(), ValidationRule::numeric()],
        ]);
        $arMessages = $validation->validate($_POST);
        if ($arMessages) {
            // validation error
        }
        // validation success
    }
    // or short
    public function indexAction() {
        $arMessages = Validation::make($_POST, [
            'email' => [ValidationRule::required(), ValidationRule::email()],
            'num' => [ValidationRule::required(), ValidationRule::numeric()],
        ]);
        if ($arMessages) {
            // validation error
        }
        // validation success
    }
}
```


```php

/*
    $_POST = [
        'email' => 'qwe'
    ];
*/
$arMessages = $validation->validate($_POST);

/* 
$arMessages
Array
(
    [0] => Array
        (
            [field] => email
            [type] => email
            [message] => email is not valid
        )

    [1] => Array
        (
            [field] => num
            [type] => required
            [message] => num is required
        )

    [2] => Array
        (
            [field] => num
            [type] => numeric
            [message] => num is not numeric
        )

)
*/

```

