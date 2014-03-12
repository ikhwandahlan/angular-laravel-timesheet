<?php

namespace Services\Validators;

abstract class Validator {
	protected $attributes;
	public $errors;
	public $validator;

	public function __construct($attributes = NULL) {

		$this->attributes = $attributes ? : \Input::all();
		$this->validator  = \Validator::make($this->attributes, static::$rules);

	}

	public function passes() {

		if ($this->validator->passes()) return TRUE;

		$this->errors = $this->validator->messages()->all();

		return FALSE;
	}

}