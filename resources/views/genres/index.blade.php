@extends('layouts.app')

@section('title', 'Data Genre')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-tags" style="color: var(--booksales-accent);"></i> Data Genre</h1>
    <p>Daftar seluruh genre buku yang tercatat pada sistem Booksales.</p>
</div>

<div class="card card-booksales">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-ul"></i> Tabel Genre</span>
        <span class="badge-book">{{ count($genres) }} genre</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-booksales">
                <thead>
                    <tr>
                        <th style="width:60px;">ID</th>
                        <th>Nama Genre</th>
                        <th>Deskripsi</th>
                        <th style="width:120px;">Jumlah Buku</th>
                        <th style="width:120px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($genres as $genre)
                    <tr>
                        <td style="font-weight:700; color: var(--booksales-muted);">#{{ $genre['id'] }}</td>
                        <td style="font-weight:600;">{{ $genre['name'] }}</td>
                        <td style="color: var(--booksales-muted); font-size:0.88rem;">{{ $genre['description'] }}</td>
                        <td>
                            <span class="badge-book">
                                <i class="bi bi-book"></i> {{ $genre['book_count'] }}
                            </span>
                        </td>
                        <td>
                            @if($genre['status'] === 'active')
                                <span class="badge rounded-pill badge-active">Aktif</span>
                            @else
                                <span class="badge rounded-pill badge-inactive">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection