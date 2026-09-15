@extends('layouts.reader')

@section('title', 'Ch.' . $chapter->chapter_number . ' - ' . $novel->title)

@section('content')
<div class="reader-container">
    <div class="reader-chapter-header">
        <div class="reader-breadcrumb">
            <a href="{{ route('novels.show', $novel) }}">{{ $novel->title }}</a>
            <span>›</span>
            <span>Chapter {{ $chapter->chapter_number }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap;">
            <h1 class="reader-chapter-title" style="margin: 0;">Chapter {{ $chapter->chapter_number }}: {{ $chapter->title }}</h1>
            @unless($locked)
                <a href="{{ route('chapters.pdf', [$novel, $chapter]) }}" class="reader-ctrl-btn" style="display: inline-flex; align-items: center; gap: 0.3rem;" title="Download PDF">
                    📄 Download PDF
                </a>
            @endunless
        </div>
    </div>

    @if(session('reading_reward'))
        <div class="alert alert-success">
            @if(session('reading_reward.points') > 0)
                Anda mendapatkan {{ session('reading_reward.points') }} poin membaca.
                @if(session('reading_reward.coins') > 0)
                    Bonus {{ session('reading_reward.coins') }} coin juga ditambahkan.
                @else
                    Terus membaca untuk mencapai 100 poin dan mendapatkan coin.
                @endif
            @else
                Reward untuk chapter ini sudah pernah diterima.
            @endif
        </div>
    @endif

    <!-- CONTENT -->
    @if($locked)
        <div class="reader-content" id="readerContent" style="text-align: center;">
            <h2>Chapter Premium</h2>
            <p>Chapter ini membutuhkan {{ $chapter->coin_price }} coin untuk dibaca.</p>
            @auth
                <p>Saldo Anda: {{ auth()->user()->coins }} coin</p>
                <form method="POST" action="{{ route('chapters.unlock', [$novel, $chapter]) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" @disabled(auth()->user()->coins < $chapter->coin_price)>
                        Buka Chapter dengan {{ $chapter->coin_price }} Coin
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login untuk Membuka</a>
            @endauth
        </div>
    @else
        <div class="reader-content" id="readerContent">
            {!! nl2br(e($chapter->content)) !!}
        </div>
        @auth
            <form method="POST" action="{{ route('chapters.complete', [$novel, $chapter]) }}" id="completeReadingForm" class="reading-completion">
                @csrf
                <div class="reading-progress-track"><span id="readingProgressBar"></span></div>
                <p id="readingProgress" class="reading-progress-label">Progress membaca: 0%. Baca sampai 80% untuk mendapatkan reward.</p>
                <button type="submit" class="btn btn-primary" id="completeReadingButton" disabled>
                    Tandai Chapter Selesai
                </button>
            </form>
        @endauth
    @endif

    <!-- NAVIGATION -->
    <div class="reader-nav-bottom">
        @if($prevChapter)
            <a href="{{ route('chapters.show', [$novel, $prevChapter]) }}" class="btn btn-outline reader-nav-btn">
                ← Chapter {{ $prevChapter->chapter_number }}
            </a>
        @else
            <span class="reader-nav-btn disabled">← Pertama</span>
        @endif

        <a href="{{ route('novels.show', $novel) }}" class="btn btn-outline reader-nav-btn">Daftar Chapter</a>

        @if($nextChapter)
            <a href="{{ route('chapters.show', [$novel, $nextChapter]) }}" class="btn btn-primary reader-nav-btn">
                Chapter {{ $nextChapter->chapter_number }} →
            </a>
        @else
            <span class="reader-nav-btn disabled">Terakhir →</span>
        @endif
    </div>

    <!-- COMMENTS SECTION -->
    <div class="reader-comments">
        <h2 class="comments-title">💬 Komentar ({{ $chapter->comments->count() }})</h2>

        @auth
        <form method="POST" action="{{ route('comments.store', $chapter) }}" class="comment-form">
            @csrf
            <div class="comment-input-row">
                <div class="comment-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="comment-input-wrap">
                    <textarea name="content" class="comment-textarea" placeholder="Tulis komentar..." rows="3" required maxlength="1000">{{ old('content') }}</textarea>
                    @error('content') <span class="field-error">{{ $message }}</span> @enderror
                    <button type="submit" class="btn btn-primary btn-sm">Kirim Komentar</button>
                </div>
            </div>
        </form>
        @else
        <div class="comment-login-prompt">
            <a href="{{ route('login') }}">Login</a> untuk menulis komentar.
        </div>
        @endauth

        <!-- COMMENTS LIST -->
        <div class="comments-list">
            @forelse($chapter->comments as $comment)
            <div class="comment-item">
                <div class="comment-avatar-wrap">
                    <div class="comment-avatar">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                </div>
                <div class="comment-body">
                    <div class="comment-header">
                        <strong class="comment-author">{{ $comment->user->name }}</strong>
                        @if($comment->user->isAdmin())
                            <span class="admin-tag">Admin</span>
                        @endif
                        <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                        @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isAdmin()))
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline-form" onsubmit="return confirm('Hapus komentar?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="comment-delete" title="Hapus Komentar">🗑</button>
                            </form>
                        @elseif(auth()->check())
                            <button type="button" onclick="reportComment({{ $comment->id }})" class="comment-delete" style="color: var(--accent); opacity: 0.7;" title="Laporkan Komentar">🚩</button>
                        @endif
                    </div>
                    <p class="comment-text">{{ $comment->content }}</p>
                </div>
            </div>
            @empty
            <div class="no-comments">Belum ada komentar. Jadilah yang pertama!</div>
            @endforelse
        </div>
    </div>
</div>

@auth
<script>
const readerContent = document.getElementById('readerContent');
const completeReadingButton = document.getElementById('completeReadingButton');
const readingProgress = document.getElementById('readingProgress');
const readingProgressBar = document.getElementById('readingProgressBar');

if (readerContent && completeReadingButton && readingProgress && readingProgressBar) {
    const updateReadingProgress = () => {
        const contentBottom = readerContent.offsetTop + readerContent.offsetHeight;
        const viewportBottom = window.scrollY + window.innerHeight;
        const progress = Math.min(100, Math.round((viewportBottom / contentBottom) * 100));

        readingProgress.textContent = progress >= 80
            ? 'Chapter hampir selesai. Reward siap diambil.'
            : `Progress membaca: ${progress}%. Baca sampai 80% untuk mendapatkan reward.`;
        readingProgressBar.style.width = `${progress}%`;
        completeReadingButton.disabled = progress < 80;
    };

    window.addEventListener('scroll', updateReadingProgress, { passive: true });
    window.addEventListener('resize', updateReadingProgress);
    updateReadingProgress();
}

function reportComment(commentId) {
    const reason = prompt('Tuliskan alasan pelaporan komentar ini (contoh: Spam, SARA, Kata-kata kasar):');
    if (reason && reason.trim() !== '') {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/comments/${commentId}/report`;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'reason';
        reasonInput.value = reason;
        form.appendChild(reasonInput);

        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endauth
@endsection
