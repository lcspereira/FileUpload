<x-app-layout>
    <form method="POST" action={{ @url('/files/rename/' . $idFile) }}>
        <input type="text" value='' />
        <button type="submit" class="btn btn-primary" id="btnSendRename">Rename</button>
    </form>
</x-app-layout>
