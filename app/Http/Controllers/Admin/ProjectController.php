<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Division;
use App\Models\ProjectHistory;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['divisions', 'user', 'assignedUsers'])->latest();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereHas('user', function($q) use ($search) {
                $q->whereRaw('LOWER(name) like ?', ['%' . $search . '%']);
            });
        }

        $projects = $query->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $divisions = Division::all();
        $users = \App\Models\User::with('division')->where('role', 'user')->get();
        return view('admin.projects.create', compact('divisions', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'division_ids' => 'required|array',
            'division_ids.*' => 'exists:divisions,id',
            'assigned_user_ids' => 'nullable|array',
            'assigned_user_ids.*' => 'exists:users,id',
            'deadline' => 'nullable|date'
        ]);

        $data = $request->except(['division_ids', 'assigned_user_ids']);
        $data['user_id'] = auth()->id();
        $project = Project::create($data);

        $project->divisions()->sync($request->division_ids);
        $project->assignedUsers()->sync($request->assigned_user_ids ?? []);

        $roleMap = [
            'super_admin' => 'Super Admin',
            'wakil_admin' => 'Wakil Admin',
            'admin' => 'Admin'
        ];
        $roleName = $roleMap[auth()->user()->role] ?? 'Admin';

        $divNames = Division::whereIn('id', $request->division_ids)->pluck('name')->join(', ');
        
        if (!empty($request->assigned_user_ids)) {
            $userNames = \App\Models\User::whereIn('id', $request->assigned_user_ids)->pluck('name')->join(', ');
            $desc = "{$roleName} membuat project {$project->title} yang ditujukan kepada user ({$userNames}) dari divisi ({$divNames})";
        } else {
            $desc = "{$roleName} membuat project {$project->title} yang ditujukan kepada divisi ({$divNames})";
        }

        ProjectHistory::create([
            'actor_id' => auth()->id(),
            'project_id' => $project->id,
            'action' => 'Buat',
            'project_title' => $project->title,
            'description' => $desc,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil ditambahkan');
    }

    public function edit(Project $project)
    {
        $divisions = Division::all();
        $users = \App\Models\User::with('division')->where('role', 'user')->get();
        return view('admin.projects.edit', compact('project', 'divisions', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'division_ids' => 'required|array',
            'division_ids.*' => 'exists:divisions,id',
            'assigned_user_ids' => 'nullable|array',
            'assigned_user_ids.*' => 'exists:users,id',
            'status' => 'required|in:pending,ongoing,done',
            'deadline' => 'nullable|date'
        ]);

        $project->update($request->except(['division_ids', 'assigned_user_ids']));

        $project->divisions()->sync($request->division_ids);
        $project->assignedUsers()->sync($request->assigned_user_ids ?? []);

        $roleMap = [
            'super_admin' => 'Super Admin',
            'wakil_admin' => 'Wakil Admin',
            'admin' => 'Admin'
        ];
        $roleName = $roleMap[auth()->user()->role] ?? 'Admin';

        $divNames = Division::whereIn('id', $request->division_ids)->pluck('name')->join(', ');
        
        if (!empty($request->assigned_user_ids)) {
            $userNames = \App\Models\User::whereIn('id', $request->assigned_user_ids)->pluck('name')->join(', ');
            $desc = "{$roleName} mengubah data project {$project->title} yang ditujukan kepada user ({$userNames}) dari divisi ({$divNames})";
        } else {
            $desc = "{$roleName} mengubah data project {$project->title} yang ditujukan kepada divisi ({$divNames})";
        }

        ProjectHistory::create([
            'actor_id' => auth()->id(),
            'project_id' => $project->id,
            'action' => 'Edit',
            'project_title' => $project->title,
            'description' => $desc,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diupdate');
    }

    public function destroy(Project $project)
    {
        $title = $project->title;
        $project->delete();

        $roleMap = [
            'super_admin' => 'Super Admin',
            'wakil_admin' => 'Wakil Admin',
            'admin' => 'Admin'
        ];
        $roleName = $roleMap[auth()->user()->role] ?? 'Admin';

        ProjectHistory::create([
            'actor_id' => auth()->id(),
            'project_id' => null,
            'action' => 'Hapus',
            'project_title' => $title,
            'description' => "{$roleName} menghapus project {$title}",
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil dihapus');
    }
}