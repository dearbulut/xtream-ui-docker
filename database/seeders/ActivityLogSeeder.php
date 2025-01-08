<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\Admin::first();
        $types = ['login', 'logout', 'login_failed', 'model_created', 'model_updated', 'model_deleted', 'model_restored'];
        $models = ['Channel', 'Movie', 'Series', 'Playlist', 'Bouquet'];
        $ips = ['192.168.1.1', '10.0.0.1', '172.16.0.1'];
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
            'Mozilla/5.0 (Linux; Android 11; SM-G991B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36',
        ];

        for ($i = 0; $i < 100; $i++) {
            $type = $types[array_rand($types)];
            $model = $models[array_rand($models)];
            $ip = $ips[array_rand($ips)];
            $userAgent = $userAgents[array_rand($userAgents)];

            $metadata = [];
            if (str_starts_with($type, 'model_')) {
                $metadata = [
                    'model' => "App\\Models\\{$model}",
                    'id' => rand(1, 10),
                    'attributes' => [
                        'name' => "Example {$model} " . rand(1, 100),
                        'is_active' => true,
                    ],
                ];

                if ($type === 'model_updated') {
                    $metadata['changes'] = [
                        'name' => ["Old {$model} Name", "New {$model} Name"],
                        'is_active' => [true, false],
                    ];
                }
            }

            \App\Models\ActivityLog::create([
                'user_id' => $admin->id,
                'type' => $type,
                'description' => match ($type) {
                    'login' => 'User logged in',
                    'logout' => 'User logged out',
                    'login_failed' => 'Failed login attempt',
                    'model_created' => "{$model} created",
                    'model_updated' => "{$model} updated",
                    'model_deleted' => "{$model} deleted",
                    'model_restored' => "{$model} restored",
                },
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'metadata' => $metadata,
                'created_at' => now()->subMinutes(rand(0, 60 * 24 * 7)), // Son 1 hafta içinde
            ]);
        }
    }
}
