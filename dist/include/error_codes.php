<?php
$base = 100000;
$x = 0;

//The API will return a non-200 status code and a 
// json encoded string with an 2d array of the following codes and
// some optional additional (depending on the code)

define("ERR_UNKNOWN",				$base+($x++)); //an unknown error

/////////////////////
// HTTP STATUS 417
/////////////////////
define("ERR_NO_DATA",				$base+($x++)); //the server is expecting data, but none was given
define("ERR_INVALID",				$base+($x++)); //the specified data was not valid
	// {"field": name}
define("ERR_BLANK",					$base+($x++)); //the specified data was blank 
	// {"field": name}
define("ERR_NOT_FOUND",			$base+($x++)); //the specified field was not found
	// {"field": name}
define("ERR_INVALID_EMAIL",	$base+($x++)); //the email address was not valid
	// {"field": name}
define("ERR_INVALID_PHONE",	$base+($x++)); //the phone number was not valid
	// {"field": name}
define("ERR_INVALID_URL",		$base+($x++)); //the url was not valid
	// {"field": name}
define("ERR_INVALID_PATH",	$base+($x++)); //the file path was not valid
	// {"field": name}
define("ERR_INVALID_BOOL",	$base+($x++)); //the boolean was not valid
	// {"field": name}
define("ERR_INVALID_MAC",	$base+($x++)); //the mac address was not valid
	// {"field": name}
define("ERR_TOO_SHORT",			$base+($x++)); //the field is too short
	// {"field": name}
define("ERR_TOO_LONG",			$base+($x++)); //the field is too long
	// {"field": name}
define("ERR_MISSING_REQ",		$base+($x++)); //a required field is missing
	// {"field": name}
define("ERR_EXISTS",			$base+($x++)); //the thing already exists in the system


/////////////////////
// HTTP STATUS 403
/////////////////////
define("ERR_NOT_SUPER",			$base+($x++)); //the action requires super user privs but you aren't
define("ERR_NOT_ADMIN",			$base+($x++)); //the action requires org admin or greater privs but you aren't
define("ERR_NOT_MANAGER",		$base+($x++)); //the action requires group manger or greater privs but you aren't

/////////////////////
// HTTP STATUS 500 
/////////////////////
define("ERR_AUTH_NET",			$base+($x++));

$_MESSAGES = array(
	ERR_UNKNOWN				=> 	"Ha ocurrido un error desconocido",
	ERR_NO_DATA				=> 	"Faltan datos",

	// Most 417 messages are written so that they can be appended to
	// a field name
	ERR_INVALID				=> 	"no es válido",
	ERR_BLANK 				=>	"no puede dejarse en blanco",
	ERR_NOT_FOUND			=>	"no se ha encontrado",
	ERR_INVALID_EMAIL =>	"no es un email válido",
	ERR_INVALID_PHONE	=>	"no es un número de teléfono válido",
	ERR_INVALID_URL		=>	"no es una url válida",
	ERR_INVALID_PATH	=>	"no es una dirección válida",
	ERR_INVALID_BOOL	=>	"no es un dato válido",
	ERR_INVALID_MAC		=>	"no es una dirección mac válida",
	ERR_TOO_SHORT			=>	"es demasiado corto",
	ERR_TOO_LONG 			=>	"es demasiado largo",
	ERR_MISSING_REQ 	=> "falta",
	ERR_EXISTS				=> "ya existe",

	ERR_NOT_SUPER			=> "Debes tener permisos de administrador para hacer eso",
	ERR_NOT_ADMIN			=>	"Debes tener permisos de administrador para hacer eso",
	ERR_NOT_MANAGER		=>	"Debes tener permisos de administrador para hacer eso"
);