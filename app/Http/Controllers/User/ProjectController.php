<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['division', 'user'])->latest()->paginate(10);
        return view('user.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('user.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'deadline' => 'nullable|date'
        ]);

        $user = Auth::user();

        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'division_id' => $user->division_id,
            'deadline' => $request->deadline,
            'user_id' => $user->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Project created successfully');
    }

    public function edit(Project $project)
    {
        $user = Auth::user();
        if ($project->division_id !== $user->division_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $user = Auth::user();
        if ($project->division_id !== $user->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:pending,ongoing,done',
            'deadline' => 'nullable|date'
        ]);

        $project->update($request->only(['title', 'description', 'status', 'deadline']));

        return redirect()->route('dashboard')->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        $user = Auth::user();
        if ($project->division_id !== $user->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project deleted successfully');
    }
}
