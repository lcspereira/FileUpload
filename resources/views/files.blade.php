<x-app-layout>
    <x-slot name="header">
        {{ __('Files') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table>
                    @foreach ($files as $file)
                       <tr>
                            <td>{{ $file->path }}</td>
                       </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
