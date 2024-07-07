<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Kaprodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use App\Imports\UserImport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::OrderBy('roles', 'asc')->get();
        return view('pages.admin.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'roles' => 'required'
        ], [
            'email.unique' => 'Email sudah terdaftar',
        ]);

        if ($request->roles == "dosen") {
            $countDosen = Dosen::where('nidn', $request->nidn)->count();
            $dosenId = Dosen::where('nidn', $request->nidn)->get();
            foreach ($dosenId as $val) {
                $dosen = Dosen::findOrFail($val->id);
            }

            if ($countDosen >= 1) {
                User::create([
                    'name' => $dosen->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'roles' => $request->roles,
                    'nidn' => $request->nidn
                ]);

                // Add user id to dosen table
                $dosen->user_id = User::where('email', $request->email)->first()->id;
                $dosen->save();

                return redirect()->route('userAdmin.index')->with('success', 'Data user berhasil ditambahkan');
            } else {
                return redirect()->route('userAdmin.index')->with('error', 'NIDN tidak terdaftar sebagai dosen');
            }
        } elseif ($request->roles == "kaprodi") {
            $countKaprodi = Kaprodi::where('nidn', $request->nidn)->count();
            $kaprodiId = Kaprodi::where('nidn', $request->nidn)->get();
            foreach ($kaprodiId as $val) {
                $kaprodi = Kaprodi::findOrFail($val->id);
            }

            if ($countKaprodi >= 1) {
                User::create([
                    'name' => $kaprodi->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'roles' => $request->roles,
                    'nidn' => $request->nidn
                ]);

                // Add user id to dosen table
                $kaprodi->user_id = User::where('email', $request->email)->first()->id;
                $kaprodi->save();

                return redirect()->route('userAdmin.index')->with('success', 'Data user berhasil ditambahkan');
            } else {
                return redirect()->route('userAdmin.index')->with('error', 'NIDN tidak terdaftar sebagai kaprodi');
            }
        } elseif ($request->roles == "mahasiswa") {
            $countMahasiswa = Mahasiswa::where('nobp', $request->nobp)->count();
            $mahasiswaId = Mahasiswa::where('nobp', $request->nobp)->get();
            foreach ($mahasiswaId as $val) {
                $mahasiswa = Mahasiswa::findOrFail($val->id);
            }

            if ($countMahasiswa >= 1) {
                User::create([
                    'name' => $mahasiswa->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'roles' => $request->roles,
                    'nobp' => $request->nobp
                ]);

                // Add user id to mahasiswa table
                $mahasiswa->user_id = User::where('email', $request->email)->first()->id;
                $mahasiswa->save();

                return redirect()->route('userAdmin.index')->with('success', 'Data user berhasil ditambahkan');
            } else {
                return redirect()->route('userAdmin.index')->with('error', 'NOBP tidak terdaftar sebagai mahasiswa');
            }
        } else {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nip' => $request->nip,
                'password' => Hash::make($request->password),
                'roles' => $request->roles
            ]);
            return redirect()->route('userAdmin.index')->with('success', 'Data user berhasil ditambahkan');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        abort(404);
    }


    public function editProfile()
    {
        $dosen = Dosen::where('user_id', Auth::user()->id)->first();
        $mahasiswa = Mahasiswa::where('user_id', Auth::user()->id)->first();
        $admin = User::findOrFail(Auth::user()->id);
        $kaprodi = Kaprodi::where('user_id', Auth::user()->id)->first();

        return view('pages.profile', compact('dosen', 'mahasiswa', 'admin', 'kaprodi'));
    }


    public function updateProfile(Request $request)
    {
        if (Auth::user()->roles == 'dosen') {

            $data = $request->all();

            // Save to guru table
            $dosen = Dosen::where('user_id', Auth::user()->id)->first();
            $dosen->nama = $data['nama'];
            $dosen->nidn = $data['nidn'];
            $dosen->alamat = $data['alamat'];
            $dosen->no_telp = $data['no_telp'];
            $dosen->update($data);

            // Save to user table
            $user = Auth::user();
            $user->name = $data['nama'];
            $user->email = $data['email'];
            $user->update($data);

        } else if (Auth::user()->roles == 'mahasiswa') {

            $data = $request->all();

            // Save to siswa table
            $mahasiswa = Mahasiswa::where('user_id', Auth::user()->id)->first();
            $mahasiswa->nama = $data['nama'];
            $mahasiswa->nobp = $data['nobp'];
            $mahasiswa->alamat = $data['alamat'];
            $mahasiswa->telp = $data['telp'];
            $mahasiswa->update($data);

            // Save to user table
            $user = Auth::user();
            $user->name = $data['nama'];
            $user->email = $data['email'];
            $user->update($data);

        } else if (Auth::user()->roles == 'kaprodi') {

            $data = $request->all();

            // Save to siswa table
            $kaprodi = Kaprodi::where('user_id', Auth::user()->id)->first();
            $kaprodi->nama = $data['nama'];
            $kaprodi->nidn = $data['nidn'];
            $kaprodi->alamat = $data['alamat'];
            $kaprodi->no_telp = $data['no_telp'];
            $kaprodi->update($data);

            // Save to user table
            $user = Auth::user();
            $user->name = $data['nama'];
            $user->email = $data['email'];
            $user->update($data);
        } else {
            $data = $request->all();

            // Save to user table
            $user = Auth::user();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->update($data);
        }

        return redirect()->route('profile')->with('success', 'Data berhasil diubah');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('pages.admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'roles' => 'required|string',
            'permissions' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user with new values

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->roles = $request->input('roles');
        $user->permissions = $request->input('permissions');

        // Check if password is provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Save the user
        $user->save();

        // Redirect with success message
        return redirect()->route('userAdmin.index')->with('success', 'Data berhasil diubah');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('userAdmin.index')->with('success', 'Data user berhasil dihapus');
    }

    public function editPassword()
    {
        $dosen = Dosen::where('user_id', Auth::user()->id)->first();
        $mahasiswa = Mahasiswa::where('user_id', Auth::user()->id)->first();
        $admin = User::findOrFail(Auth::user()->id);

        return view('pages.ubah-password', compact('dosen', 'mahasiswa', 'admin'));
    }

    public function updatePassword(Request $request)
    {

        // dd($request->all());

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("error", "Password lama tidak sesuai");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with("error", "Password baru tidak boleh sama dengan password lama");
        }

        $this->validate($request, [
            'current-password' => 'required',
            'new-password' => 'required|string|min:6',
        ], [
            'new-password.min' => 'Password baru minimal 6 karakter',
        ]);

        // Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();


        return redirect()->route('profile')->with('success', 'Password berhasil diubah');
    }

    public function export_user()
    {
        try {
            return Excel::download(new UserExport, 'user.xlsx');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal mengekspor data: ' . $th->getMessage());
        }
    }

    public function import_user(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'file' => 'required|max:2048',
        ]);

        Excel::import(new UserImport, $request->file('file'));

        return back()->with('success', 'Import data user berhasil !');
    }
}
