<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Division;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'desc');
        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }

        $projects = Project::with(['division', 'user'])->orderBy('created_at', $sort)->paginate(10);
        $divisions = Division::all();

        return view('admin.dashboard', compact('projects', 'divisions', 'sort'));
    }
}