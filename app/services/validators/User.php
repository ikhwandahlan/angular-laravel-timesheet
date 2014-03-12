<?php

namespace Services\Validators;

class User extends Validator {
	public static $rules = [
			'name'     => 'required|max:150',
			'username' => 'required|alpha_dash|unique:users|max:50',
			'email'    => 'required|email|max:150|unique:users',
			'password' => 'min:8',
			'rate'     => 'numeric',
	];
}