@extends('layouts.admin')

@section('title', $novel->title . ' - Chapters')
@section('page_title', '📑 ' . $novel->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3>{{ $novel->title }}</h3>
            <div class="card-subtitle">{{ $novel->chapters_count }} chapter • {{ number_format($novel->views) }} views • ❤️ {{ $novel->likes_count }}</div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.chapters.create', $novel) }}" class="btn btn-primary">➕ Tambah Chapter</a>
            <a href="{{ route('admin.novels.edit', $novel) }}" class="btn btn-outline">✏️ Edit Novel</a>
        </div>
    </div>
    <div class="admin-card-body">
        @if($novel->chapters->isEmpty())
            <div class="empty-state-sm">
                <p>Belum ada chapter. <a href="{{ route('admin.chapters.create', $novel) }}">Tambah sekarang</a>.</p>
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Chapter</th>
                            <th>Judul</th>
                            <th>Views</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($novel->chapters as $chapter)
                        <tr>
                            <td><strong>Ch. {{ $chapter->chapter_number }}</strong></td>
                            <td>{{ $chapter->title }}</td>
                            <td>{{ number_format($chapter->views) }}</td>
                            <td>{{ $chapter->comments()->count() }}</td>
                            <td>{{ $chapter->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('chapters.show', [$novel, $chapter]) }}" class="action-btn action-view" target="_blank" title="Baca">👁️</a>
                                    <a href="{{ route('admin.chapters.edit', [$novel, $chapter]) }}" class="action-btn action-edit" title="Edit">✏️</a>
                                    <form method="POST" action="{{ route('admin.chapters.destroy', [$novel, $chapter]) }}" class="inline-form" onsubmit="return confirm('Hapus chapter ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn action-delete" title="Hapus">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
