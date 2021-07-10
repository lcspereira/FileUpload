<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\File;

class FileDbTest extends TestCase
{
    use RefreshDatabase;

    public function test_file_can_be_instantiated()
    {
        $file = File::factory()->make();

        $this->assertInstanceOf(File::class, $file, 'Object is not a File object (' . get_class($file) . ")");
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_file_db_creation()
    {
        $files = File::factory()
                    ->forUser([
                        'name' => 'Test User',
                        'email' => 'testuser@testdomain.com'
                    ])
                    ->count(5)
                    ->create();
        $this->assertDatabaseCount('files', 5);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_file_db_delete()
    {
        $file = File::factory()
                    ->forUser([
                        'name' => 'Test User',
                        'email' => 'testuser@testdomain.com'
                    ])
                    ->create();

        $file->delete();
        $this->assertSoftDeleted($file);
    }
}
