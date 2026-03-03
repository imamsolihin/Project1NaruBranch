<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Division;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('division')->latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('admin.projects.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'division_id' => 'required'
        ]);

        Project::create($request->all());

        return redirect('/admin')->with('success', 'Project berhasil ditambahkan');
    }

    public function edit(Project $project)
    {
        $divisions = Division::all();
        return view('admin.projects.edit', compact('project', 'divisions'));
    }

    public function update(Request $request, Project $project)
    {
        $project->update($request->all());

        return redirect('/admin')->with('success', 'Project berhasil diupdate');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect('/admin')->with('success', 'Project berhasil dihapus');
    }
}