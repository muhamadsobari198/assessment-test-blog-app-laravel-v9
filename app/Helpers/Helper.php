<?php

use Illuminate\Support\Facades\Session;

function _generateToken($length = 50)
{
    $c    = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $cl   = strlen($c);
    $data = '';

    for ($i = 0; $i < $length; $i++) {
        $data .= $c[rand(0, $cl - 1)];
    }

    return $data;
}

function _settingSidebar()
{
	/*
        --- R  O  L  E ---
        1 : Super
        ------------------
    */

	$setting = [
		'admin/articles'    => [1],
	];

	return $setting;
}

function _checkSidebar($URL)
{

	if(!Session::get('user')) {
		echo "Anda tidak memiliki hak akses ke halaman ini.";
		exit();
	}
	

	$ROLE    = Session::get('user')->role;
	$SETTING = _settingSidebar();
	
	if(array_key_exists($URL, $SETTING)){

		if(!in_array($ROLE, $SETTING[$URL])){
			return false;
		}

	}else{
		return false;
	}

	return true;
}


