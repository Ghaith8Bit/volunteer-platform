<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class OrganizerController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $organizers = User::where('role', 'organizer')->get();
        return $this->success($organizers, 'List of all organizers');
    }

    public function show($id)
    {
        $organizer = User::where('role', 'organizer')->find($id);

        if (!$organizer) {
            return $this->error('Organizer not found', 404);
        }

        return $this->success($organizer, 'Organizer details');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', Password::min(6)],
        ]);

        $organizer = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'organizer',
        ]);

        return $this->success($organizer, 'Organizer created successfully', 201);
    }

    public function destroy($id)
    {
        $organizer = User::where('role', 'organizer')->find($id);

        if (!$organizer) {
            return $this->error('Organizer not found', 404);
        }

        $organizer->delete();

        return $this->success(null, 'Organizer deleted successfully');
    }

}
