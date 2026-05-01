<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserHistory;
use App\Models\ProjectHistory;

class HistoryController extends Controller
{
    public function users()
    {
        $histories = UserHistory::with('actor')->latest()->paginate(15);
        return view('admin.histories.users', compact('histories'));
    }

    public function projects()
    {
        $histories = ProjectHistory::with(['actor', 'project'])->latest()->paginate(15);
        return view('admin.histories.projects', compact('histories'));
    }
}
