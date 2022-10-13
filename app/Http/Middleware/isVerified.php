<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class isVerified
{
    public function handle($request, Closure $next)
    {
        try{

            if(!Session::get('user')) {
                echo "Anda tidak memiliki hak akses ke halaman ini.";
                return redirect('/login');
            }

            $ROLE = Session::get('user')->role;
            $URL  = $request->path();

            $SETTING = _settingSidebar();

            if(array_key_exists($URL, $SETTING)){

                if(!in_array($ROLE, $SETTING[$URL])){
                    
                    echo "Anda tidak memiliki hak akses ke halaman ini.";
                    return redirect()->back();

                }

            }else{

                echo "[SB Middleware] Error: Url " . $URL . " belum di set.";
                exit();

            }

            return $next($request);
                
        }catch (Exception $e) {
            return redirect(url('/'));
        }
    }
}
