<?php

namespace App\Services;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileService
{
    private $user;
    private $userFolder;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->userFolder = getenv('ROOT_FILES_PATH') . $this->user->id;
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
        return Storage::makeDirectory($this->userFolder);
    }

    public function saveFile($file): void
    {
        $file->store(getenv('ROOT_FILES_PATH') . $this->user->id);
        File::create(
            [
                'id_user' => $this->user->id,
                'size'    => $file->getSize(),
                'path'    => $file->getClientOriginalName()
            ]
        );
    }

    public function renameFile(int $fileId, string $newName): void
    {
        $file = $this->user->files()->where('id', $fileId)->first();
        $oldName = $this->userFolder . '/' . $file->path;
        $newName = $this->userFolder . '/' . $newName;

        Storage::move($oldName, $newName);
        $file->path = $newName;
        $file->save();
    }

    public function downloadFile(int $fileId): string
    {
        $file = $this->user->files()->where('id', $fileId)->first();
        return Storage::download($this->userFolder . '/' . $file->path);
    }

    public function deleteFile(int $fileId): void
    {
        $file = $this->user->files()->where('id', $fileId)->first();
        $file->delete();
    }
}
