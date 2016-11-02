<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index() {
    	$user = 'omarcelh';
    	$friends = ['acel', 'tifani', 'dll'];
    	$groups = ['dogs', 'corgi'];
        return view('home', compact('user', 'friends', 'groups'));
    }
}

?>