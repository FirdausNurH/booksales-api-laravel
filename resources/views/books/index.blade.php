<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
    <style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid black; padding: 8px; }</style>
</head>
<body>
    <h1>Daftar Buku dan Author</h1>
    <table>
        <tr>
            <th>Judul Buku</th>
            <th>Author</th>
            <th>Tahun</th>
            <th>Deskripsi</th>
        </tr>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author->name }}</td>
            <td>{{ $book->year_published }}</td>
            <td>{{ $book->description }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>