<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Expertise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\title;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::get()->paginate(10);
        return response()->json([
            'status' => 'success',
            'message' => 'Get all doctors successfully',
            'data' => $doctors
        ], 200);
    }
    public function show(string $id)
    {
        $doctor = Doctor::where('id', $id);
        return response()->json([
            'status' => 'success',
            'message' => 'Get doctor successfully',
            'data' => $doctor
        ], 200);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'specialty' => 'required|string',
            'description' => 'required|string',
            'experience' => 'required|string',
            'location' => 'required|string',
            'price' => 'required|decimal:0,2|min:0.01',
            'duration' => 'required|integer|min:1',
            'expertise' => 'required|array|min:3',
            'expertise.*.title' => 'required|string',
            'expertise.*.content' => 'required|string',
        ]);
        if ($data->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid field',
                'errors' => $data->errors()
            ], 422);
        }
        $doctor = Doctor::create([
            'name' => $request->name,
            'specialty' => $request->specialty,
            'description' => $request->description,
            'experience' => $request->experience,
            'location' => $request->location,
            'price' => $request->price,
            'duration' => $request->duration,
        ]);
        $expertise = Expertise::create([
            'title' => $request->expertise->title,
            'content' => $request->expertise->content,
            'doctor_id' => $doctor->id
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Doctor added successfully',
            'data' => array_merge($doctor->toArray(), ['expertises' => $expertise])
        ], 201);
    }
}
