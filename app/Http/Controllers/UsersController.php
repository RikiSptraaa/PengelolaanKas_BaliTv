<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(request()->user);
        if (request()->has('search')) {
            $users = User::where('name', 'LIKE', '%' . request()->search . '%')->orWhere('username', 'LIKE', '%' . request()->search . '%')->latest()->paginate(5);
        } else {
            $users = User::latest()->paginate(5);
        }


        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'unique:users,username|required',
            'password' => 'required_with:password_confirmation|same:password_confirmation|required|min:6',
            'password_confirmation' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'name' => $validator->errors()->get('name'),
                'username' => $validator->errors()->get('username'),
                'password' => $validator->errors()->get('password'),
                'password_confirmation' => $validator->errors()->get('password_confirmation'),
                'status' => false,
                'message' => "Data Gagal Diubah!"
            ], 422);
        } else {
            // MCompany::where('parent_id', 0)->update([
            //     // 'company_name' => $request->nama_koperasi,
            //     'legal_entity' => $request->badan_hukum,
            //     'company_address' => $request->alamat,
            // ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'name' => $request->name,
                'username' => $request->username,
                'status' => true,
                'message' => "Data Berhasil Ditambah!"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return response()->json([
            "data" => $user->toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        // dd($request->all());


        //update kalo ada password yang dinput
        if ($request->has('old_password') && !is_null($request->old_password)) {
            //validator
            if ($request->username === $user->username) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'username' => 'required',
                    'password' => 'required_with:password_confirmation|same:password_confirmation|required|min:6',
                    'password_confirmation' => 'required|min:6'
                ]);
            } else {

                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'username' => 'unique:users,username|required',
                    'password' => 'required_with:password_confirmation|same:password_confirmation|required|min:6',
                    'password_confirmation' => 'required|min:6'
                ]);
            }
            if (Hash::check($request->old_password, $user->password)) {
                if ($validator->fails()) {
                    return response()->json([
                        'name' => $validator->errors()->get('name'),
                        'username' => $validator->errors()->get('username'),
                        'old_password' => '',
                        'password' => $validator->errors()->get('password'),
                        'password_confirmation' => $validator->errors()->get('password_confirmation'),
                        'status' => false,
                        'message' => "Pengguna Gagal Diubah!"
                    ], 422);
                }
                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'password' => Hash::make($request->password)
                ]);

                return response()->json([
                    'status' => true,
                    'message' => "Pengguna berhasil diubah dengan passwordnya!"
                ]);
            } else {
                if ($validator->fails()) {
                    return response()->json([
                        'name' => $validator->errors()->get('name'),
                        'username' => $validator->errors()->get('username'),
                        'old_password' => 'Password harus sama dengan password lama',
                        'password' => $validator->errors()->get('password'),
                        'password_confirmation' => $validator->errors()->get('password_confirmation'),
                        'status' => false,
                        'message' => "Pengguna Gagal Diubah!"
                    ], 422);
                }
            }
        }
        //kalo gaada inputan password
        else {

            if ($request->username == $user->username) {

                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'username' => 'required',
                ]);
            } else {

                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'username' => 'required|unique:users',
                ]);
            }

            if ($validator->fails()) {
                return response()->json([
                    'name' => $validator->errors()->get('name'),
                    'username' => $validator->errors()->get('username'),
                    'status' => false,
                    'message' => "Pengguna Gagal Diubah!"
                ], 422);
            }

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Pengguna berhasil diubah tanpa password!"
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
