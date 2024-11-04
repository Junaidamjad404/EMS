<?php

namespace App\Http\Controllers\Attendee;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Category;
use App\Enums\EventStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AboutUsController extends Controller
{
    public function index(){
        $events = Event::where('status',EventStatus::Approved->value)->where('date', '>', Carbon::now())->get();
        $categories=Category::all();
        return view('Attendees.about', compact('events','categories'));
        
    }
}
