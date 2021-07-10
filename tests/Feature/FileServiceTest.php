<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\FileService;
use Illuminate\Contracts\Filesystem\Filesystem;

class FileServiceTest extends TestCase
{

    protected static $fs;
    protected static $idUser;

    public static function setUpBeforeClass(): void
    {
        self::$fs = new FileService();
        self::$idUser = 1;
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_file_service_can_instantiate()
    {
        $this->assertInstanceOf(FileService::class, self::$fs);
    }

    public function test_create_user_directory()
    {
        $ret = self::$fs->createUserDirectoryIfNotExists(self::$idUser);
        $this->assertTrue($ret, "Could not create user directory");
    }

    public function test_create_user_directory_already_exists()
    {
        $ret = self::$fs->createUserDirectoryIfNotExists(self::$idUser);
        $this->assertFalse($ret, "Must return false if directory exists");
    }

    public static function tearDownAfterClass(): void
    {
        rmdir(getenv('ROOT_FILES_PATH') . self::$idUser);
    }
}
