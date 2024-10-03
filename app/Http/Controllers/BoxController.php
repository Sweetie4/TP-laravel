<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Box;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function index(){
        return view('box', ['boxes'=>Box::all()]);
    }
}
