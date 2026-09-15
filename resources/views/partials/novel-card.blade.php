<div class="novel-card">
    <a href="{{ route('novels.show', $novel) }}" class="novel-card-link">
        <div class="novel-cover">
            @if($novel->cover)
                <img src="{{ asset('storage/' . $novel->cover) }}" alt="{{ $novel->title }}" loading="lazy">
            @else
                <div class="novel-cover-placeholder">
                    <span class="cover-genre-icon">
                        @php
                            $icons = ['Fantasy'=>'🗡️','Romance'=>'💕','Action'=>'⚡','Mystery'=>'🔍','Horror'=>'👻','Comedy'=>'😂','Drama'=>'🎭','Sci-Fi'=>'🚀','Adventure'=>'🗺️','Thriller'=>'🕵️','Slice of Life'=>'🌸'];
                            echo $icons[$novel->genre] ?? '📖';
                        @endphp
                    </span>
                    <span class="cover-title">{{ Str::limit($novel->title, 20) }}</span>
                </div>
            @endif
            <div class="novel-card-overlay">
                <span class="btn btn-primary btn-sm">Baca Sekarang</span>
            </div>
            <div class="novel-status-badge {{ $novel->status === 'completed' ? 'badge-completed' : 'badge-ongoing' }}">
                {{ $novel->status === 'completed' ? '✅ Tamat' : '🔄 Ongoing' }}
            </div>
        </div>
        <div class="novel-card-body">
            <div class="novel-genre-tag">{{ $novel->genre }}</div>
            <h3 class="novel-card-title">{{ $novel->title }}</h3>
            <p class="novel-card-synopsis">{{ Str::limit($novel->synopsis, 80) }}</p>
            <div class="novel-card-meta">
                <span title="Chapter">📖 {{ $novel->chapters_count ?? $novel->chapters->count() }} Ch</span>
                <span title="Views">👁 {{ number_format($novel->views) }}</span>
                <span title="Likes">❤️ {{ $novel->likes_count ?? 0 }}</span>
            </div>
        </div>
    </a>
</div>
