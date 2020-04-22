<?php

namespace App\Http\Controllers;

use App\models\Plati;

class SectionsController extends Controller
{
    public function index($id, Plati $plati)
    {
        return view('index');
    }
}
