@extends('layouts.app')

@section('title', $novel->title)
@section('meta_description', Str::limit($novel->synopsis, 155))

@section('content')
<div class="novel-detail-hero">
    <div class="container">
        <div class="novel-detail-layout">
            <!-- COVER -->
            <div class="novel-detail-cover">
                @if($novel->cover)
                    <img src="{{ asset('storage/' . $novel->cover) }}" alt="{{ $novel->title }}" class="detail-cover-img">
                @else
                    <div class="detail-cover-placeholder">
                        <span class="cover-big-icon">
                            @php
                                $icons = ['Fantasy'=>'🗡️','Romance'=>'💕','Action'=>'⚡','Mystery'=>'🔍','Horror'=>'👻','Comedy'=>'😂','Drama'=>'🎭','Sci-Fi'=>'🚀','Adventure'=>'🗺️','Thriller'=>'🕵️','Slice of Life'=>'🌸'];
                                echo $icons[$novel->genre] ?? '📖';
                            @endphp
                        </span>
                        <span>{{ $novel->title }}</span>
                    </div>
                @endif
            </div>

            <!-- INFO -->
            <div class="novel-detail-info">
                <div class="detail-badges">
                    <span class="genre-badge">{{ $novel->genre }}</span>
                    <span class="status-badge {{ $novel->status === 'completed' ? 'badge-completed' : 'badge-ongoing' }}">
                        {{ $novel->status === 'completed' ? '✅ Tamat' : '🔄 Ongoing' }}
                    </span>
                </div>

                <h1 class="detail-title">{{ $novel->title }}</h1>

                <div class="detail-meta-row">
                    <div class="detail-meta-item">
                        <span class="meta-icon">✍️</span>
                        <span>{{ $novel->user->name }}</span>
                    </div>
                    <div class="detail-meta-item">
                        <span class="meta-icon">📖</span>
                        <span>{{ $novel->chapters_count }} Chapter</span>
                    </div>
                    <div class="detail-meta-item">
                        <span class="meta-icon">👁</span>
                        <span>{{ number_format($novel->views) }} Views</span>
                    </div>
                    <div class="detail-meta-item">
                        <span class="meta-icon">❤️</span>
                        <span>{{ $novel->likes_count }} Likes</span>
                    </div>
                    <div class="detail-meta-item">
                        <span class="meta-icon">⭐</span>
                        <span>{{ $novel->averageRating() }} / 5.0 ({{ $novel->ratings->count() }} ulasan)</span>
                    </div>
                </div>

                <div class="detail-synopsis">
                    <h3>Sinopsis</h3>
                    <p>{{ $novel->synopsis }}</p>
                </div>

                <div class="detail-actions">
                    @if($novel->chapters->isNotEmpty())
                        <a href="{{ route('chapters.show', [$novel, $novel->chapters->first()]) }}" class="btn btn-primary btn-lg">
                            📖 Mulai Baca
                        </a>
                    @endif

                    @auth
                        <!-- BOOKMARK -->
                        <form method="POST" action="{{ route('bookmark.toggle', $novel) }}" class="inline-form">
                            @csrf
                            <button type="submit" class="btn {{ $isBookmarked ? 'btn-accent' : 'btn-outline' }} btn-lg">
                                {{ $isBookmarked ? '🔖 Bookmarked' : '🔖 Bookmark' }}
                            </button>
                        </form>

                        <!-- LIKE -->
                        <form method="POST" action="{{ route('like.toggle', $novel) }}" class="inline-form">
                            @csrf
                            <button type="submit" class="btn {{ $isLiked ? 'btn-danger' : 'btn-outline' }} btn-lg">
                                {{ $isLiked ? '❤️ Liked' : '🤍 Like' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline btn-lg">🔖 Login untuk Bookmark</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CHAPTERS LIST -->
<section class="section">
    <div class="container">
        <h2 class="section-title">📑 Daftar Chapter</h2>
        @if($novel->chapters->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>Belum ada chapter untuk novel ini.</p>
            </div>
        @else
            <div class="chapters-list">
                @foreach($novel->chapters as $chapter)
                    <a href="{{ route('chapters.show', [$novel, $chapter]) }}" class="chapter-item">
                        <div class="chapter-item-left">
                            <span class="chapter-num">Chapter {{ $chapter->chapter_number }}</span>
                            <span class="chapter-title">{{ $chapter->title }}</span>
                        </div>
                        <div class="chapter-item-right">
                            <span class="chapter-views">👁 {{ number_format($chapter->views) }}</span>
                            <span class="chapter-date">{{ $chapter->created_at->format('d M Y') }}</span>
                            <span class="chapter-arrow">→</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- REVIEWS & RATING SECTION -->
<section class="section section-alt">
    <div class="container">
        <h2 class="section-title">⭐ Ulasan & Rating Novel</h2>

        @auth
        <div class="rating-box" style="background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius); border: 1px solid var(--border); margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: #fff;">Beri Rating & Ulasan untuk Novel Ini</h3>
            <form method="POST" action="{{ route('ratings.store', $novel) }}">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label class="form-label" style="margin-bottom: 0.5rem; display: block;">Pilih Bintang Rating: <span id="starRatingLabel" style="color: var(--accent); font-weight: 700;">5 Bintang (⭐⭐⭐⭐⭐)</span></label>
                    <div class="star-rating" style="display: flex; gap: 0.5rem; font-size: 2rem; cursor: pointer;">
                        @for($i = 1; $i <= 5; $i++)
                        <label style="cursor: pointer; display: inline-block;">
                            <input type="radio" name="stars" value="{{ $i }}" {{ $i === 5 ? 'checked' : '' }} onchange="updateStarDisplay({{ $i }})" style="display: none;">
                            <span class="star-item" id="star-{{ $i }}" onclick="selectStar({{ $i }})" style="transition: transform 0.2s; display: inline-block;">⭐</span>
                        </label>
                        @endfor
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label class="form-label" for="review-text">Tulis Ulasan (Opsional):</label>
                    <textarea id="review-text" name="review" class="form-textarea" rows="3" placeholder="Bagikan pendapat Anda mengenai alur cerita atau karakter di novel ini..."></textarea>
                    @error('review') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">⭐ Kirim Ulasan</button>
            </form>
        </div>

        <script>
        function selectStar(val) {
            const radios = document.querySelectorAll('input[name="stars"]');
            radios.forEach(radio => {
                if (parseInt(radio.value) === val) {
                    radio.checked = true;
                }
            });
            updateStarDisplay(val);
        }

        function updateStarDisplay(val) {
            const starsText = '⭐'.repeat(val);
            const label = document.getElementById('starRatingLabel');
            if (label) {
                label.textContent = `${val} Bintang (${starsText})`;
            }
            for (let i = 1; i <= 5; i++) {
                const el = document.getElementById(`star-${i}`);
                if (el) {
                    if (i <= val) {
                        el.style.filter = 'grayscale(0%)';
                        el.style.opacity = '1';
                        el.style.transform = 'scale(1.1)';
                    } else {
                        el.style.filter = 'grayscale(100%)';
                        el.style.opacity = '0.3';
                        el.style.transform = 'scale(1)';
                    }
                }
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            updateStarDisplay(5);
        });
        </script>
        @else
        <div class="comment-login-prompt" style="margin-bottom: 2rem;">
            <a href="{{ route('login') }}">Login</a> untuk memberikan rating & ulasan.
        </div>
        @endauth

        <div class="reviews-list" style="display: flex; flex-direction: column; gap: 1rem;">
            @forelse($novel->ratings()->with('user')->latest()->get() as $rating)
            <div style="background: var(--bg-card); padding: 1.25rem; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <strong style="font-size: 0.9rem;">{{ $rating->user->name }}</strong>
                    <span style="color: var(--accent); font-weight: 700;">{{ str_repeat('⭐', $rating->stars) }}</span>
                </div>
                @if($rating->review)
                    <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">{{ $rating->review }}</p>
                @endif
            </div>
            @empty
            <p style="color: var(--text-muted);">Belum ada ulasan untuk novel ini.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
