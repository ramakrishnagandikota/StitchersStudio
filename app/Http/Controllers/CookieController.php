<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
     public function setCookie(Request $request) {
      $minutes = 525600;
      $response = new Response('Cookie set successfully');
      $response->withCookie(cookie('ga_cookie', true, $minutes));
      return $response;
   }
   public function getCookie(Request $request) {
      $value = $request->cookie('ga_cookie');
      echo $value;
   }

   public function deleteCookie(Request $request) {
      $cookie = \Cookie::forget('ga_cookie');
      return $cookie;
   }
}
