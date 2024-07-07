<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Kaprodi;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'string'],
        ];

        if (isset($data['roles'])) {
            switch ($data['roles']) {
                case 'admin':
                    $rules['nip'] = ['required', 'string', 'max:10'];
                    break;
                case 'kaprodi':
                case 'dosen':
                    $rules['nidn'] = ['required', 'string', 'max:10'];
                    break;
                case 'mahasiswa':
                    $rules['nobp'] = ['required', 'string', 'max:10'];
                    break;
            }
        }

        return Validator::make($data, $rules);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'roles' => $data['roles'],
        ]);

        switch ($data['roles']) {
            case 'admin':
                $user->nip = $data['nip'];
                break;
            case 'kaprodi':
            case 'dosen':
                // Check if nidn exists in Dosen table
                $dosen = Dosen::where('nidn', $data['nidn'])->first();
                if (!$dosen) {
                    // Rollback transaction and return error message
                    $user->delete();
                    return redirect()->back()->with('error', 'NIDN tidak terdaftar sebagai dosen atau kaprodi');
                }
                $user->nidn = $data['nidn'];
                // Update existing Kaprodi/Dosen record with user_id
                $model = $data['roles'] == 'kaprodi' ? Kaprodi::where('nidn', $data['nidn'])->first() : $dosen;
                if ($model) {
                    $model->update(['user_id' => $user->id]);
                }
                break;
            case 'mahasiswa':
                // Check if nobp exists in Mahasiswa table
                $mahasiswa = Mahasiswa::where('nobp', $data['nobp'])->first();
                if (!$mahasiswa) {
                    // Rollback transaction and return error message
                    $user->delete();
                    return redirect()->back()->with('error', 'NOBP tidak terdaftar sebagai mahasiswa');
                }
                $user->nobp = $data['nobp'];
                // Update existing Mahasiswa record with user_id
                if ($mahasiswa) {
                    $mahasiswa->update(['user_id' => $user->id]);
                }
                break;
        }

        $user->save();

        return $user;
    }



    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        if (!$user instanceof User) {
            // If $user is not an instance of User (meaning creation failed),
            // redirect back with an error message
            return $user;
        }

        event(new Registered($user));

        // Redirect to login page after registration
        return redirect()->route('verification.notice')->with('status', 'Registration successful! Please verify your email.');
    }
}
