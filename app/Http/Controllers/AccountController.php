<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy danh sách theo role
        $admins = User::where('role', 'admin')->get();
        $staffs = User::where('role', 'staff')->get();
        $customers = User::where('role', 'customer')->get();

        // Truyền dữ liệu sang view
        return view('admin.accountViews.accountManagement', compact('admins', 'staffs', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email' ,
            'phone'    => 'nullable|string|max:15',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:admin,staff,customer',
            'status'   => 'required|in:active,inactive',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $request->status,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Tạo tài khoản thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('accounts.index')->with('error', 'Tài khoản không tồn tại!');
        }

        return view('admin.accountViews.accountEdit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('accounts.index')->with('error', 'Tài khoản không tồn tại!');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,staff,customer',
            'status' => 'required|in:active,inactive',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->status = $request->status;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('accounts.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('accounts.index')->with('error', 'Tài khoản không tồn tại!');
        }

        $user->delete();

        return redirect()->route('accounts.index')->with('success', 'Xóa tài khoản thành công!');
    }
}
