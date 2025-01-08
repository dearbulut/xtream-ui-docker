<?php

namespace Tests\Feature;

use App\Events\ActivityLogsCleanedUp;
use App\Jobs\CleanupActivityLogs;
use App\Models\ActivityLog;
use App\Models\Admin;
use App\Notifications\ActivityLogsCleanupCompleted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CleanupActivityLogsJobTest extends TestCase
{
    use RefreshDatabase;
    public function test_cleanup_activity_logs_job(): void
    {
        $this->withoutExceptionHandling();

        Event::fake();
        Notification::fake();

        $admin = Admin::factory()->create();
        $admin->assignRole('admin');

        // 35 gün önce oluşturulmuş log
        ActivityLog::factory()->create([
            'created_at' => now()->subDays(35),
        ]);

        // 25 gün önce oluşturulmuş log
        ActivityLog::factory()->create([
            'created_at' => now()->subDays(25),
        ]);

        CleanupActivityLogs::dispatch();

        $this->assertDatabaseCount('activity_logs', 1);
        $this->assertDatabaseHas('activity_logs', [
            'created_at' => now()->subDays(25)->toDateTimeString(),
        ]);

        Event::assertDispatched(ActivityLogsCleanedUp::class);
        Notification::assertSentTo($admin, ActivityLogsCleanupCompleted::class);
    }
}
