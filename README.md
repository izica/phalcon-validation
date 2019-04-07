# Phalcon validation

Handy interface for Phalcon\Validation

### Installation
```
composer require izica/phalcon-validation
```

### Api
Izica\Validation
* __construct($arOptions)  // example below
* validate($arData)
* static required($arOptions) //Phalcon\Validation\Validator\PresenceOf
* static numeric($arOptions) //Phalcon\Validation\Validator\Numericality
* static email($arOptions) //Phalcon\Validation\Validator\Email
* TODO ----
* length
* callback
* etc

### Notice
[https://docs.phalconphp.com/3.4/en/api/phalcon_validation_validator_numericality]
$arOptions which passed in static functions, for example statice numeric($arOptions),
used as params for new Numericality($arOptions);

You can use it like this
```
$validation = new Validation([
    'num' => [Validation::numeric(['message' => ':field is not numeric')],
]);
```

### Usage
```php
use Izica\Validation;
use Phalcon\Mvc\Controller;

class ExampleController extends Controller {
    public function indexAction() {
        $validation = new Validation([
            'email' => [Validation::required(), Validation::email()],
            'num' => [Validation::required(), Validation::numeric()],
        ]);
        $arMessages = $validation->validate($_POST);
        if ($arMessages) {
            // validation error
        }
        // validation success
    }
}
```

```
$arMessages = $validation->validate($_POST);

Request
email: qwe
num: 

Response: 
Array
(
    [0] => Array
        (
            [type] => email
            [message] => email is not valid
            [field] => email
        )

    [1] => Array
        (
            [type] => num
            [message] => num is required
            [field] => num
        )

    [2] => Array
        (
            [type] => num
            [message] => num is not numeric
            [field] => num
        )
)

```

