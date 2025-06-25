<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of the destinations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // You can add logic here to fetch destinations from the database
        // For now, we'll just return the view
        return view('destinations');
    }
}

