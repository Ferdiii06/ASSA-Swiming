<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        $dbPrograms = \App\Models\Program::all();
        $programs = $dbPrograms->pluck('name')->filter()->unique()->values();
        $locations = $dbPrograms->pluck('pool_name')->filter()->unique()->values();

        return view('auth.register', compact('programs', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'phone' => 'required|string|max:20',
            'parent_name' => 'required|string|max:255',
            'address' => 'required|string',
            'program' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'schedule_day' => 'required|string|max:255',
            'schedule_time' => 'required|string',
            'source' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 1. Create the User (Parent)
        $user = \App\Models\User::create([
            'name' => $request->parent_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'parent',
        ]);

        // 2. Trigger Email Verification
        event(new \Illuminate\Auth\Events\Registered($user));

        // 3. Save Registration record
        Registration::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'age' => $request->age,
            'phone' => $request->phone,
            'parent_name' => $request->parent_name,
            'address' => $request->address,
            'program' => $request->program,
            'nominal' => $request->nominal,
            'location' => $request->location,
            'schedule_day' => $request->schedule_day,
            'schedule_time' => $request->schedule_time,
            'source' => $request->source,
            'status' => 'pending'
        ]);

        // 4. Append Student to students_spreadsheet.json so it shows in the realtime Dashboard
        $jsonPath = database_path('students_spreadsheet.json');
        if (file_exists($jsonPath)) {
            $studentsData = json_decode(file_get_contents($jsonPath), true);
            // Get max id
            $maxId = 0;
            foreach ($studentsData as $student) {
                if (isset($student['id']) && $student['id'] > $maxId) {
                    $maxId = $student['id'];
                }
            }
            $newId = $maxId + 1;
            
            $studentsData[] = [
                "id" => $newId,
                "code" => "ASSA-9" . str_pad($newId, 3, "0", STR_PAD_LEFT),
                "name" => strtoupper($request->name),
                "age" => $request->age,
                "parent_name" => $request->parent_name,
                "phone" => $request->phone,
                "address" => $request->address,
                "program" => $request->program,
                "nominal" => $request->nominal,
                "location" => $request->location,
                "schedule" => $request->schedule_day . ' ' . $request->schedule_time,
                "level" => "LEVEL 1",
                "progress" => 0,
                "status" => "Pending"
            ];
            file_put_contents($jsonPath, json_encode($studentsData, JSON_PRETTY_PRINT));
        }

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk melakukan verifikasi sebelum login.');
    }
}
