<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Public/Customer/Orders');
    }

    public function botiquin()
    {
        return Inertia::render('Public/Customer/Cabinet');
    }
}