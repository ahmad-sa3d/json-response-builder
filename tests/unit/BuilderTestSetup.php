<?php

/**
 * This Trait is helper trait for Testing JsonResponseBuilder
 *
 * @author  Ahmed Saad <a7mad.sa3d.2014@gmail.com>
 * @package Api Json Response Builder
 * @license MIT
 * @version 1.0.0 First Version
 */
namespace Test\Unit;

use Saad\JsonResponseBuilder\JsonResponseBuilder;
use PHPUnit_Framework_Assert;

trait BuilderTestSetup {

	protected $builder;

	/**
	 * Setup for each test case
	 * @return void
	 */
	public function setup()
	{
		parent::setup();
		$this->builder = new JsonResponseBuilder();
	}

	/**
	 * Get Protected Response Array
	 * @return array which contains response array
	 */
	public function getResponseArray()
	{
		return PHPUnit_Framework_Assert::readAttribute($this->builder, 'response');
	}

	/**
	 * Get Builder response meta
	 * @return array meta array
	 */
	protected function getMeta() {
		return $this->getResponseArray()['meta'];
	}

	/**
	 * Get Builder protected data
	 * @return array data array
	 */
	protected function getData() {
		return $this->getResponseArray()['data'];
	}

	/**
	 * Get Builder protected headers
	 * @return array headers array
	 */
	protected function getHeaders() {
		return PHPUnit_Framework_Assert::readAttribute($this->builder, 'headers');
	}

	/**
	 * Get Builder protected message
	 * @return array message array
	 */
	protected function getMessage() {
		return $this->getResponseArray()['message'];
	}

	/**
	 * Get Builder protected success
	 * @return array success array
	 */
	protected function isSuccess() {
		return $this->getResponseArray()['success'];
	}

	/**
	 * Get Builder protected statusCode
	 * @return array statusCode array
	 */
	protected function getStatusCode() {
		return PHPUnit_Framework_Assert::readAttribute($this->builder, 'statusCode');
	}

	/**
	 * Get Builder protected strict_mode
	 * @return bool strict_mode
	 */
	protected function getStrictMode() {
		return PHPUnit_Framework_Assert::readAttribute($this->builder, 'strict_mode');
	}

	/**
	 * Get Builder protected errors
	 * @return array errors array
	 */
	protected function getError() {
		return PHPUnit_Framework_Assert::readAttribute($this->builder, 'error');
	}
}