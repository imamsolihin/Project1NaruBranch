<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $projects = DB::table('projects')->get();
        foreach ($projects as $project) {
            if ($project->division_id) {
                DB::table('division_project')->insert([
                    'project_id' => $project->id,
                    'division_id' => $project->division_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if ($project->assigned_user_id) {
                DB::table('project_user')->insert([
                    'project_id' => $project->id,
                    'user_id' => $project->assigned_user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropForeign(['assigned_user_id']);
            $table->dropColumn(['division_id', 'assigned_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('division_id')->nullable()->constrained();
            $table->foreignId('assigned_user_id')->nullable()->constrained('users');
        });

        $divisions = DB::table('division_project')->get();
        foreach ($divisions as $div) {
            DB::table('projects')->where('id', $div->project_id)->update(['division_id' => $div->division_id]);
        }

        $users = DB::table('project_user')->get();
        foreach ($users as $user) {
            DB::table('projects')->where('id', $user->project_id)->update(['assigned_user_id' => $user->user_id]);
        }
    }
};
