<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StorePatientRequest;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
  public function index()
  {
    $patients = Patient::all();
    return response()->json($patients);
  }

  public function store(StorePatientRequest $request)
  {
    $validated = $request->validated();
    $path = $request->file('document_photo')->store('documents', 'public');

    $patient = new Patient([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
      'phone_number' => $validated['phone_number'],
      'document_photo' => $path,
      'address' => $validated['address'],
    ]);

    $patient->save();

    return response()->json(['message' => 'Patient registered successfully!'], 201);
  }
}
