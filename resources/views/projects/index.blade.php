<h1>Tambah Project</h1>

<form method="POST" action="/projects">
    @csrf

    <input type="text" name="title" placeholder="Judul project">
    <br>

    <textarea name="description" placeholder="Deskripsi"></textarea>
    <br>

    <select name="division_id">
        @foreach($divisions as $d)
            <option value="{{ $d->id }}">{{ $d->name }}</option>
        @endforeach
    </select>

    <br><br>
    <button>Simpan</button>
</form>