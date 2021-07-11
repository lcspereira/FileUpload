<?php

namespace App\Services;

use App\Models\File as FileDb;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;

class FileService
{
    private $user;
    private $userFolder;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->userFolder = getenv('ROOT_FILES_PATH') . $this->user->id . "/";
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function listFilesForUser()
    {
        return $this->user->files;
    }

    public function createUserDirectoryIfNotExists(): bool
    {
        if (!file_exists ($this->userFolder)) {
            return mkdir ($this->userFolder);
        }
        return false;
    }

    public function saveFile(UploadedFile $file): void
    {
        file_put_contents($this->userFolder . $file->getClientOriginalName(), File::get($file->getRealPath()));
        FileDb::create([
            'id_user' => $this->user->id,
            'size'    => $file->getSize(),
            'path'    => $file->getClientOriginalName()
        ]);
    }

    public function renameFile(int $fileId, string $newName): void
    {
        $file = $this->user->files()->where('id', $fileId)->first();
        $oldName = $this->userFolder . '/' . $file->path;
        $newName = $this->userFolder . '/' . $newName;

        rename($oldName, $newName);
        $file->path = $newName;
        $file->save();
    }

    public function downloadFile(int $fileId): string
    {
        $file = $this->user->files()->where('id', $fileId)->first();
        return file_get_contents ($this->userFolder . $file->path);
    }

    public function deleteFile(int $fileId): void
    {
        $file = $this->user->files()->where('id', $fileId)->first();
        $file->delete();
    }
}
