<?php

/**
 * Interface of JsonResponseBuilder
 *
 * @author  Ahmed Saad <a7mad.sa3d.2014@gmail.com>
 * @package Api Json Response
 * @license MIT
 * @version 1.0.0 First Version
 */
namespace Saad\JsonResponseBuilder\Contracts;

interface JsonResponseBuilderContract{
	
	/**
	 * Add Meta
	 * @param string $key   key
	 * @param mixed $value value
	 */
	public function addMeta($key, $value);

	/**
	 * Merge Meta
	 * @param array $meta   meta to merge
	 */
	public function mergeMeta(array $meta);

	/**
	 * Add Data
	 * @param string $key   key
	 * @param mixed $value value
	 */
	public function addData($key, $value);

	/**
	 * Merge Data
	 * @param array $data   data to merge
	 */
	public function mergeData(array $data);

	/**
	 * Add Header
	 * @param string $key   key
	 * @param mixed $value value
	 */
	public function addHeader($key, $value);

	/**
	 * Set Response Status To success
	 * @param integer $status_code  Status Code
	 */
	public function success($message);

	/**
	 * Set Response Status To Error
	 * @param integer $status_code  Status Code
	 */
	public function error($message, $error_code);

	/**
	 * Set Response Status Code
	 * @param integer $status_code  Status Code
	 */
	public function setStatusCode($status_code);

	/**
	 * Set Response
	 * @param integer $status_code  Status Code
	 */
	public function getResponse($status_code);
}