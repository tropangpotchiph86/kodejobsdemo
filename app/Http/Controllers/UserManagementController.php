<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the role from the request query parameters
        $role = $request->query('role', 'all');

        // Apply filtering based on the role
        if ($role !== 'all') {
            $users = User::where('role', $role)->paginate(10);
        } else {
            $users = User::paginate(10);
        }

        // Count users by roles
        $totalUsers = User::count();
        $adminUsers = User::where('role', 'admin')->count();
        $hrUsers = User::where('role', 'HR')->count();
        $normalUsers = User::where('role', 'normal')->count();

        // Pass all these variables to the view
        return view('users.manage', compact('users', 'totalUsers', 'adminUsers', 'hrUsers', 'normalUsers'));
    }

    public function updateRole(Request $request, User $user)
    {
        // Validate the role
        $data = $request->validate([
            'role' => 'required|in:normal,HR,admin'
        ]);

        // Update the user's role
        $user->update([
            'role' => $data['role']
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('message', 'User role updated successfully.');
    }

    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6',
            'role' => 'required|in:normal,HR,admin'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('manage.users')->with('message', 'User created successfully');
    }
}
