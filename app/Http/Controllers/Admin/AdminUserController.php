<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * User list with role filter and search.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create doctor form.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a new doctor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:6',
            'title'             => 'required|string|max:255',
            'bio'               => 'required|string|max:2000',
            'price'             => 'required|numeric|min:0',
            'rating'            => 'nullable|numeric|min:0|max:5',
            'review_count'      => 'nullable|integer|min:0',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'specializations'   => 'nullable|string',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'doctor-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $imagePath = 'images/' . $filename;
        }

        // Parse specializations from comma-separated string
        $specializations = null;
        if (!empty($validated['specializations'])) {
            $specializations = array_map('trim', explode(',', $validated['specializations']));
            $specializations = array_filter($specializations);
            $specializations = array_values($specializations);
        }

        User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role'              => 'doctor',
            'title'             => $validated['title'],
            'bio'               => $validated['bio'],
            'price'             => $validated['price'],
            'rating'            => $validated['rating'] ?? 0,
            'review_count'      => $validated['review_count'] ?? 0,
            'image'             => $imagePath,
            'specializations'   => $specializations,
        ]);

        return redirect()->route('admin.users.index', ['role' => 'doctor'])
            ->with('success', 'Doctor created successfully!');
    }

    /**
     * Show edit user form.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|in:patient,doctor,admin',
        ];

        // Add doctor-specific validation when role is doctor
        if ($request->role === 'doctor') {
            $rules['title']           = 'required|string|max:255';
            $rules['bio']             = 'required|string|max:2000';
            $rules['price']           = 'required|numeric|min:0';
            $rules['rating']          = 'nullable|numeric|min:0|max:5';
            $rules['review_count']    = 'nullable|integer|min:0';
            $rules['image']           = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
            $rules['specializations'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        // Handle doctor-specific fields
        if ($validated['role'] === 'doctor') {
            $data['title']        = $validated['title'];
            $data['bio']          = $validated['bio'];
            $data['price']        = $validated['price'];
            $data['rating']       = $validated['rating'] ?? $user->rating;
            $data['review_count'] = $validated['review_count'] ?? $user->review_count;

            // Handle image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = 'doctor-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $data['image'] = 'images/' . $filename;
            }

            // Parse specializations
            if (isset($validated['specializations']) && !empty($validated['specializations'])) {
                $specs = array_map('trim', explode(',', $validated['specializations']));
                $data['specializations'] = array_values(array_filter($specs));
            } else {
                $data['specializations'] = null;
            }
        }

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Delete user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'You cannot delete your own account.'], 403);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
    }
}
