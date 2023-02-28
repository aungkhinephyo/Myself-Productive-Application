<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\Event;
use App\Models\Journal;
use App\Models\Library;
use App\Models\Project;
use App\Models\Todolist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPageController extends Controller
{
    public function home()
    {
        $id = auth()->id();

        $todayTodolistCount = Todolist::where('user_id', $id)
            ->where('date', date('Y-m-d'))
            ->where('status', 0)
            ->count();

        $completedTodolistCount = Todolist::where('user_id', $id)
            ->where('status', 1)
            ->count();

        $activities = Todolist::where('user_id', $id)
            ->where('status', 1)
            ->latest('date')
            ->take(8)
            ->get();

        $events = Event::where('user_id', $id)
            ->where('start_date', date('Y-m-d'))
            ->get();

        $noteCount = Note::where('user_id', $id)->count();
        $journalCount = Journal::where('user_id', $id)->count();
        $libraryCount = Library::where('user_id', $id)->count();
        $projectCount = Project::where('user_id', $id)->count();

        #For chart
        $start = now()->startOfMonth()->subDay()->format('Y-m-d');
        $data = Todolist::where('user_id', $id)
            ->where('date', '>', $start)
            ->orderBy('date', 'asc')
            ->where('status', 1)
            ->select('id', 'date')
            ->get()
            ->groupBy('date');

        $days = [];
        $trackData = [];
        foreach ($data as $day => $values) {
            $days[] = Carbon::parse($day)->format('M j');
            $trackData[] = count($values);
        }

        return view(
            'user.home',
            compact(
                'todayTodolistCount',
                'completedTodolistCount',
                'activities',
                'events',
                'noteCount',
                'journalCount',
                'libraryCount',
                'projectCount',
                'days',
                'trackData'
            )
        );
    }

    public function contact()
    {
        return view('user.contact');
    }
}
