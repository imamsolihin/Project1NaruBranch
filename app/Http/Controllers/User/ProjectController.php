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
        
        // Project yang berkaitan dengan user (sebagai pembuat, penerima tugas, atau divisi tujuan)
        $projects = Project::with(['divisions', 'user', 'assignedUsers'])
            ->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhereHas('assignedUsers', function($subQ) use ($user) {
                      $subQ->where('users.id', $user->id);
                  })
                  ->orWhereHas('divisions', function($subQ) use ($user) {
                      $subQ->where('divisions.id', $user->division_id);
                  });
            })
            ->latest()->paginate(10);

        // Project dari divisi lain (tidak ditujukan untuk divisi user, dan tidak ditugaskan khusus ke user ini)
        $allProjects = Project::with(['divisions', 'user'])
            ->whereDoesntHave('divisions', function($q) use ($user) {
                $q->where('divisions.id', $user->division_id);
            })
            ->whereDoesntHave('assignedUsers', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->where('user_id', '!=', $user->id)
            ->latest()->paginate(10);

        return view('user.projects.index', compact('projects', 'allProjects'));
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
            'deadline' => $request->deadline,
            'user_id' => $user->id,
        ]);

        if ($user->division_id) {
            $project->divisions()->attach($user->division_id);
        }

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
        if ($project->user_id !== $user->id && !$project->assignedUsers->contains($user->id) && !$project->divisions->contains('id', $user->division_id)) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $user = Auth::user();
        if ($project->user_id !== $user->id && !$project->assignedUsers->contains($user->id) && !$project->divisions->contains('id', $user->division_id)) {
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
        if ($project->user_id !== $user->id && !$project->assignedUsers->contains($user->id) && !$project->divisions->contains('id', $user->division_id)) {
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
