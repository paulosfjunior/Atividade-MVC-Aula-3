<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use Exception;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index()
    {
        try {
            $users = $this->model->all();
            $usersCollection = new UserCollection($users);
            return response()->json($usersCollection, 200);
        } catch (Exception $e) {
            return response()->json([
                'title' => 'Erro',
                'msg' => 'Erro interno do servidor'
            ], 500);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $address = \Correios::cep($request->zipcode);

            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($user->password);
            $user->address = $address['logradouro'];
            $user->neighborhood = $address['bairro'];
            $user->city = $address['cidade'];
            $user->state = $address['uf'];
            $user->save();
            $usersResource = new UserResource($user);

            return response()->json($usersResource, 200);
        } catch (Exception $e) {
            return response()->json([
                'title' => 'Erro',
                'msg' => 'Erro interno do servidor'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->model->findOrFail($id);
            $usersResource = new UserResource($user);
            
            return response()->json($usersResource, 200);
        } catch (Exception $e) {
            return response()->json([
                'title' => 'Erro',
                'msg' => 'Erro interno do servidor'
            ], 500);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->model->find($id);

            if ($user) {
                $user->fill($request->all());
                $user->save();

                $usersResource = new UserResource($user);
                return response()->json($usersResource, 200);
            } else {
                return response()->json([
                    'title' => 'Erro',
                    'msg' => 'ID não encontrado'
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'title' => 'Erro',
                'msg' => 'Erro interno do servidor'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->model->find($id);

            if ($user) {
                $user->delete();

                return response()->json([], 204);
            } else {
                return response()->json([
                    'title' => 'Erro',
                    'msg' => 'ID não encontrado'
                ], 500);
            }
        } catch (Exception $e) {
            dd($e);
            return response()->json([
                'title' => 'Erro',
                'msg' => 'Erro interno do servidor'
            ], 500);
        }
    }
}
