<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Http\Requests\PetRequest;
use App\Http\Resources\Pet as PetResources;
use App\Http\Resources\PetCollection;
use Exception;

class PetController extends Controller
{
    protected $model;

    public function __construct(Pet $pet)
    {
        $this->model = $pet;
    }

    public function index()
    {
        $pets = $this->model->all();
        $petsCollection = new PetCollection($pets);
        return response()->json($petsCollection, 200);
    }

    public function store(PetRequest $request)
    {
        try {
            $pet = new Pet();
            $pet->fill($request->all());
            $pet->save();
            $petsResource = new PetResources($pet);

            return response()->json($petsResource, 200);
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
            $pet = $this->model->findOrFail($id);
            $petsResource = new PetResources($pet);

            return response()->json($petsResource, 200);
        } catch (Exception $e) {
            dd($e);
            return response()->json([
                'title' => 'Erro',
                'msg' => 'Erro interno do servidor'
            ], 500);
        }
    }

    public function update(PetRequest $request, $id)
    {
        try {
            $pet = $this->model->find($id);

            if ($pet) {
                $pet->fill($request->all());
                $pet->save();
                $petsResource = new PetResources($pet);

                return response()->json($petsResource, 200);
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
            $pet = $this->model->find($id);
            
            if ($pet) {
                $pet->delete();
    
                return response()->json(null, 204);
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
}
