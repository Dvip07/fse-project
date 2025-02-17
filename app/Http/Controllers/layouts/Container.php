<?php

namespace App\Http\Controllers\layouts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Container extends Controller
{
  public function index()
  {
    $pageConfigs = ['contentLayout' => 'compact'];
    return view('content.layouts-example.layouts-container', ['pageConfigs' => $pageConfigs]);
  }
}
