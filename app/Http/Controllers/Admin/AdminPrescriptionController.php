<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class AdminPrescriptionController extends Controller
{
    /**
     * List all prescriptions (read-only).
     */
    public function index(Request $request)
    {
        $query = Prescription::with(['user', 'product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        $prescriptions = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.prescriptions.index', compact('prescriptions'));
    }
}
