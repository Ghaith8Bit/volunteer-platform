<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return $this->success($admins, 'List of all admins');
    }

    public function show($id)
    {
        $admin = User::where('role', 'admin')->find($id);

        if (!$admin) {
            return $this->error('Admin not found', 404);
        }

        return $this->success($admin, 'Admin details');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', Password::min(6)],
        ]);

        $admin = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return $this->success($admin, 'Admin created successfully', 201);
    }
}
