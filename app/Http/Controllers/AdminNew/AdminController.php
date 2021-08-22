<?php

namespace App\Http\Controllers\AdminNew;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use File;
use Image;


class AdminController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	function index(){
		return view('adminnew.dashboard');
	}
}
