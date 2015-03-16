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

	"accepted"             => "The :attribute must be accepted.",
	"active_url"           => "The :attribute is not a valid URL.",
	"after"                => "The :attribute must be a date after :date.",
	"alpha"                => "The :attribute may only contain letters.",
	"alpha_dash"           => "The :attribute may only contain letters, numbers, and dashes.",
	"alpha_num"            => "The :attribute may only contain letters and numbers.",
	"array"                => "The :attribute must be an array.",
	"before"               => "The :attribute must be a date before :date.",
	"between"              => array(
		"numeric" => "The :attribute must be between :min and :max.",
		"file"    => "The :attribute must be between :min and :max kilobytes.",
		"string"  => "The :attribute must be between :min and :max characters.",
		"array"   => "The :attribute must have between :min and :max items.",
	),
	"confirmed"            => "The :attribute confirmation does not match.",
	"date"                 => "The :attribute is not a valid date.",
	"date_format"          => "The :attribute does not match the format :format.",
	"different"            => "The :attribute and :other must be different.",
	"digits"               => "The :attribute must be :digits digits.",
	"digits_between"       => "The :attribute must be between :min and :max digits.",
	"email"                => "El :attribute tiene que ser un correo electrónico valido.",
	"exists"               => "The selected :attribute is invalid.",
	"image"                => "The :attribute must be an image.",
	"in"                   => "The selected :attribute is invalid.",
	"integer"              => "The :attribute must be an integer.",
	"ip"                   => "The :attribute must be a valid IP address.",
	"max"                  => array(
		"numeric" => "The :attribute may not be greater than :max.",
		"file"    => "The :attribute may not be greater than :max kilobytes.",
		"string"  => "The :attribute may not be greater than :max characters.",
		"array"   => "The :attribute may not have more than :max items.",
	),
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => array(
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => "El campo de :attribute debe contener al menos :min caracteres.",
		"array"   => "The :attribute must have at least :min items.",
	),
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => "El campo de :attribute es requerido.",
	"required_if"          => "El campo de :attribute es requerido cuando el campo de :other es :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => array(
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	),
	"unique"               => "The :attribute has already been taken.",
	"url"                  => "The :attribute format is invalid.",

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

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
		'PackProducts' => array(
			'min' => 'Debes ingresar al menos :min productos al paquete.',
			'required' => 'Debes ingresar al menos un producto al paquete.',
		),
		'PacksProductsSale' => array(
			'min' => 'Debes ingresar al menos :min producto o paquete a la venta.',
			'required' => 'Debes ingresar al menos 1 producto o paquete a la venta.',
		),
		'sale_id' => array(
			'exists' => 'La venta no existe.',
			'unique' => 'Ya existe asociado un elemento a esta venta'
		),
		'name' => array(
			'unique' => 'El nombre especificado ya existe'
		)
	),

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

	'attributes' => array(
		'name' => 'nombre' ,
		'email' => 'correo electrónico' ,
		'address' => 'dirección' ,
		'phone' => 'teléfono' ,
		'username' => 'nombre de usuario' ,
		'password' => 'contraseña' ,
		'password_confirmation' => 'Confirma la contraseña',
		'role_id' => 'tipo de usuario' ,
		'employee_type_id' => 'tipo de empleado' ,
		'salary' => 'salario',
		'employee[salary]' => 'salario',
		'image_profile' => 'imagen de perfil',
		'client_type_id' => 'tipo de cliente',
		'entry_date' => 'fecha de entrada',
		'street' => 'calle',
		'outer_number' => 'número exterior',
		'inner_number' => 'número interior',
		'zip_code'  => 'código postal',
		'colony' => 'colonia',
		'city' => 'delegación o municipio',
		'state' => 'estado',
		'rfc' => 'RFC',
		'business_name' => 'razón social',
		'key' => 'código',
		'image' => 'imagen',
		'description' => 'descripción',
		'model' => 'modelo',
		'stock' => 'stock',
		'price' => 'precio',
		'cost' => 'costo',
		'production_days' => 'días de producción',
		'sheet' => 'folio',
		'sale_type' => 'tipo de venta',
		'sale_date' => 'fecha de venta',
		'pay_type' => 'forma de pago',
		'liquidation_date' => 'fecha de liquidación',
		'employee_id' => 'vendedor',
		'client_id' => 'cliente',
		'PacksProductsSale' => 'productos y/o paquetes',
		'add_stock' => 'agregar productos',
		'down_payment' => 'pago inicial',
		'quantity' => 'cantidad',
		'town' => 'delegación o municipio',
		'type' => 'tipo',
		'delivery_date' => 'fecha de entrega',
		'destination_id' => 'destino',
		'expense_type_id' => 'tipo',
		'date' => 'fecha',
		'concept' => 'concepto',
		'employee_name' => ' ',
		'residue' => 'saldo de la empresa',
		'init_date' => 'fecha de inicio',
		'end_date' => 'fecha de fin',
		'show_by' => 'ver por',
		'new_destination' => ' ',
		'destination_name' => ' ',
		'user' => 'usuario',
		'suggested_price_active' => 'aplicar precio sugerido',
		'percent_gain' => 'porcentaje de ganancia',
		'showDetailsInputs' => ' ',
		'store_id' => 'sucursal'

	),

);
