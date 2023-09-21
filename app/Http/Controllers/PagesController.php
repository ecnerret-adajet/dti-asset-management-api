<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function home()
    {
        return Inertia::render('Home');
    }

    public function inventory()
    {
        return Inertia::render('Inventory');
    }

    public function masterData()
    {
        return Inertia::render('MasterData');
    }

    public function accounts()
    {
        return Inertia::render('accounts');
    }
}
