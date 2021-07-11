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
    /**
     * @var Authenticated user
     */
    private $user;
    /**
     * @var User's folder on the server
     */
    private $userFolder;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->userFolder = getenv('ROOT_FILES_PATH') . $this->user->id . "/";
    }

    /**
     * User getter
     *
     * @returns User: Authenticated user
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * List all user's files
     *
     * @return array: list of user's files on the server
     */
    public function listFilesForUser(): array
    {
        return $this->user->files;
    }

    /**
     * Creates user directory if it doesn't exist
     *
     * @return bool: Directory creation status
     */
    public function createUserDirectoryIfNotExists(): bool
    {
        if (!file_exists ($this->userFolder)) {
            return mkdir ($this->userFolder);
        }
        return false;
    }

    /**
     * Save the uploaded file
     *
     * @param UploadedFile: File uploaded by the user
     */
    public function saveFile(UploadedFile $file): void
    {
        file_put_contents($this->userFolder . $file->getClientOriginalName(), File::get($file->getRealPath()));
        FileDb::create([
            'id_user' => $this->user->id,
            'size'    => $file->getSize(),
            'path'    => $file->getClientOriginalName()
        ]);
    }

    /**
     * Rename the file
     *
     * @param int: File ID
     * @param string: File's new name
     */
    public function renameFile(int $fileId, string $newName): void
    {
        $file = $this->user->files()->where('id', $fileId)->first();
        $oldName = $this->userFolder . '/' . $file->path;
        $newName = $this->userFolder . '/' . $newName;

        rename($oldName, $newName);
        $file->path = $newName;
        $file->save();
    }

    /**
     * Download the file
     *
     * @param int: File ID
     * @returns string: File content
     */
    public function downloadFile(int $fileId): string
    {
        $file = $this->user->files()->where('id', $fileId)->first();
        return file_get_contents ($this->userFolder . $file->path);
    }

    /**
     * Delete the file (soft delete)
     *
     * @param int: File ID
     */
    public function deleteFile(int $fileId): void
    {
        $file = $this->user->files()->where('id', $fileId)->first();
        $file->delete();
    }
}
