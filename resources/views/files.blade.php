<x-app-layout>
    <x-slot name="header">
        {{ __('Files') }}
    </x-slot>
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="renameModalLabel">File upload</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" action="/files/create" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="uploadFile" name="uploadFile"/>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                      </div>
                </form>
            </div>
          </div>
        </div>
    </div>

    @if (isset($message))
        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <p>{{ $message }}</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Upload file
            </button>
            <table class="table" name="fileTable" id="fileTable">
                <thead>
                    <tr>
                        <td>File name</td>
                        <td>Size</td>
                        <td>Operations</td>
                    </tr>
                </thead>
                <tbody name="fileTableBody", id="fileTableBody">
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
