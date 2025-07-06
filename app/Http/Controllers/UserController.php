<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // กำหนด middleware auth สำหรับทุก method
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    // แสดงรายการ user ทั้งหมด
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // สร้าง user ใหม่
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|array',
            'role.*' => 'in:Investor,Entrepreneur',
            'title_name' => 'required|in:Mr.,Mrs.,Miss',
            'name' => 'required|string',
            'surname' => 'required|string',
            'date_of_birth' => 'required|date',
            'phone_number' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'role' => $request->role,
            'title_name' => $request->title_name,
            'name' => $request->name,
            'surname' => $request->surname,
            'date_of_birth' => $request->date_of_birth,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    // แสดงข้อมูล user ตาม id
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    // แก้ไขข้อมูล user ตาม id
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'role' => 'sometimes|required|array',
            'role.*' => 'in:Investor,Entrepreneur',
            'title_name' => 'sometimes|required|in:Mr.,Mrs.,Miss',
            'name' => 'sometimes|required|string',
            'surname' => 'sometimes|required|string',
            'date_of_birth' => 'sometimes|required|date',
            'phone_number' => 'nullable|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // อัปเดตข้อมูลที่ได้รับมา
        if ($request->has('role')) {
            $user->role = $request->role;
        }
        if ($request->has('title_name')) {
            $user->title_name = $request->title_name;
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('surname')) {
            $user->surname = $request->surname;
        }
        if ($request->has('date_of_birth')) {
            $user->date_of_birth = $request->date_of_birth;
        }
        if ($request->has('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json($user);
    }

    // ลบ user ตาม id
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
           return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
