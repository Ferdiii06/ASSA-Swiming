<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Package;
use App\Models\Student;

class PaymentController extends Controller
{
    // Public: Show payment form
    public function create()
    {
        $packages = Package::all();
        
        $jsonPath = database_path('students_spreadsheet.json');
        if (file_exists($jsonPath)) {
            $students = collect(json_decode(file_get_contents($jsonPath)));
        } else {
            $students = collect([]);
        }

        return view('payments.create', compact('packages', 'students'));
    }

    // Public: Store payment
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'package_id' => 'required|exists:packages,id',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $package = Package::find($request->package_id);

        $payment = new Payment();
        // student_id dari dropdown (JSON data)
        $payment->student_id = $request->student_id;
        $payment->package_id = $request->package_id;
        $payment->amount = $package->price;
        $payment->payment_type = 'qris';
        $payment->payment_method = 'qris_manual';
        $payment->status = 'pending';
        
        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('payments', 'public');
            $payment->proof_image = $path;
        }

        $payment->save();

        return redirect()->route('payments.create')->with('success', 'Pembayaran berhasil dikirim! Menunggu konfirmasi Coach.');
    }

    // Admin/Coach: List all payments
    public function index()
    {
        $payments = Payment::with(['package'])->orderBy('created_at', 'desc')->get();
        
        // Map students from JSON
        $jsonPath = database_path('students_spreadsheet.json');
        if (file_exists($jsonPath)) {
            $studentsList = collect(json_decode(file_get_contents($jsonPath)));
            foreach ($payments as $payment) {
                $foundStudent = $studentsList->firstWhere('id', $payment->student_id);
                $payment->student_name = $foundStudent ? $foundStudent->name : 'Unknown Student';
            }
        } else {
            foreach ($payments as $payment) {
                $payment->student_name = 'Unknown Student';
            }
        }
        
        return view('payments.index', compact('payments'));
    }

    // Admin/Coach: Approve payment
    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'success';
        $payment->paid_at = now();
        $payment->save();

        // Here we could also extend the student's active period based on the package.
        // But for now, just approving the payment is enough for the prototype.

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil disetujui.');
    }
}
