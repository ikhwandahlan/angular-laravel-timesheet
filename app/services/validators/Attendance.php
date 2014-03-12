<?php

namespace Services\Validators;

class Attendance extends Validator {
	public static $rules = [
			'date_from' => 'required|date',
			'date_to'   => 'required|date',
	];
}