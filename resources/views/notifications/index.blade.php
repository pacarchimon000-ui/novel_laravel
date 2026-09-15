@extends('layouts.app')

@section('title', 'Notifikasi Saya')

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="page-title">🔔 Notifikasi Saya</h1>
        <p class="page-subtitle">Informasi update rilis chapter dari novel yang Anda ikuti.</p>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width: 800px;">
        @if($notifications->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🔔</div>
                <h3>Belum ada notifikasi</h3>
                <p>Saat novel yang Anda bookmark merilis chapter baru, notifikasinya akan muncul di sini.</p>
                <a href="{{ route('novels.index') }}" class="btn btn-primary">Jelajahi Novel</a>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($notifications as $notification)
                    <div style="background: var(--bg-card); border: 1px solid var(--border); padding: 1.25rem 1.5rem; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                        <div>
                            <div style="font-weight: 600; color: #fff; margin-bottom: 0.25rem;">
                                {{ $notification->data['message'] ?? 'Ada pembaruan novel untukmu!' }}
                            </div>
                            @if(($notification->data['type'] ?? null) === 'writer_status' && ($notification->data['status'] ?? null) === 'rejected' && !empty($notification->data['reason']))
                                <div style="color: var(--text-muted); margin-bottom: 0.5rem;">
                                    <strong>Alasan admin:</strong> {{ $notification->data['reason'] }}
                                </div>
                            @endif
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>

                        @if(isset($notification->data['novel_slug']) && isset($notification->data['chapter_number']))
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    📖 Baca Chapter
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper" style="margin-top: 2rem;">
                {{ $notifications->links('partials.pagination') }}
            </div>
        @endif
    </div>
</section>
@endsection
