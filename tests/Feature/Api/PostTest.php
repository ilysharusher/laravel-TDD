<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    private function signIn()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    public function test_a_post_can_be_stored()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $data = [
            'title' => 'My first post',
            'content' => 'This is my first post content',
            'image' => File::image('image.jpg'),
        ];

        $this->postJson(route('api.posts.store'), $data)
            ->assertJson([
                'title' => $data['title'],
                'content' => $data['content'],
                'image' => 'images/' . $data['image']->hashName(),
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => 'images/' . $data['image']->hashName(),
        ]);

        Storage::disk('public')->assertExists('images/' . $data['image']->hashName());
    }
}
