@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang di sistem manajemen Booksales.</p>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-booksales">
            <div class="card-body text-center">
                <i class="bi bi-book" style="font-size:1.5rem; color: var(--booksales-accent);"></i>
                <h3 class="mt-2 mb-0" style="font-weight:800;">142</h3>
                <small style="color: var(--booksales-muted);">Total Buku</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-booksales">
            <div class="card-body text-center">
                <i class="bi bi-tags" style="font-size:1.5rem; color: #4fad6a;"></i>
                <h3 class="mt-2 mb-0" style="font-weight:800;">5</h3>
                <small style="color: var(--booksales-muted);">Genre</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-booksales">
            <div class="card-body text-center">
                <i class="bi bi-feather" style="font-size:1.5rem; color: #5a9fd4;"></i>
                <h3 class="mt-2 mb-0" style="font-weight:800;">5</h3>
                <small style="color: var(--booksales-muted);">Author</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-booksales">
            <div class="card-body text-center">
                <i class="bi bi-cart" style="font-size:1.5rem; color: #d94f4f;"></i>
                <h3 class="mt-2 mb-0" style="font-weight:800;">38</h3>
                <small style="color: var(--booksales-muted);">Penjualan</small>
            </div>
        </div>
    </div>
</div>

<!-- Navigasi cepat -->
<div class="row g-3">
    <div class="col-md-6">
        <a href="/genres" class="text-decoration-none">
            <div class="card card-booksales h-100" style="cursor:pointer;">
                <div class="card-body text-center py-4">
                    <i class="bi bi-tags" style="font-size:2.5rem; color: var(--booksales-accent);"></i>
                    <h4 class="mt-3 mb-1" style="color: var(--booksales-text);">Lihat Data Genre</h4>
                    <small style="color: var(--booksales-muted);">5 genre tercatat</small>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="/authors" class="text-decoration-none">
            <div class="card card-booksales h-100" style="cursor:pointer;">
                <div class="card-body text-center py-4">
                    <i class="bi bi-feather" style="font-size:2.5rem; color: var(--booksales-accent);"></i>
                    <h4 class="mt-3 mb-1" style="color: var(--booksales-text);">Lihat Data Author</h4>
                    <small style="color: var(--booksales-muted);">5 author terdaftar</small>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection