<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class VolunteerController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $volunteers = User::where('role', 'volunteer')->get();
        return $this->success($volunteers, 'List of all volunteers');
    }

    public function show($id)
    {
        $volunteer = User::where('role', 'volunteer')->find($id);

        if (!$volunteer) {
            return $this->error('Volunteer not found', 404);
        }

        return $this->success($volunteer, 'Volunteer details');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', Password::min(6)],
        ]);

        $volunteer = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'volunteer',
        ]);

        return $this->success($volunteer, 'Volunteer created successfully', 201);
    }
    public function destroy($id)
    {
        $volunteer = User::where('role', 'volunteer')->find($id);

        if (!$volunteer) {
            return $this->error('Volunteer not found', 404);
        }

        $volunteer->delete();

        return $this->success(null, 'Volunteer deleted successfully');
    }
}
