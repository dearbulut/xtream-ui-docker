<?php

namespace Tests\Feature;

use App\Events\ActivityLogsCleanedUp;
use App\Jobs\CleanupOldActivityLogs;
use App\Models\ActivityLog;
use App\Models\Admin;
use App\Notifications\ActivityLogsCleanupCompleted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CleanupOldActivityLogsTest extends TestCase
{
    use RefreshDatabase;
    public function test_cleanup_old_activity_logs(): void
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

        $job = new CleanupOldActivityLogs(30);
        $job->handle();

        $this->assertDatabaseCount('activity_logs', 1);
        $this->assertDatabaseHas('activity_logs', [
            'created_at' => now()->subDays(25)->toDateTimeString(),
        ]);

        Event::assertDispatched(ActivityLogsCleanedUp::class);
        Notification::assertSentTo($admin, ActivityLogsCleanupCompleted::class);
    }
}
