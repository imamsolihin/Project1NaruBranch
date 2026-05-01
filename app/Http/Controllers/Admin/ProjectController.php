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
        $query = Project::with(['division', 'user'])->latest();

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
            'division_id' => 'required',
            'deadline' => 'nullable|date'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $project = Project::create($data);

        $roleMap = [
            'super_admin' => 'Super Admin',
            'wakil_admin' => 'Wakil Admin',
            'admin' => 'Admin'
        ];
        $roleName = $roleMap[auth()->user()->role] ?? 'Admin';

        $division = Division::find($project->division_id);
        $divisionName = $division ? $division->name : '-';

        if ($project->assigned_user_id) {
            $assignedUser = \App\Models\User::find($project->assigned_user_id);
            $assignedName = $assignedUser ? $assignedUser->name : 'user';
            $desc = "{$roleName} membuat project {$project->title} yang ditujukan kepada {$assignedName} dari divisi {$divisionName}";
        } else {
            $desc = "{$roleName} membuat project {$project->title} yang ditujukan kepada divisi {$divisionName}";
        }

        ProjectHistory::create([
            'actor_id' => auth()->id(),
            'project_id' => $project->id,
            'action' => 'Buat',
            'project_title' => $project->title,
            'description' => $desc,
        ]);

        return redirect('/admin')->with('success', 'Project berhasil ditambahkan');
    }

    public function edit(Project $project)
    {
        $divisions = Division::all();
        $users = \App\Models\User::with('division')->where('role', 'user')->get();
        return view('admin.projects.edit', compact('project', 'divisions', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $project->update($request->all());

        $roleMap = [
            'super_admin' => 'Super Admin',
            'wakil_admin' => 'Wakil Admin',
            'admin' => 'Admin'
        ];
        $roleName = $roleMap[auth()->user()->role] ?? 'Admin';

        $division = Division::find($project->division_id);
        $divisionName = $division ? $division->name : '-';

        if ($project->assigned_user_id) {
            $assignedUser = \App\Models\User::find($project->assigned_user_id);
            $assignedName = $assignedUser ? $assignedUser->name : 'user';
            $desc = "{$roleName} mengubah data project {$project->title} yang ditujukan kepada {$assignedName} dari divisi {$divisionName}";
        } else {
            $desc = "{$roleName} mengubah data project {$project->title} yang ditujukan kepada divisi {$divisionName}";
        }

        ProjectHistory::create([
            'actor_id' => auth()->id(),
            'project_id' => $project->id,
            'action' => 'Edit',
            'project_title' => $project->title,
            'description' => $desc,
        ]);

        return redirect('/admin')->with('success', 'Project berhasil diupdate');
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

        return redirect('/admin')->with('success', 'Project berhasil dihapus');
    }
}