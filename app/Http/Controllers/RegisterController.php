<?php

namespace App\Http\Controllers;

use App\Register;
use App\Project;
use App\User;
use Exception;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function get($userId, $projectId, $id = null) {
        try {
            $user = User::find($userId);
            if (!$id) {
                $register = $user->registers()->where('project_id', $projectId)->get();
            } else {
                $register = $user->registers()->find($id);
            }
            return response()->json([
                'status' => 'success',
                'data' => $register,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function create(Request $request, $userId, $projectId) {
        try {
            $register = new Register();
            $register->user_id = $userId;
            $register->project_id = $projectId;
            $register->start = date("Y-m-d H:i:s"); // TODO: Receber data e hora do front
            $register->end = null;
            $register->save();
            return response()->json([
                'status' => 'success',
                'data' => $register,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function finish($id) {
        try {
            $register = Register::find($id);
            if (!$register)
                throw new Exception("Projeto não encontrado", 1);
            $register->end = date("Y-m-d H:i:s"); // TODO: Receber data e hora do front
            $register->save();
            return response()->json([
                'status' => 'success',
                'data' => $register,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    // TODO: Restringir update ao "dono" do registro
    public function update(Request $request, $id) {
        try {
            $register = Register::find($id);
            if (!$register)
                throw new Exception("Projeto não encontrado", 1);
            $register->name = $request->input('name');
            $register->description = $request->input('description');
            $register->save();
            return response()->json([
                'status' => 'success',
                'data' => $register,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    // TODO: Restringir delete ao "dono" do registro
    public function delete($id) {
        try {
            $register = Register::find($id);
            if (!$register)
                throw new Exception("Projeto não encontrado", 1);
            $register->delete();
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
