<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;

class FileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $fs = new FileService($user);
        $ret = $fs->createUserDirectoryIfNotExists();
        return view('files');
    }

    public function list()
    {
        try {
            $user = Auth::user();
            $fs = new FileService($user);
            $files = $fs->listFilesForUser();
            return response()->json($files);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500)
                        ->header('Content-type', 'text/plain');
        }
    }

    public function create(Request $request)
    {
        try {
            $user = Auth::user();
            $fs = new FileService($user);
            $msg = "File created successfully.";
                $validator = $request->validate([
                    'uploadFile' => 'required|max:8388608'
                ]);
            $fs->saveFile($request->file('uploadFile'));
        } catch (\Exception $e) {
            $msg = $e->getMessage();
        } finally {
            return redirect('/files')->with('message', $msg);
        }
    }

    public function delete(int $idFile)
    {
        try {
            $user = Auth::user();
            $fs = new FileService($user);
            $status = [
                'status' => 0,
                'message' => 'File was deleted successfully.'
            ];
            $fs->deleteFile($idFile);
        } catch (\Exception $e) {
            $status = [
                'status' => -1,
                'message' => 'Error deleting file: ' . $e->getMessage()
            ];
        } finally {
            return redirect('/files')->with('message', $status['message']);
        }
    }

    public function rename (Request $request)
    {
        $idFile = $request->get('idFile');
        $newName = $request->get('newName');

        if (isset($newName)) {
            try {
                $user = Auth::user();
                $fs = new FileService($user);
                $status = [
                    'status' => 0,
                    'message' => 'File was renamed successfully.'
                ];
                $fs->renameFile($idFile, $newName);
            } catch (\Exception $e) {
                $status = [
                    'status' => -2,
                    'message' => 'Error renaming file: ' . $e->getMessage()
                ];
            } finally {
                return redirect('/files')->with('message', $status['message']);
            }
        } else {
            return view ('rename', ['idFile' => $idFile]);
        }
    }

    public function download (int $idFile)
    {
        $user = Auth::user();
        $fs = new FileService($user);
        $fileName = $user->files->find($idFile)->path;
        $path = getenv('ROOT_FILES_PATH') . $user->id . "/";
        return response()->file($path . $fileName);
    }
}
