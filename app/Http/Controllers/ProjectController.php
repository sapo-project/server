<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Exception;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function get($userId, $id = null) {
        try {
            $user = User::find($userId);
            if (!$id) {
                $project = $user->projects;
            } else {
                $project = $user->projects()->find($id);
            }
            return response()->json([
                'status' => 'success',
                'data' => $project,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function create(Request $request, $userId) {
        try {
            $project = new Project();
            $project->name = $request->input('name');
            $project->description = $request->input('description');
            $project->user_id = $userId;
            $project->save();
            return response()->json([
                'status' => 'success',
                'data' => $project,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    // TODO: Restringir update ao "dono" do projeto
    public function update(Request $request, $id) {
        try {
            $project = Project::find($id);
            if (!$project)
                throw new Exception("Projeto não encontrado", 1);
                $project->name = $request->input('name');
                $project->description = $request->input('description');
                $project->save();
            return response()->json([
                'status' => 'success',
                'data' => $project,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    // TODO: Restringir delete ao "dono" do projeto
    public function delete($id) {
        try {
            $project = Project::find($id);
            if (!$project)
                throw new Exception("Projeto não encontrado", 1);
            $project->delete();
            return response()->json([
                'status' => 'success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
