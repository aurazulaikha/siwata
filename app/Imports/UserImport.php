<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Buat pengguna baru
        $password = 'password';
        $user = new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'roles' => $row['roles'],
            'nobp' => $row['nobp'],
            'nidn' => $row['nidn'],
            'nip' => $row['nip'],
            'password' => bcrypt($password)
        ]);

        // Simpan pengguna
        $user->save();

        // Perbarui entri di tabel mahasiswa jika roles adalah 'mahasiswa' dan nobp ada
        if ($row['roles'] === 'mahasiswa' && !empty($row['nobp'])) {
            $mahasiswa = Mahasiswa::where('nobp', $row['nobp'])->first();
            if ($mahasiswa) {
                $mahasiswa->update(['user_id' => $user->id]);
            }
        }

        // Perbarui entri di tabel dosen jika roles adalah 'dosen' dan nidn ada
        if ($row['roles'] === 'dosen' && !empty($row['nidn'])) {
            $dosen = Dosen::where('nidn', $row['nidn'])->first();
            if ($dosen) {
                $dosen->update(['user_id' => $user->id]);
            }
        }

        return $user;
    }
}
