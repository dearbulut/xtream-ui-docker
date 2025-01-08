<?php

namespace Tests\Feature\Api;

use App\Models\Bouquet;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Playlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class XtreamApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        $this->playlist = Playlist::factory()->create([
            'username' => 'test_user',
            'password' => 'test_pass',
            'is_active' => true,
        ]);

        $this->category = Category::factory()->create([
            'name' => 'Test Category'
        ]);

        $this->channel = Channel::factory()->create([
            'name' => 'Test Channel',
            'category_id' => $this->category->id,
            'source' => 'http://example.com/stream.m3u8'
        ]);

        $this->bouquet = Bouquet::factory()->create();
        $this->bouquet->channels()->attach($this->channel);
        $this->playlist->bouquets()->attach($this->bouquet);
    }

    public function test_authenticate_with_valid_credentials()
    {
        $response = $this->post('/api/player_api.php', [
            'username' => 'test_user',
            'password' => 'test_pass'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user_info' => [
                    'username',
                    'password',
                    'status',
                    'exp_date',
                    'is_trial',
                    'active_cons',
                    'created_at',
                    'max_connections',
                    'allowed_output_formats'
                ],
                'server_info' => [
                    'url',
                    'port',
                    'https_port',
                    'server_protocol',
                    'rtmp_port',
                    'timezone',
                    'timestamp_now',
                    'time_now'
                ]
            ]);
    }

    public function test_authenticate_with_invalid_credentials()
    {
        $response = $this->post('/api/player_api.php', [
            'username' => 'wrong_user',
            'password' => 'wrong_pass'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'user_info' => [],
                'server_info' => [],
                'error' => 'Invalid credentials',
                'error_code' => 1
            ]);
    }

    public function test_get_live_categories()
    {
        $response = $this->get('/api/player_api.php/live?username=test_user&password=test_pass');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'category_id' => $this->category->id,
                'category_name' => $this->category->name,
                'parent_id' => 0
            ]);
    }

    public function test_get_live_streams()
    {
        $response = $this->get('/api/player_api.php/live_streams?username=test_user&password=test_pass');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $this->channel->name,
                'stream_type' => 'live',
                'stream_id' => $this->channel->id,
                'stream_icon' => $this->channel->logo,
                'epg_channel_id' => $this->channel->epg_channel_id,
                'category_id' => $this->channel->category_id,
                'direct_source' => $this->channel->source,
            ]);
    }
}