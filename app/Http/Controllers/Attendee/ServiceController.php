<?php

namespace App\Http\Controllers\Attendee;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index(){
       $events = Event::where('date', '>', Carbon::now())->get();
       $categories=Category::all();
        return view('Attendees.service', compact('events','categories'));
    }
}
