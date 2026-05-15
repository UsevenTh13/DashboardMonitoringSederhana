<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Patient;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === BUAT USER ===

        // Admin
        $admin = User::create([
            'name'     => 'Administrator RS',
            'username' => 'admin',
            'email'    => 'admin@rsarifin.id',
            'password' => Hash::make('admin'), // Password admin
            'role'     => 'admin',
            'no_hp'    => '080000000000',
        ]);

        // Admin / Perawat
        $perawat1 = User::create([
            'name'     => 'Sari Dewi, S.Kep',
            'username' => 'DAHLIASURGIKAL',
            'email'    => 'perawat@rsarifin.id',
            'password' => Hash::make('DAHLIASURGIKAL'), // Sesuai dengan username
            'role'     => 'perawat',
            'no_hp'    => '08123456789',
        ]);

        $perawat2 = User::create([
            'name'     => 'Budi Santoso, S.Kep',
            'username' => 'MAWARINTERNA',
            'email'    => 'perawat2@rsarifin.id',
            'password' => Hash::make('MAWARINTERNA'),
            'role'     => 'perawat',
            'no_hp'    => '08198765432',
        ]);

        // Dokter
        $dokter1 = User::create([
            'name'          => 'dr. Ahmad Fauzi, Sp.PD',
            'username'      => 'drahmadfauzi',
            'email'         => 'dokter@rsarifin.id',
            'password'      => Hash::make('password123'),
            'role'          => 'dokter',
            'no_hp'         => '08111223344',
            'spesialisasi'  => 'Penyakit Dalam',
        ]);

        $dokter2 = User::create([
            'name'          => 'dr. Rina Marlina, Sp.JP',
            'username'      => 'drrinamarlina',
            'email'         => 'dokter2@rsarifin.id',
            'password'      => Hash::make('password123'),
            'role'          => 'dokter',
            'no_hp'         => '08155667788',
            'spesialisasi'  => 'Jantung dan Pembuluh Darah',
        ]);

        $dokter3 = User::create([
            'name'          => 'dr. Hendra Wijaya, Sp.S',
            'username'      => 'drhendrawijaya',
            'email'         => 'dokter3@rsarifin.id',
            'password'      => Hash::make('password123'),
            'role'          => 'dokter',
            'no_hp'         => '08177889900',
            'spesialisasi'  => 'Neurologi',
        ]);

        // === BUAT DATA PASIEN (untuk testing early warning) ===

        // Pasien Aman (LOS 1-3 hari)
        Patient::create([
            'nama_pasien'   => 'Hj. Fatimah binti Umar',
            'no_rm'         => '20240001',
            'kelas_bpjs'    => 'Kelas 1',
            'diagnosis'     => 'Hipertensi Grade II',
            'tanggal_masuk' => Carbon::today()->subDays(1),
            'dpjp_id'       => $dokter1->id,
            'ruangan'       => 'Mawar 1A',
            'status'        => 'aktif',
            'created_by'    => $perawat1->id,
        ]);

        Patient::create([
            'nama_pasien'   => 'Bapak Sugiarto',
            'no_rm'         => '20240002',
            'kelas_bpjs'    => 'Kelas 2',
            'diagnosis'     => 'Diabetes Mellitus Tipe 2',
            'tanggal_masuk' => Carbon::today()->subDays(2),
            'dpjp_id'       => $dokter1->id,
            'ruangan'       => 'Mawar 2B',
            'status'        => 'aktif',
            'created_by'    => $perawat1->id,
        ]);

        // Pasien Warning (LOS 4-5 hari)
        Patient::create([
            'nama_pasien'   => 'Ibu Nurhayati',
            'no_rm'         => '20240003',
            'kelas_bpjs'    => 'Kelas 3',
            'diagnosis'     => 'Gagal Jantung Kongestif',
            'tanggal_masuk' => Carbon::today()->subDays(4),
            'dpjp_id'       => $dokter2->id,
            'ruangan'       => 'Melati 1A',
            'status'        => 'aktif',
            'created_by'    => $perawat2->id,
        ]);

        Patient::create([
            'nama_pasien'   => 'Bapak Rusli Effendi',
            'no_rm'         => '20240004',
            'kelas_bpjs'    => 'Non-BPJS',
            'diagnosis'     => 'Pneumonia',
            'tanggal_masuk' => Carbon::today()->subDays(5),
            'dpjp_id'       => $dokter1->id,
            'ruangan'       => 'Melati 2A',
            'status'        => 'aktif',
            'created_by'    => $perawat2->id,
        ]);

        // Pasien Overstay (LOS >= 6 hari)
        Patient::create([
            'nama_pasien'   => 'Ny. Sri Wahyuni',
            'no_rm'         => '20240005',
            'kelas_bpjs'    => 'Kelas 1',
            'diagnosis'     => 'Stroke Iskemik',
            'tanggal_masuk' => Carbon::today()->subDays(8),
            'dpjp_id'       => $dokter3->id,
            'ruangan'       => 'Anggrek 1A',
            'status'        => 'aktif',
            'created_by'    => $perawat1->id,
        ]);

        Patient::create([
            'nama_pasien'   => 'Tn. Muhammad Ridwan',
            'no_rm'         => '20240006',
            'kelas_bpjs'    => 'Kelas 2',
            'diagnosis'     => 'Sepsis',
            'tanggal_masuk' => Carbon::today()->subDays(10),
            'dpjp_id'       => $dokter1->id,
            'ruangan'       => 'Anggrek 2B',
            'status'        => 'aktif',
            'created_by'    => $perawat1->id,
        ]);

        // === RIWAYAT PASIEN YANG SUDAH PULANG ===

        Patient::create([
            'nama_pasien'   => 'Ny. Dewi Kusuma',
            'no_rm'         => '20240101',
            'kelas_bpjs'    => 'Kelas 1',
            'diagnosis'     => 'Appendisitis Akut',
            'tanggal_masuk' => Carbon::now()->subDays(15),
            'tanggal_keluar'=> Carbon::now()->subDays(10),
            'dpjp_id'       => $dokter1->id,
            'ruangan'       => 'Mawar 3A',
            'status'        => 'pulang',
            'los_final'     => 5,
            'created_by'    => $perawat2->id,
        ]);

        Patient::create([
            'nama_pasien'   => 'Tn. Agus Setiawan',
            'no_rm'         => '20240102',
            'kelas_bpjs'    => 'Kelas 3',
            'diagnosis'     => 'Demam Berdarah Dengue',
            'tanggal_masuk' => Carbon::now()->subDays(20),
            'tanggal_keluar'=> Carbon::now()->subDays(14),
            'dpjp_id'       => $dokter2->id,
            'ruangan'       => 'Melati 3B',
            'status'        => 'pulang',
            'los_final'     => 6,
            'created_by'    => $perawat1->id,
        ]);

        Patient::create([
            'nama_pasien'   => 'Ny. Siti Aminah',
            'no_rm'         => '20240103',
            'kelas_bpjs'    => 'Non-BPJS',
            'diagnosis'     => 'Fraktur Femur Kanan',
            'tanggal_masuk' => Carbon::now()->subDays(30),
            'tanggal_keluar'=> Carbon::now()->subDays(21),
            'dpjp_id'       => $dokter3->id,
            'ruangan'       => 'Anggrek 4A',
            'status'        => 'pulang',
            'los_final'     => 9,
            'created_by'    => $perawat2->id,
        ]);
    }
}
