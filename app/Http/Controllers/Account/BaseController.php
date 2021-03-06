<?php

namespace App\Http\Controllers\Account;;

use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Controller;
    
    
class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('printshow');
        $this->middleware('checkPermission')->except('printshow','profile');
    }
}