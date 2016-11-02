<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index() {
    	$user = 'omarcelh';
    	$friends = ['acel', 'tifani', 'dll'];
    	$groups = ['dogs', 'corgi'];
        return view('home', compact('user', 'friends', 'groups'));
    }

    public function login(Request $request) {

    }

    public function register(Request $request) {
    	echo json_encode($request->all());
    }
}

?>