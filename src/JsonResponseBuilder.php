<?php

/**
 * JsonResponseBuilder class
 *
 * @author  Ahmed Saad <a7mad.sa3d.2014@gmail.com>
 * @package Api Json Response Builder
 * @license MIT
 * @version 1.2.0 First Version
 */

namespace Saad\JsonResponseBuilder;

use Illuminate\Http\JsonResponse;
use Saad\JsonResponseBuilder\Contracts\JsonResponseBuilderContract;

class JsonResponseBuilder implements JsonResponseBuilderContract{

	/**
	 * Response Array
	 * @var Array
	 */
	protected $response;

	/**
	 * Status Code
	 * @var Integer
	 */
	protected $statusCode;

	/**
	 * Response Headers
	 * @var array
	 */
	protected $headers;

	/**
	 * Error
	 * @var array
	 */
	protected $error;

	/**
	 * Check if strick mode
	 *
	 * if ok, empty meta and data will be null
	 * @var bool
	 */
	protected $strict_mode;

	/**
	 * Constructor
	 */
	public function __construct(bool $strict_mode = true)
	{
		$this->response = [
			'meta' => [],
			'data' => [],
			'success' => true,
			'message' => 'Successfully Retrieved',
		];

		$this->statusCode = 200;
		$this->headers = [];

		$this->strictMode($strict_mode);
	}

	/**
	 * Set Strict Mode
	 * 
	 * @param bool $strict_mode   key
	 * @return JsonResponseBuilder Current Instance
	 */
	public function strictMode(bool $strict_mode = true) {
		$this->strict_mode = $strict_mode;
		return $this;
	}

	/**
	 * Add Meta
	 * @param string $key   key
	 * @param mixed $value value
	 * @return JsonResponseBuilder Current Instance
	 */
	public function addMeta($key, $value) {
		$this->response['meta'][$key] = $value;
		return $this;
	}

	/**
	 * Merge Meta
	 * @param array $meta   meta array
	 * @return JsonResponseBuilder Current Instance
	 */
	public function mergeMeta(array $meta) {
		$this->response['meta'] = array_merge($this->response['meta'], $meta);
		return $this;
	}

	/**
	 * Add Data
	 * @param string $key   key
	 * @param mixed $value value
	 * @param bool $parse_meta value
	 * @return JsonResponseBuilder Current Instance
	 */
	public function addData($key, $value, bool $parse_meta = false) {
		if ($parse_meta) {
			$this->parseMeta($value);
		}

		$this->response['data'][$key] = $value;
		return $this;
	}

	/**
	 * Merge Data
	 * @param array $data   data array
	 * @return JsonResponseBuilder Current Instance
	 */
	public function mergeData(array $data) {
		$this->parseMeta($data);		
		$this->response['data'] = array_merge($this->response['data'], $data);
		return $this;
	}

	/**
	 * Add Header
	 * @param string $key   key
	 * @param mixed $value value
	 * @return JsonResponseBuilder Current Instance
	 */
	public function addHeader($key, $value) {
		$this->headers[$key] = $value;
		return $this;
	}

	/**
	 * Set Response Status To success
	 * @param integer $status_code  Status Code
	 * @return JsonResponseBuilder Current Instance
	 */
	public function success($message = null) {
		$this->setSuccess(true);
		$this->setMessage($message);

		return $this;
	}

	/**
	 * Set Response Message
	 * @param string $message  Message
	 * @return JsonResponseBuilder Current Instance
	 */
	public function setMessage($message = null) {
		if ($message) {
			$this->response['message'] = (string) $message;
		}

		return $this;
	}


	/**
	 * Set Response Status To Error
	 * @param integer $status_code  Status Code
	 * @return JsonResponseBuilder Current Instance
	 */
	public function error($message = null, $error_code = null) {
		$this->setSuccess(false);

		if (!$this->error) {
			$this->error = [];
		}

		$this->error['message'] = $message ?: '';
		$this->error['code'] = $this->statusCode;

		$this->setMessage($message);

		if ($error_code) {
			$this->error['code'] = $error_code;
		}

		return $this;
	}

	/**
	 * Add Error To Errors Array
	 * @param string $key   Key
	 * @param mixed $value Value
	 * @return JsonResponseBuilder Current Instance
	 */
	public function addError($key, $value)
	{
		if (!$this->error) {
			throw new \BadMethodCallException(__METHOD__ . ' you have to call error() method first before start adding errors.');
		}

		$this->error[$key] = $value;
		return $this;
	}

	/**
	 * Set Response Status Code
	 * @param integer $status_code  Status Code
	 * @return JsonResponseBuilder Current Instance
	 */
	public function setStatusCode($status_code) {
		$this->statusCode = (int) $status_code;
		return $this;
	}

	/**
	 * Get Response
	 * @param integer $status_code  Status Code
	 */
	public function getResponse($status_code = null) {
		if ($status_code) {
			$this->setStatusCode($status_code);
		}

		if ($this->error) {
			$this->response['error'] = $this->error;
		}

		if ($this->strict_mode) {
			if (empty($this->response['meta'])) {
				$this->response['meta'] = null;
			}

			if (empty($this->response['data'])) {
				$this->response['data'] = null;
			}
		}

		return new JsonResponse($this->response, $this->statusCode, $this->headers);
	}

	/**
	 * Set Success
	 * @param bool $value
	 * @return JsonResponseBuilder Current Instance
	 */
	protected function setSuccess(bool $value)
	{
		$this->response['success'] = $value;

		if ($value) {
			$this->error = null;
		}

		return $this;
	}

	/**
	 * Parse Meta
	 * @param  [type] &$data [description]
	 * @return [type]        [description]
	 */
	protected function parseMeta(&$data)
	{
		if (isset($data['meta'])) {
			$meta = $data['meta'];
			unset($data['meta']);
			$this->mergeMeta($meta);
		}
	}
}