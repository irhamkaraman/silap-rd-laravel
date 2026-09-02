<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        $agencies = [
            ['name' => 'Dinas Pekerjaan Umum',                  'contact_email' => 'dpu@silap.local'],
            ['name' => 'Dinas Sosial',                          'contact_email' => 'dinsos@silap.local'],
            ['name' => 'Dinas Kesehatan',                       'contact_email' => 'dinkes@silap.local'],
            ['name' => 'Dinas Tenaga Kerja',                    'contact_email' => 'disnaker@silap.local'],
            ['name' => 'Ombudsman Daerah',                      'contact_email' => 'ombudsman@silap.local'],
        ];

        foreach ($agencies as $agency) {
            Agency::firstOrCreate(
                ['contact_email' => $agency['contact_email']],
                ['name' => $agency['name']]
            );
        }
    }
}
