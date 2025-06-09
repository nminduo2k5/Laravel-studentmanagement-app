<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\View\View;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $payments = Payment::with('enrollment.student', 'enrollment.batch')->get();
        return view('payments.index')->with('payments', $payments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $enrollments = Enrollment::with('student', 'batch')
            ->get()
            ->map(function($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'text' => "#{$enrollment->enroll_no} - {$enrollment->student->name} ({$enrollment->batch->name})"
                ];
            })
            ->pluck('text', 'id');
        return view('payments.create', compact('enrollments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);
        
        Payment::create($validated);
        return redirect('payments')->with('flash_message', 'Payment Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $payment = Payment::with('enrollment.student', 'enrollment.batch')->find($id);
        return view('payments.show')->with('payments', $payment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $payment = Payment::find($id);
        $enrollments = Enrollment::with('student', 'batch')
            ->get()
            ->map(function($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'text' => "#{$enrollment->enroll_no} - {$enrollment->student->name} ({$enrollment->batch->name})"
                ];
            })
            ->pluck('text', 'id');
        return view('payments.edit', compact('payment', 'enrollments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);
        
        $payment = Payment::find($id);
        $payment->update($validated);
        return redirect('payments')->with('flash_message', 'Payment Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Payment::destroy($id);
        return redirect('payments')->with('flash_message', 'Payment deleted!');
    }
}
