@extends('layouts.app')

@section('title', 'Data Author')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-feather" style="color: var(--booksales-accent);"></i> Data Author</h1>
    <p>Daftar seluruh penulis yang terdaftar pada sistem Booksales.</p>
</div>

<div class="card card-booksales">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-ul"></i> Tabel Author</span>
        <span class="badge-book">{{ count($authors) }} author</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-booksales">
                <thead>
                    <tr>
                        <th style="width:60px;">ID</th>
                        <th>Nama Author</th>
                        <th>Negara</th>
                        <th>Genre Spesialisasi</th>
                        <th style="width:120px;">Jumlah Buku</th>
                        <th style="width:120px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                    <tr>
                        <td style="font-weight:700; color: var(--booksales-muted);">#{{ $author['id'] }}</td>
                        <td style="font-weight:600;">{{ $author['name'] }}</td>
                        <td style="color: var(--booksales-muted); font-size:0.88rem;">
                            <i class="bi bi-globe-americas"></i> {{ $author['country'] }}
                        </td>
                        <td>
                            <span class="badge-book">
                                <i class="bi bi-tag"></i> {{ $author['specialty'] }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-book">
                                <i class="bi bi-book"></i> {{ $author['book_count'] }}
                            </span>
                        </td>
                        <td>
                            @if($author['status'] === 'active')
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