<?php namespace Kivi\Services\Validation\Laravel;

use Illuminate\Validation\Factory;
use Kivi\Services\Validation\Contracts;
use Kivi\Services\Validation\AbstractValidator;

abstract class Validator extends AbstractValidator
{
	protected $validator;

	function __construct(Factory $validator) {
		$this->validator = $validator;
	}

	public function passes()
	{
		$validator = $this->validator->make($this->data, $this->rules);
		if($validator->fails()) {
			$this->errors = $validator->messages();
			return false;
		}
		return true;
	}
}