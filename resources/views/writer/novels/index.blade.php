@extends('layouts.app')

@section('title', 'Novel Saya')

@section('content')
<div class="container" style="padding: 2rem 0 4rem;">
    <div class="section-header" style="margin-bottom: 1.5rem;">
        <div>
            <p class="eyebrow">Area Penulis</p>
            <h1>Novel Saya</h1>
        </div>
        <a href="{{ route('writer.novels.create') }}" class="btn btn-primary">+ Tambah Novel</a>
    </div>

    @forelse($novels as $novel)
        <div class="admin-card" style="margin-bottom: 1rem;">
            <div class="admin-card-body" style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap;">
                <div>
                    <h3 style="margin:0 0 .3rem;">{{ $novel->title }}</h3>
                    <div class="di-meta">{{ $novel->genre }} • {{ $novel->status }} • {{ $novel->chapters_count }} chapter</div>
                </div>
                <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
                    <a href="{{ route('writer.novels.edit', $novel) }}" class="btn btn-sm btn-outline">Edit</a>
                    <a href="{{ route('writer.chapters.create', $novel) }}" class="btn btn-sm btn-primary">Tambah Chapter</a>
                    <form method="POST" action="{{ route('writer.novels.destroy', $novel) }}" onsubmit="return confirm('Yakin hapus novel ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="admin-card">
            <div class="admin-card-body">
                <p>Belum ada novel yang kamu buat.</p>
            </div>
        </div>
    @endforelse

    <div style="margin-top: 1.5rem;">
        {{ $novels->links() }}
    </div>
</div>
@endsection
