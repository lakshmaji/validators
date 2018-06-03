# Validators



>### What it is

 - Validator helpers for Laravel Validation. 

>### Version

1.0.1

>### Sample

![Image](https://raw.githubusercontent.com/lakshmaji/validators/master/resources/validator.gif)


>### Compatibility

**Laravel version**     | **Validators version**
-------- | ---
5.5      | 1.0.1
5.4 <=   | ? (not sure)



>### Installation

- This package is available through composer installation
```bash
    composer require lakshmaji/validators
```

- Try updating the application with composer (autloading class namespaces but not mandatory :wink:  )
```bash
  composer dump-autoload
```


>### Configurations

- Publish the configuration file.
```bash
    php artisan vendor:publish
```
- The configuration file will be published to your application **config** directory with the name * validators.php*.
- Configure the required validator namespaces and validator class paths.

- An example configuration file (validators.php).
```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validator namespace
    |--------------------------------------------------------------------------
    |
    | The namespace for the validator classes.
    |
     */
    'validator_namespace' => 'App\Validators',

    /*
    |--------------------------------------------------------------------------
    | Validator path
    |--------------------------------------------------------------------------
    |
    | The path to the validators folder.
    |
     */
    'validator_path' => 'app' . DIRECTORY_SEPARATOR . 'MyValidators' . DIRECTORY_SEPARATOR . 'MyRules',

];

```



>### Generating Validator

- Issue the following command in terminal
```bash
php artisan make:validator CreateVehicle
```

- This will generate the following class and located the path configured in validators.php
```php
<?php 

namespace App\MyValidators\MyRules;

use Lakshmaji\Validators\Laravel\LaravelValidator;
use Lakshmaji\Validators\Contracts\ValidableInterface;


/**
 * Class CreateVehicleValidator
 * @package App\MyValidators\MyRules
 */
class CreateVehicleValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * @var array
     */
    protected $rules = [
        'name' => 'required',
        'model' => 'required'
    ];

    /**
     * @var array
     */
    protected $messages = [
        'model.required' => 'Please specify the model number',
    ];
}
// end of CreateVehicleValidator class
```


>### Using it in action

```php
<?php
namespace App\Http\Controllers\Cars;

use App\MyValidators\MyRules\CreateVehicleValidator;


protected $request;
protected $validator;

public function  __construct(Request $request, CreateVehicleValidator $validator) {
  $this->validator = $validator;
  $this->request = $request;
}

public function store() {
  $payload = $this->request->all();

  // validate here
  if($this->validator->with($payload)->passes()) {
    // validation succedded
  } else {
    $errors = $this->validator->formatErrorMessages();
  }
}

```


>### MISCELLANEOUS

- After installing package you find the **artisan** commands in your project 
  ```bash
php artisan list
  ```

- OR
```bash
php artisan help make:validator
```

>### Thanks to 

[@parthshukla] (https://github.com/parthshukla) 

>### LICENSE

[MIT](https://opensource.org/licenses/MIT)


