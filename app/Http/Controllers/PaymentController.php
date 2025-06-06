<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Payment;
use Illuminate\View\View;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $payments = Payment::all();
        return view('payments.index')->with('payments', $payments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Nếu cần danh sách enrollments để chọn:
        // $enrollments = \App\Models\Enrollment::pluck('id', 'id');
        // return view('payments.create', compact('enrollments'));
        return view('payments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        Payment::create($input);
        return redirect('payments')->with('flash_message', 'Payment Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $payment = Payment::find($id);
        return view('payments.show')->with('payments', $payment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $payment = Payment::find($id);
        return view('payments.edit')->with('payments', $payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $payment = Payment::find($id);
        $input = $request->all();
        $payment->update($input);
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
