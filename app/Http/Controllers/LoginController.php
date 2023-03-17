<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class LoginController extends Controller
{
    //Login-Logout Sysytem

    public function noter_login_action(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('users')->attempt(['username' => $request->username, 'password' => $request->password]))
         {
            //########## auth the function
            $noter = User::where('username', $request->username)->first();
            $noter_info=User::where('username', $request->username)->select('first_name', 'last_name', 'email')->first();
            $authorizationExists = true;
            while ($authorizationExists) {
                $Authorization = Str::random(40);
                $authorizationExists = DB::table('users')->where('Authorization', $Authorization)->exists();
            }
            $noter->Authorization = $Authorization;
            $noter->last_login_at = now();
            $noter->save(); 
            $noter->save(); 
            //return data to front
              return response()->json([
                "noter" => $noter_info,
                "Authorization" => $Authorization
            ]);
            //#######//########## auth the function
        }
        return response()->json(['ok' => "wrong username or password"], 200);
        
    }//done with test ddd

    public function noter_logout(Request $request){
        //###### auth user logout function start
        $Authorization = $request->header('Authorization');
        if (!$Authorization) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $noter = User::where('Authorization', $Authorization)->first();
        if (!$noter) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
        //###### auth logout function end

        $noter->update(['Authorization' => null]);

        Auth::guard('users')->logout();
        return response()->json(['ok' => "logout successfully"], 200);
       
    }//done with test ddd
    //************************************** */

    
}
