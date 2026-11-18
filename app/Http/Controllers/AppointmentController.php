<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $appointment = $request->user()->appointment->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Get all appointment successfully',
            'data' => $appointment
        ], 200);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'doctor_id' => 'required|integer|exists:doctors,id',
            'payment_method' => 'required|in:debit_card,credit_card,paypal',
            'coupon_code' => 'nullable|exists:promo_codes,code'
        ]);
        if ($data->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid field',
                'errors' => $data->errors()
            ], 422);
        }
        $doctor = Doctor::findOrFail($request->doctor_id);
        $price = $doctor->price;
        $pricePaid = $price;
        $appointment = Appointment::create([
            'patient_id' => $request->user()->id,
            'doctor_id' => $request->doctor_id,
            'payment_method' => $request->payment_method,
            'coupon_code' => $request->coupon_code,
            'price_paid' => $pricePaid,
            'status' => 'Waiting for Confirmation'
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Appointment created successfully',
            'data' => $appointment
        ], 200);
    }
}
