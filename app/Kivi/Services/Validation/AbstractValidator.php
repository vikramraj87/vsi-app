<?php namespace Kivi\Services\Validation;

abstract class AbstractValidator implements Contract {
	protected $validator;

	protected $data = array();

	protected $rules = array();

	protected $errors = array();

	public function with(array $data) 
	{
		$this->data = $data;
		return $this;
	}

	public function errors()
	{
		return $this->errors;
	}	

	abstract function passes();
}