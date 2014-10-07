<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"         => "El :attribute debe ser aceptado.",
	"active_url"       => "El :attribute no es una URL válida.",
	"after"            => "El :attribute debe ser una fecha posterior a :date.",
	"alpha"            => "El :attribute debe contener solo letras.",
	"alpha_dash"       => "El :attribute puede contener solo letras, números, y guiones.",
	"alpha_num"        => "El :attribute puede contener solo letras y números.",
	"alpha_spaces"     => "El :attribute puede contener solo letras y espacios en blanco.",
	"array"            => "El :attribute debe ser un arreglo.",
	"before"           => "El :attribute debe ser una fecha anterior a :date.",
	"between"          => array(
		"numeric" => "El :attribute debe estar entre :min y :max.",
		"file"    => "El :attribute debe estar entre :min y :max kilobytes.",
		"string"  => "El :attribute debe estar entre :min y :max caracteres.",
		"array"   => "El :attribute debe tener entre :min y :max items.",
	),
	"confirmed"        => "La confirmación de valores no coincide.",
	"date"             => "El :attribute no es una fecha válida.",
	"date_format"      => "El :attribute no posee el formato :format.",
	"different"        => "El :attribute y :other deben ser diferentes.",
	"digits"           => "El :attribute debe tener :digits digitos.",
	"digits_between"   => "El :attribute debe estar entre :min y :max digitos.",
	"email"            => "El :attribute tiene un formato inválido.",
	"exists"           => "La selección :attribute es inválida.",
	"image"            => "El :attribute debe ser una imagen.",
	"in"               => "La selección :attribute es inválida.",
	"integer"          => "El :attribute debe ser un entero.",
	"ip"               => "El :attribute debe ser una dirección IP válido.",
	"max"              => array(
		"numeric" => "El campo :attribute no debe ser mayor a :max.",
		"file"    => "El campo :attribute no debe ser mayor a :max kilobytes.",
		"string"  => "El campo :attribute no debe ser mayor a :max caracteres.",
		"array"   => "El campo :attribute no debe tener mas de :max items.",
	),
	"mimes"            => "El :attribute debe ser un archivo de tipo: :values.",
	"min"              => array(
		"numeric" => "El campo :attribute debe ser por lo menos :min.",
		"file"    => "El campo :attribute debe tener por lo menos :min kilobytes.",
		"string"  => "El campo :attribute debe tener por lo menos :min caracteres.",
		"array"   => "El campo :attribute debe tener por lo menos :min items.",
	),
	"not_in"           => "La seleccion :attribute es inválida.",
	"numeric"          => "El campo :attribute debe ser un número.",
	"regex"            => "El campo :attribute tiene un formato inválido.",
	"required"         => "El campo :attribute es requerido.",
	"required_if"      => "El campo :attribute es requerido cuando :other es :value.",
	"required_with"    => "El campo :attribute es requerido cuando :values está presente.",
	"required_without" => "El campo :attribute es requerido cuando :values no está presente.",
	"same"             => "Los campos :attribute y :other deben coincidir.",
	"size"             => array(
		"numeric" => "El campo :attribute debe ser :size.",
		"file"    => "El campo :attribute debe tener :size kilobytes.",
		"string"  => "El campo :attribute debe tener :size caracteres.",
		"array"   => "El campo :attribute debe tener :size items.",
	),
	"unique"           => "El campo :attribute ya ha sido tomado.",
	"url"              => "El campo :attribute tiene un formato inválido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
