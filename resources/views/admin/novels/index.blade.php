@extends('layouts.admin')

@section('title', 'Kelola Novel')
@section('page_title', '📚 Kelola Novel')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3>Daftar Novel ({{ $novels->total() }})</h3>
        <a href="{{ route('admin.novels.create') }}" class="btn btn-primary">➕ Tambah Novel</a>
    </div>
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Novel</th>
                        <th>Genre</th>
                        <th>Status</th>
                        <th>Chapter</th>
                        <th>Views</th>
                        <th>Likes</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($novels as $novel)
                    <tr>
                        <td>{{ $novels->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="table-novel-info">
                                <div class="table-novel-title">{{ $novel->title }}</div>
                                <div class="table-novel-meta">oleh {{ $novel->user->name }}</div>
                            </div>
                        </td>
                        <td><span class="genre-tag-sm">{{ $novel->genre }}</span></td>
                        <td>
                            <span class="status-dot {{ $novel->status === 'completed' ? 'dot-completed' : 'dot-ongoing' }}">
                                {{ $novel->status === 'completed' ? 'Tamat' : 'Ongoing' }}
                            </span>
                        </td>
                        <td>{{ $novel->chapters_count }}</td>
                        <td>{{ number_format($novel->views) }}</td>
                        <td>{{ $novel->likes_count }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.novels.show', $novel) }}" class="action-btn action-view" title="Lihat Chapter">📑</a>
                                <a href="{{ route('admin.chapters.create', $novel) }}" class="action-btn action-add" title="Tambah Chapter">➕</a>
                                <a href="{{ route('admin.novels.edit', $novel) }}" class="action-btn action-edit" title="Edit">✏️</a>
                                <form method="POST" action="{{ route('admin.novels.destroy', $novel) }}" class="inline-form" onsubmit="return confirm('Hapus novel {{ addslashes($novel->title) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn action-delete" title="Hapus">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="table-empty">Belum ada novel. <a href="{{ route('admin.novels.create') }}">Tambah sekarang</a>.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            {{ $novels->links('partials.pagination') }}
        </div>
    </div>
</div>
@endsection
