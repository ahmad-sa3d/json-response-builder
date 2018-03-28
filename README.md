<p align="center">
	<img src="https://laravel.com/assets/img/components/logo-laravel.svg">
	<h1 align="center">Json Response Builder Package</h1>
</p>

<p align="center">
<a href="https://travis-ci.org/ahmad-sa3d/json-response-builder"><img src="https://travis-ci.org/ahmad-sa3d/json-response-builder.svg?branch=master" alt="Build Status"></a>
<a href="https://codeclimate.com/github/ahmad-sa3d/json-response-builder/maintainability"><img src="https://api.codeclimate.com/v1/badges/84d709814a320dc85f0a/maintainability" /></a>
<a href="https://codeclimate.com/github/ahmad-sa3d/json-response-builder/test_coverage"><img src="https://api.codeclimate.com/v1/badges/84d709814a320dc85f0a/test_coverage" /></a>
<a href="https://packagist.org/packages/saad/json-response-builder"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>


### Install
``` bash
	composer require saad/json-response-builder
```

### Change Log
> `V 1.3`

Add Strict Mode and enabled by default:
in strict mode if data or meta are empty it will set it's value to `null` instead of `[]`

to turn of strickt mode, on constructor pass `false` to disable strickt mode so that it will return data, and meta as empty array if they are empty

you can set mode on instance by the method `strictMode(bool)`
	
### Usage

* Basic Example:
	
	inside your controller:

		
	``` php
		
		$builder = new Saad\JsonResponseBuilder\JsonResponseBuilder();
		
		$builder->mergeData([
			['name' => 'Ahmed Saad'],
			['name' => 'John Doe']
		]);
		
		$builder->addMeta([
			'pagination' => [
				'page' => 1,
				'per_page' => 4,
			]
		]);
		
		return $builder->getResponse();
		
	```



* the above example will output:

	``` javascript
	
		{
			"success": true,
			
			"meta" : {
				"pagination": {
					"page": 1,
					"per_page": 4
				}
			},
			
			"data": [
				{"name": "Ahmed Saad"},
				{"name": "John Doe"}
			],
			
			"message": "Successfully Retrieved"
		}

	```

	
## Available Methods

### `addData($key, $value)`
> 	Appends to data new member with the given key and value
> 
> ``` php
> 	$builder->addData('doctors', ['ahmed', 'mohamed', 'saad']);
>	$builder->addData('patients', ['patient1', 'patient3', 'patient3']);
>
> 	// Output data will be 
> 
>	"data": {
>		"doctors": ["ahmed", "mohamed", "saad"],
>		"patients" ["patient1", "patient4", "patient3"]
>	},
> 
> 
> ```


### `mergeData($array)`
> 	merge given array with data with given array keys as keys, this is usefull when we want to send data as json array insteadof json object with key and value
> 
> this method also if the given array has key called 'meta' it will remove that key and add it to response meta
> 
> ``` php
> 	$builder->mergeData(['ahmed', 'mohamed', 'meta' => ['key' => 'Iam Meta']]);
>
> 	// Output will be 
> 
> 	{
>	 	"success": true,
>	 	"meta": {
>	 		"key": "Iam Meta"
>	 	},	
>		"data": [
>			"ahmed",
>			"mohamed"
>		],
>		"message": "Successfully Retrieved"
>	}
>		 
> ```

### `addMeta($key, $value)`
> 	Appends to meta new member with the given key and value

### `mergeMeta($array)`
> 	merge given array with meta


### `addHeader($header, $value)`
> 	add header to response headers


### `success($response_message = null)`
> 	set response success status to __`true`__, and set response message if supplied.


### `setMessage($response_message = null)`
> 	set response message if supplied.


### `error($message = null, $error_code = null)`

> 	set response success status to __`false`__ and set nessage and error code
> 
> 	``` php
> 	$builder->error('Fails!', 2345);
>
> 	// Output will be 
> 
> 	{
>	 	"success": false,
>	 	"meta": null,	
>		"data": null,
>		'error': {
>			"message": "Fails!",
>			"code": 2345
>		}
>		"message": "Fails!"
>	}


### `addError($key, mixed $value)`

> 	Add key to error array
> 
> 	``` php
> 	$builder->error('Fails!', 2345)
>		->addError('validation', 'validation value');
>
> 	// Output will be 
> 
> 	{
>	 	"success": false,
>	 	"meta": null,	
>		"data": null,
>		'error': {
>			"message": "Fails!",
>			"code": 2345,
> 			"validation": "validation value"
>		}
>		"message": "Fails!"
>	}


### `setStatusCode(301)`
> 	set response status code.

### `strictMode(bool)`

> default value `true`
> 
> since `V1.3`
> 
> enable or disable strict mode.
>
> 	``` php
> 	$builder->getResponse();
>
> 	// Strict Mode Enabled, Output will be 
> 
> 	{
>	 	"success": false,
>	 	"meta": null,	
>		"data": null,
>		"message": ""
>	}
>
>	$builder->strictMode(false)->getResponse();
>
> 	// Strict Mode Disabled, Output will be 
> 
> 	{
>	 	"success": false,
>	 	"meta":[],	
>		"data":[],
>		"message": ""
>	}

### `getResponse($status_code = null)`
> 	set response status code if supplied, and return Response Object

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).README.md