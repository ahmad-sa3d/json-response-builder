<?php

/**
 * Test Cases for JsonResponseBuilder
 *
 * @author  Ahmed Saad <a7mad.sa3d.2014@gmail.com>
 * @package Api Json Response Builder
 * @license MIT
 * @version 1.0.0 First Version
 */

use Orchestra\Testbench\TestCase;
use Saad\JsonResponseBuilder\JsonResponseBuilder;
use Test\Unit\BuilderTestSetup;

/**
 * @coversDefaultClass Saad\JsonResponseBuilder\JsonResponseBuilder
 */
class TestJsonResponseBuilder extends TestCase
{
	use BuilderTestSetup;

	/** @test */
	public function it_can_add_meta()
	{
		$this->builder->addMeta('name', 'Ahmed Saad');
		$this->assertArrayHasKey('name', $this->getMeta());
		$this->assertEquals('Ahmed Saad', $this->getMeta()['name']);
	}

	/**
	 * @test
	 */
	public function it_can_merge_meta_with_correct_value()
	{
		$this->builder->addMeta('name', 'Ahmed Saad');
		$this->builder->mergeMeta([
			'name' => 'Another Ahmed Saad',
			'age' => 29
		]);

		$this->assertEquals('Another Ahmed Saad', $this->getMeta()['name']);
		$this->assertArrayHasKey('age', $this->getMeta());
	}

	/** @test */
	public function it_can_add_data()
	{
		$this->builder->addData('name', 'Ahmed Saad');
		$this->assertArrayHasKey('name', $this->getData());
		$this->assertEquals('Ahmed Saad', $this->getData()['name']);
	}

	/** @test */
	public function it_can_merge_data_with_correct_value()
	{
		$this->builder->addData('name', 'Ahmed Saad');
		$this->builder->mergeData([
			'name' => 'Another Ahmed Saad',
			'age' => 29
		]);

		$this->assertEquals('Another Ahmed Saad', $this->getData()['name']);
		$this->assertArrayHasKey('age', $this->getData());
	}

	/** @test */
	public function it_can_merge_data_contains_meta_correctly()
	{
		$this->builder->mergeData([
			'name' => 'Another Ahmed Saad',
			'age' => 29,
			'meta' => [
				'name' => 'meta name',
			]
		]);

		$this->assertCount(2, $this->getData());
		$this->assertArrayHasKey('name', $this->getMeta());
	}

	/** @test */
	public function it_can_add_header()
	{
		$this->builder->addHeader('Content-Type', 'application/json');
		$this->assertArrayHasKey('Content-Type', $this->getHeaders());
		$this->assertEquals('application/json', $this->getHeaders()['Content-Type']);
	}

	/** @test */
	public function it_can_set_status_code()
	{
		$this->builder->setStatusCode(401);
		$this->assertEquals(401, $this->getStatusCode());
	}

	/** @test */
	public function it_can_set_success_status()
	{
		$this->builder->success();
		$this->assertEquals(true, $this->isSuccess());
	}

	/** @test */
	public function it_can_set_error_status()
	{
		$this->builder->error();
		$this->assertEquals(false, $this->isSuccess());
		$this->assertCount(2, $this->getError());
	}

	/** @test */
	public function it_can_set_success_status_with_message()
	{
		$this->builder->success('Success!');
		$this->assertEquals(true, $this->isSuccess());
		$this->assertEquals('Success!', $this->getMessage());
	}

	/** @test */
	public function it_can_set_error_status_with_message_and_error_code()
	{
		$this->builder->error('Fails!', 300);
		$error = $this->getError();

		$this->assertEquals('Fails!', $error['message']);
		$this->assertEquals('Fails!', $this->getMessage());
		$this->assertEquals(300, $error['code']);
	}

	/** @test */
	public function it_can_get_response_object()
	{
		$this->assertEquals('Illuminate\Http\JsonResponse', get_class($this->builder->getResponse()));
	}

	/** @test */
	public function it_can_get_response_with_setting_status_code()
	{
		$this->builder->getResponse(301);
		$this->assertEquals(301, $this->getStatusCode());
	}

	/** @test */
	public function it_can_get_response_with_errors_only_if_exists()
	{
		$this->builder->error();
		$this->builder->getResponse();

		$this->assertArrayHasKey('error', $this->getResponseArray());
	}

	/** @test */
	public function it_throws_errors_on_getting_response_with_invalid_status_code()
	{
		$this->expectException('InvalidArgumentException');
		$this->builder->getResponse(5064);
	}

	/** @test */
	public function it_can_set_response_message_explicity()
	{
		$this->builder->error('error message')
			->setMessage('iam a message');

		$this->assertEquals('iam a message', $this->getMessage());
	}

	/** @test */
	public function it_can_add_keys_to_error_array()
	{
		$this->builder->error('error message')
			->addError('key', 'val');

		$this->assertArrayHasKey('key', $this->getError());
		$this->assertEquals('val', $this->getError()['key']);
	}

	/** @test */
	public function it_through_exception_when_trying_to_add_error_before_calling_error_method()
	{
		$this->expectException('BadMethodCallException');
		$this->builder->addError('key', 'val');
	}

	/** @test */
	public function it_removes_error_array_if_status_become_success_after_error()
	{
		$this->builder->error('My Error!', 400)
				->success('My Success')
				->getResponse();

		$this->assertArrayNotHasKey('error', $this->getResponseArray());
	}
}