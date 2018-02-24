<?php

/**
 * APIFormRequest class
 *
 * this class should be extended with apis FormRequests 
 * to get a standard formatted validation error response
 *
 * @author  Ahmed Saad <a7mad.sa3d.2014@gmail.com>
 * @package Api Json Response Builder
 * @license MIT
 * @version 1.2.0 First Version
 */

namespace Saad\JsonResponseBuilder;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Saad\JsonResponseBuilder\JsonResponseBuilder;

/**
 * @codeCoverageIgnore
 */
class ApiFormRequest extends FormRequest
{
	/**
	 * Response status code
	 * @var integer
	 */
	protected static $status_code = 422;

	/**
	 * Set Custom Response Error Code
	 * 
	 * @param integer $value status code
	 */
	public static function setStatusCode($value = null)
	{
		self::$status_code = $value ?: self::$status_code;
	}

	/**
	 * Send Validation Error Response
	 * 
	 * @param  array  $errors errors array
	 * @return JsonResponse         response
	 */
	public function response(array $errors)
	{
		if ($this->expectsJson()) {
            return (new JsonResponseBuilder())
    			->error('Validation Errors', $this->responseCode())
    			->addError('validation', [
	            	'first' => reset($errors)[0],
	            	'errors' => $errors,
	            	'errors_array' => array_collapse(array_values($errors)),
    			])
    			->setMessage('Validation Errors')
    			->getResponse();
        }
	}

	/**
	 * Get Response Status Code
	 * @return integer status code
	 */
	public function responseCode()
	{
		return self::$status_code;
	}

	/**
	 * Format Errors Bag
	 * 
	 * @param  Validator $validator Validator instance
	 * @return array               Validation errors
	 */
	public function formatErrors(Validator $validator)
	{
		return $validator->errors()->toArray();
	}
}