<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EpgProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = \App\Models\Channel::all();
        $now = now();

        foreach ($channels as $channel) {
            // Her kanal için 24 saatlik program oluştur
            for ($i = 0; $i < 24; $i++) {
                $start = $now->copy()->addHours($i);
                $end = $start->copy()->addHour();

                \App\Models\EpgProgram::create([
                    'channel_id' => $channel->id,
                    'title' => $this->generateProgramTitle($channel, $i),
                    'description' => $this->generateProgramDescription(),
                    'start_time' => $start,
                    'end_time' => $end,
                    'category' => $this->getProgramCategory($channel),
                    'language' => 'en',
                ]);
            }
        }
    }

    private function generateProgramTitle($channel, $hour)
    {
        $titles = [
            'Football' => [
                'Premier League Live',
                'Champions League',
                'World Cup Highlights',
                'Football News',
                'Match Analysis',
            ],
            'Basketball' => [
                'NBA Live',
                'EuroLeague',
                'Basketball News',
                'NBA Highlights',
                'Court Review',
            ],
            'International' => [
                'World News',
                'Global Report',
                'International Focus',
                'Breaking News',
                'World in Review',
            ],
            'Business' => [
                'Market Watch',
                'Business Report',
                'Financial News',
                'Stock Market Update',
                'Business Analysis',
            ],
            'Music' => [
                'Top 40 Hits',
                'Music Videos',
                'Artist Spotlight',
                'Live Concert',
                'Music News',
            ],
        ];

        $category = $channel->category?->name ?? 'Default';
        $categoryTitles = $titles[$category] ?? ['Program ' . ($hour + 1)];

        return $categoryTitles[array_rand($categoryTitles)];
    }

    private function generateProgramDescription()
    {
        $descriptions = [
            'Join us for this exciting program.',
            'Stay tuned for the latest updates.',
            'Don\'t miss this exclusive content.',
            'Live coverage of this amazing event.',
            'The best entertainment for your viewing pleasure.',
        ];

        return $descriptions[array_rand($descriptions)];
    }

    private function getProgramCategory($channel)
    {
        $categories = [
            'Football' => 'Sports',
            'Basketball' => 'Sports',
            'International' => 'News',
            'Business' => 'News',
            'Music' => 'Entertainment',
        ];

        return $categories[$channel->category?->name ?? 'Default'] ?? 'General';
    }
}
