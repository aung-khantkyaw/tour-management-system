<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentQR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentQrController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentQR::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('qr_type', 'like', "%{$search}%");
            });
        }

        // Filter by QR type
        if ($request->filled('qr_type')) {
            $query->where('qr_type', $request->qr_type);
        }

        // Filter by amount type
        if ($request->filled('amount_type')) {
            if ($request->amount_type === 'generic') {
                $query->where('amount', 0);
            } elseif ($request->amount_type === 'specific') {
                $query->where('amount', '>', 0);
            }
        }

        $qrs = $query->orderBy('qr_type')->orderBy('amount')->get();
        return view('admin.payment-qrs.index', compact('qrs'));
    }

    public function create()
    {
        return view('admin.payment-qrs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'qr_type' => 'required|in:kbzpay,ayarpay,uabpay',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'qr_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = $request->file('qr_image')->store('qr-codes', 'public');

        PaymentQR::create([
            'qr_type' => $request->qr_type,
            'amount' => $request->amount,
            'description' => $request->description,
            'qr_image_path' => Storage::url($path)
        ]);

        return redirect()->route('admin.payment-qrs.index')->with('success', 'QR code created successfully');
    }

    public function edit(PaymentQR $paymentQr)
    {
        return view('admin.payment-qrs.edit', compact('paymentQr'));
    }

    public function update(Request $request, PaymentQR $paymentQr)
    {
        $request->validate([
            'qr_type' => 'required|in:kbzpay,ayarpay,uabpay',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'qr_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'qr_type' => $request->qr_type,
            'amount' => $request->amount,
            'description' => $request->description
        ];

        if ($request->hasFile('qr_image')) {
            if ($paymentQr->qr_image_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $paymentQr->qr_image_path));
            }
            $path = $request->file('qr_image')->store('qr-codes', 'public');
            $data['qr_image_path'] = Storage::url($path);
        }

        $paymentQr->update($data);

        return redirect()->route('admin.payment-qrs.index')->with('success', 'QR code updated successfully');
    }

    public function destroy(PaymentQR $paymentQr)
    {
        if ($paymentQr->qr_image_path) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $paymentQr->qr_image_path));
        }
        $paymentQr->delete();

        return redirect()->route('admin.payment-qrs.index')->with('success', 'QR code deleted successfully');
    }
}