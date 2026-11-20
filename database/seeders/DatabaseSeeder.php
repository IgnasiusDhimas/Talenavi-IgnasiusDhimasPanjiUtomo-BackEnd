<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Pendataan Inventaris & Sound System HMTI',
                'assignee' => 'Dhimas',
                'due_date' => '2026-11-25',
                'time_tracked' => 3.5,
                'status' => 'completed',
                'priority' => 'high',
            ],
            [
                'title' => 'Penyusunan Proposal & Surat Undangan Makrab',
                'assignee' => 'Erneus',
                'due_date' => '2026-12-02',
                'time_tracked' => 4,
                'status' => 'in_progress',
                'priority' => 'high',
            ],
            [
                'title' => 'Rekap RAB & LPJ Keuangan Kas HMTI',
                'assignee' => 'Toto',
                'due_date' => '2026-12-10',
                'time_tracked' => 2.5,
                'status' => 'in_progress',
                'priority' => 'high',
            ],
            [
                'title' => 'Konfirmasi Kehadiran Pembicara Seminar IT',
                'assignee' => 'Yohan',
                'due_date' => '2026-12-18',
                'time_tracked' => 1.5,
                'status' => 'pending',
                'priority' => 'medium',
            ],
            [
                'title' => 'Evaluasi Kinerja Divisi & Rapat Koordinasi',
                'assignee' => 'Jason',
                'due_date' => '2026-12-26',
                'time_tracked' => 0,
                'status' => 'open',
                'priority' => 'low',
            ],
        ];

        foreach ($data as $item) {
            Todo::create($item);
        }
    }
}
