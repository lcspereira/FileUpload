<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\FileService;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\User;

class FileServiceTest extends TestCase
{
    /**
     * Instance test
     */
    public function test_file_service_can_instantiate()
    {
        $fs = new FileService(User::factory()->make());
        $this->assertInstanceOf(FileService::class, $fs, 'Object is not a File object (' . get_class($fs) . ')');
    }
}
