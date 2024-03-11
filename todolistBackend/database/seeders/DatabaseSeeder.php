<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 6,
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => '$2y$10$/MSN2f4qMPa3tfbdJY01dOkL0cRO5gMJyBpfZZkt2aNf8RhorgYYu',
                'is_admin' => 1,
            ],
            [
                'id' => 7,
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => '$2y$10$/MSN2f4qMPa3tfbdJY01dOkL0cRO5gMJyBpfZZkt2aNf8RhorgYYu',
                'is_admin' => 0,
            ],
            [
                'id' => 8,
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'password' => '$2y$10$/MSN2f4qMPa3tfbdJY01dOkL0cRO5gMJyBpfZZkt2aNf8RhorgYYu',
                'is_admin' => 0,
            ],
            [
                'id' => 9,
                'name' => 'Support',
                'email' => 'support@imsvietnamese.com',
                'password' => '$2y$12$CbPYf2PvfWs.5jgw1cKv0ePRwKynsOMg0H/FgElgirgeoEkTnVQrG',
                'is_admin' => 0,
            ],
            [
                'id' => 10,
                'name' => 'Charlie Davis',
                'email' => 'charlie.davis@example.com',
                'password' => '$2y$10$/MSN2f4qMPa3tfbdJY01dOkL0cRO5gMJyBpfZZkt2aNf8RhorgYYu',
                'is_admin' => 0,
            ],
            [
                'id' => 11,
                'name' => 'jerry',
                'email' => 'jerry@gmail.com',
                'password' => '$2y$12$Tt5h5oBA0DTseB.hSPawleYR16RUrnFaexzMpvhBk8LMFU/Ifu0N6',
                'is_admin' => 0,
                'created_at' => '2024-02-28 23:38:09',
                'updated_at' => '2024-02-28 23:38:09',
            ],
            [
                'id' => 18,
                'name' => 'kha',
                'email' => 'lekhanhbaokha@gmail.com',
                'password' => '$2y$12$JOBRY7M2CNBaTk7L9svt2epA3acI6OqjyDzTujkdtPBTXQR9vqqB2',
                'is_admin' => 0,
                'created_at' => '2024-02-29 19:33:29',
                'updated_at' => '2024-02-29 19:33:29',
            ],
            [
                'id' => 19,
                'name' => 'john',
                'email' => 'john@123',
                'password' => '$2y$12$9qgPZIe9Ht.ek7fpKmv4qe6lbFNBruFssL9hduqmo5ki1P28KRkIC',
                'is_admin' => 0,
                'created_at' => '2024-03-08 02:27:55',
                'updated_at' => '2024-03-08 02:27:55',
            ],
            [
                'id' => 20,
                'name' => 'baokha',
                'email' => 'baokha1024.com@gmail.com',
                'password' => '$2y$12$/2Xs0ZWOm3/ZoDyuCXUWFOh/XffgMlSNdC.tRgLHHdKphRuGGODWC',
                'is_admin' => 0,
                'created_at' => '2024-03-08 02:29:02',
                'updated_at' => '2024-03-08 02:29:02',
            ],
            [
                'id' => 21,
                'name' => 'KhamKor',
                'email' => 'KhamKor@123',
                'password' => '$2y$12$O97Jo3xBSE/PUeiR7cSWLeU.Q3Nd7SMUyZoosZNA8TPZeUlSPhdJK',
                'is_admin' => 0,
                'created_at' => '2024-03-08 02:46:20',
                'updated_at' => '2024-03-08 02:46:20',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $projects = [
            [
                'id' => 1,
                'created_at' => '2024-02-28 07:42:00',
                'updated_at' => '2024-02-28 07:42:00',
                'name' => 'My First Project',
            ],
            [
                'id' => 2,
                'created_at' => '2024-02-26 17:00:00',
                'updated_at' => '2024-02-26 17:00:00',
                'name' => 'Personal Website',
            ],
            [
                'id' => 3,
                'created_at' => '2024-02-28 07:43:18',
                'updated_at' => '2024-02-28 07:43:18',
                'name' => 'Shopping List App',
            ],
            [
                'id' => 4,
                'created_at' => '2024-02-27 17:00:00',
                'updated_at' => '2024-02-28 07:43:32',
                'name' => 'Bug Fixing Project',
            ],
            [
                'id' => 5,
                'created_at' => '2024-02-28 07:43:49',
                'updated_at' => '2024-02-28 07:43:49',
                'name' => 'Placeholder Project',
            ],
        ];

        foreach($projects as $project){
            Project::create($project);
        }

        $todos = [
            [
                'id' => 13,
                'created_at' => '2024-03-01 00:55:32',
                'updated_at' => '2024-03-08 01:05:31',
                'name' => 'Doing laundry',
                'description' => 'at 7am',
                'state' => 1,
                'project_id' => 1,
                'user_id' => 11,
            ],
            [
                'id' => 31,
                'created_at' => '2024-03-07 20:41:04',
                'updated_at' => '2024-03-08 01:09:33',
                'name' => 'Finish my code',
                'description' => 'Finish before 5pm',
                'state' => 1,
                'project_id' => 5,
                'user_id' => 18,
            ],
            [
                'id' => 32,
                'created_at' => '2024-03-07 20:41:35',
                'updated_at' => '2024-03-07 20:41:35',
                'name' => 'Doing laundry',
                'description' => 'Finish before 5pm',
                'state' => 0,
                'project_id' => 4,
                'user_id' => 8,
            ],
            [
                'id' => 33,
                'created_at' => '2024-03-07 20:42:34',
                'updated_at' => '2024-03-08 01:09:59',
                'name' => 'Making breakfast at 6am',
                'description' => 'for 21 people',
                'state' => 1,
                'project_id' => 2,
                'user_id' => 8,
            ],
        ];

        foreach($todos as $todo){
            Todo::create($todo);
        }
    }
}
