<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = Project::with(['division', 'user'])
            ->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('assigned_user_id', $user->id)
                  ->orWhere(function($subQ) use ($user) {
                      $subQ->where('division_id', $user->division_id)
                           ->whereNull('assigned_user_id');
                  });
            })
            ->latest()->paginate(10);
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

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'division_id' => $user->division_id,
            'deadline' => $request->deadline,
            'user_id' => $user->id,
        ]);

        ProjectHistory::create([
            'actor_id' => $user->id,
            'project_id' => $project->id,
            'action' => 'Buat',
            'project_title' => $project->title,
            'description' => 'User ' . $user->name . ' membuat project ' . $project->title,
        ]);

        return redirect()->route('dashboard')->with('success', 'Project created successfully');
    }

    public function edit(Project $project)
    {
        $user = Auth::user();
        if ($project->user_id !== $user->id && $project->assigned_user_id !== $user->id && ($project->division_id !== $user->division_id || $project->assigned_user_id !== null)) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $user = Auth::user();
        if ($project->user_id !== $user->id && $project->assigned_user_id !== $user->id && ($project->division_id !== $user->division_id || $project->assigned_user_id !== null)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:pending,ongoing,done',
            'deadline' => 'nullable|date'
        ]);

        $project->update($request->only(['title', 'description', 'status', 'deadline']));

        ProjectHistory::create([
            'actor_id' => $user->id,
            'project_id' => $project->id,
            'action' => 'Edit',
            'project_title' => $project->title,
            'description' => 'User ' . $user->name . ' mengupdate project ' . $project->title,
        ]);

        return redirect()->route('dashboard')->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        $user = Auth::user();
        if ($project->user_id !== $user->id && $project->assigned_user_id !== $user->id && ($project->division_id !== $user->division_id || $project->assigned_user_id !== null)) {
            abort(403, 'Unauthorized action.');
        }

        $title = $project->title;
        $project->delete();

        ProjectHistory::create([
            'actor_id' => $user->id,
            'project_id' => null,
            'action' => 'Hapus',
            'project_title' => $title,
            'description' => 'User ' . $user->name . ' menghapus project ' . $title,
        ]);

        return redirect()->route('dashboard')->with('success', 'Project deleted successfully');
    }
}
