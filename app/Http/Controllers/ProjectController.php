<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Division;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('division')->latest()->get();
        return view('admin.dashboard', compact('projects'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('admin.projects.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        Project::create($request->all());

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project berhasil ditambahkan');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('success', 'Project berhasil dihapus');
    }
}