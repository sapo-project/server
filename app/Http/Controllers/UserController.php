<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get($id = null) {
        try {
            if (!$id) {
                $user = User::all();
            } else {
                $user = User::find($id);
            }
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function create(Request $request) {
        try {
            $user = User::where('email', $request->input('email'))->first();
            if ($user)
                throw new Exception("Usuário já cadastrado.", 1);
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $user = User::find($id);
            if (!$user)
                throw new Exception("Usuário não encontrado.", 1);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id) {
        try {
            $user = User::find($id);
            if (!$user)
                throw new Exception("Usuário não encontrado.", 1);
            $user->delete();
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

    public function login(Request $request) {
        try {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                throw new Exception("Usuário não encontrado.", 1);
            }
            if (!Hash::check($request->input('password'), $user->password)) {
                throw new Exception("Senha não confere.", 1);
            } else {
                $user->id = $user->_id;
                return response()->json([
                    'status' => 'success',
                    'data' => $user
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
