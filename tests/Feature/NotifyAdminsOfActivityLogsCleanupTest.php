<?php

namespace Tests\Feature;

use App\Events\ActivityLogsCleanedUp;
use App\Listeners\NotifyAdminsOfActivityLogsCleanup;
use App\Models\Admin;
use App\Notifications\ActivityLogsCleanupCompleted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyAdminsOfActivityLogsCleanupTest extends TestCase
{
    use RefreshDatabase;
    public function test_listener_sends_notification_to_admins(): void
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $admin = Admin::factory()->create();
        $admin->assignRole('admin');

        $nonAdmin = Admin::factory()->create();

        $event = new ActivityLogsCleanedUp(100, 30);
        $listener = new NotifyAdminsOfActivityLogsCleanup();

        $listener->handle($event);

        Notification::assertSentTo($admin, ActivityLogsCleanupCompleted::class);
        Notification::assertNotSentTo($nonAdmin, ActivityLogsCleanupCompleted::class);
    }

    public function test_notification_contains_correct_data(): void
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $admin = Admin::factory()->create();
        $admin->assignRole('admin');

        $event = new ActivityLogsCleanedUp(100, 30);
        $listener = new NotifyAdminsOfActivityLogsCleanup();

        $listener->handle($event);

        Notification::assertSentTo($admin, ActivityLogsCleanupCompleted::class, function ($notification) {
            return $notification->count === 100 && $notification->days === 30;
        });
    }

    public function test_listener_handles_no_admins(): void
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $event = new ActivityLogsCleanedUp(100, 30);
        $listener = new NotifyAdminsOfActivityLogsCleanup();

        $listener->handle($event);

        Notification::assertNothingSent();
    }

    public function test_listener_handles_multiple_admins(): void
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $admin1 = Admin::factory()->create();
        $admin1->assignRole('admin');

        $admin2 = Admin::factory()->create();
        $admin2->assignRole('admin');

        $event = new ActivityLogsCleanedUp(100, 30);
        $listener = new NotifyAdminsOfActivityLogsCleanup();

        $listener->handle($event);

        Notification::assertSentTo([$admin1, $admin2], ActivityLogsCleanupCompleted::class);
    }

    public function test_listener_handles_super_admin(): void
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $superAdmin = Admin::factory()->create();
        $superAdmin->assignRole('super-admin');

        $event = new ActivityLogsCleanedUp(100, 30);
        $listener = new NotifyAdminsOfActivityLogsCleanup();

        $listener->handle($event);

        Notification::assertSentTo($superAdmin, ActivityLogsCleanupCompleted::class);
    }
}
