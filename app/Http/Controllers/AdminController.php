<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Division;

class AdminController extends Controller
{
    public function index()
    {
        $projects = Project::with('division')->paginate(10);
        $divisions = Division::all();

        return view('admin.dashboard', compact('projects', 'divisions'));
    }
}