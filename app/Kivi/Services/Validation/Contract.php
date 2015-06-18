<?php namespace Kivi\Services\Validation;

interface Contract {

	public function with(array $input);

	public function passes();

	public function errors();
}