<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\SavedDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SavedDoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $savedDoctor = $request->user()->savedDoctor()->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Get all saved doctor successfully',
            'data' => $savedDoctor
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'doctor_id' => 'required|integer|exists:doctors,id'
        ]);
        if ($data->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid field',
                'errors' => $data->errors()
            ], 422);
        }
        $savedDoctor = $request->user()->savedDoctor()->create([
            'patient_id' => $request->user()->id,
            'doctor_id' => $request->doctor_id
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Saved doctor added successfully',
            'data' => $savedDoctor
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $savedDoctor = $request->user()->savedDoctor->findOrFail($id);
        if (!$savedDoctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Saved doctor not found'
            ], 404);
        }
        $savedDoctor->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Saved doctor removed successfully',
        ], 200);
    }
}
