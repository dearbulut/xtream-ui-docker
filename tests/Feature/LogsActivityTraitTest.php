<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\Channel;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogsActivityTraitTest extends TestCase
{
    use RefreshDatabase;
    public function test_trait_logs_model_events(): void
    {
        $this->withoutExceptionHandling();

        $admin = Admin::factory()->create();
        $this->actingAs($admin);

        $testModel = new class extends Model {
            use LogsActivity;

            protected $table = 'test_models';
            protected $fillable = ['name'];
        };

        \Schema::create('test_models', function ($table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        $model = $testModel::create(['name' => 'Test']);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $admin->id,
            'type' => 'model_created',
            'description' => class_basename($testModel) . ' created',
        ]);

        $model->update(['name' => 'Updated']);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $admin->id,
            'type' => 'model_updated',
            'description' => class_basename($testModel) . ' updated',
        ]);

        $model->delete();

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $admin->id,
            'type' => 'model_deleted',
            'description' => class_basename($testModel) . ' deleted',
        ]);
    }

    public function test_trait_logs_model_changes(): void
    {
        $this->withoutExceptionHandling();

        $admin = Admin::factory()->create();
        $this->actingAs($admin);

        $channel = Channel::factory()->create([
            'name' => 'Original Name',
            'is_active' => true,
        ]);

        $channel->update([
            'name' => 'New Name',
            'is_active' => false,
        ]);

        $log = ActivityLog::where('type', 'model_updated')->first();

        $this->assertEquals([
            'name' => ['Original Name', 'New Name'],
            'is_active' => [true, false],
        ], $log->metadata['changes']);
    }

    public function test_trait_logs_model_metadata(): void
    {
        $this->withoutExceptionHandling();

        $admin = Admin::factory()->create();
        $this->actingAs($admin);

        $channel = Channel::factory()->create([
            'name' => 'Test Channel',
            'is_active' => true,
        ]);

        $log = ActivityLog::where('type', 'model_created')->first();

        $this->assertEquals(Channel::class, $log->metadata['model']);
        $this->assertEquals($channel->id, $log->metadata['id']);
        $this->assertEquals([
            'name' => 'Test Channel',
            'is_active' => true,
        ], array_intersect_key($log->metadata['attributes'], ['name' => true, 'is_active' => true]));
    }

    public function test_trait_only_logs_when_authenticated(): void
    {
        $this->withoutExceptionHandling();

        $channel = Channel::factory()->create();

        $this->assertDatabaseMissing('activity_logs', [
            'type' => 'model_created',
            'description' => 'Channel created',
        ]);
    }
}
