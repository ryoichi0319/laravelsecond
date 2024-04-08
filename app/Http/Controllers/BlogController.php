<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('Blogs/index');
    }
    public function create()
    {
        return Inertia::render('Blogs/create');
    }
}

