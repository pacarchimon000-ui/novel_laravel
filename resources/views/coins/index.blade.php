@extends('layouts.app')

@section('title', 'EXP & Koin')

@push('styles')
<style>
    /* ===== EXP PAGE ===== */
    .exp-hero {
        background: linear-gradient(135deg, var(--bg-surface) 0%, var(--bg-card) 100%);
        border-bottom: 1px solid var(--border);
        padding: 2.5rem 0 2rem;
        margin-bottom: 0;
    }
    .exp-hero-inner {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }
    .exp-coin-display {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: var(--bg);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-lg);
        padding: 1.25rem 2rem;
        flex: 1;
        min-width: 220px;
    }
    .exp-coin-icon {
        font-size: 2.5rem;
        line-height: 1;
    }
    .exp-coin-val {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--accent);
        line-height: 1;
    }
    .exp-coin-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.15rem;
    }
    .exp-level-display {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, #5b21b6, #7c3aed);
        border-radius: var(--radius-lg);
        padding: 1.25rem 2rem;
        flex: 1;
        min-width: 220px;
    }
    .exp-level-icon { font-size: 2.5rem; line-height: 1; }
    .exp-level-val {
        font-size: 2.2rem;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }
    .exp-level-label {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.7);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.15rem;
    }
    .exp-pts-display {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: var(--bg);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-lg);
        padding: 1.25rem 2rem;
        flex: 1;
        min-width: 220px;
    }
    .exp-pts-icon { font-size: 2.5rem; line-height: 1; }
    .exp-pts-val {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--primary-light);
        line-height: 1;
    }
    .exp-pts-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.15rem;
    }

    /* Progress */
    .progress-section {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.75rem;
        margin-bottom: 1.5rem;
    }
    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .progress-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text);
    }
    .progress-info {
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    .progress-bar-wrap {
        background: var(--bg);
        border-radius: 999px;
        height: 12px;
        overflow: hidden;
        border: 1px solid var(--border);
        margin-bottom: 0.75rem;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
        transition: width 0.6s ease;
        position: relative;
    }
    .progress-bar-fill::after {
        content: '';
        position: absolute;
        right: 0; top: 0; bottom: 0;
        width: 6px;
        background: rgba(255,255,255,0.4);
        border-radius: 50%;
    }
    .progress-caption {
        font-size: 0.82rem;
        color: var(--text-muted);
    }
    .progress-caption strong { color: var(--accent); }

    /* How to earn */
    .how-section {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.75rem;
        margin-bottom: 1.5rem;
    }
    .how-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .how-steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .how-step {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 1.25rem;
        text-align: center;
        position: relative;
    }
    .how-step-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        display: block;
    }
    .how-step-title {
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
        color: var(--text);
    }
    .how-step-desc {
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.5;
    }
    .how-step-reward {
        margin-top: 0.5rem;
        display: inline-block;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
    }
    .arrow-connector {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--text-dim);
        padding: 0 0.25rem;
    }

    /* Reward history */
    .reward-section {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .reward-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid var(--border);
    }
    .reward-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .reward-count-badge {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 999px;
        font-size: 0.75rem;
        padding: 0.15rem 0.6rem;
        color: var(--text-muted);
    }
    .reward-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.75rem;
        border-bottom: 1px solid var(--border);
        gap: 1rem;
        transition: background 0.15s;
    }
    .reward-item:last-child { border-bottom: none; }
    .reward-item:hover { background: var(--bg-hover); }
    .reward-item-left { flex: 1; min-width: 0; }
    .reward-novel-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .reward-chapter-info {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.15rem;
    }
    .reward-item-right {
        text-align: right;
        flex-shrink: 0;
    }
    .reward-pts {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--primary-light);
    }
    .reward-coin {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--accent);
    }
    .reward-date {
        font-size: 0.75rem;
        color: var(--text-dim);
        margin-top: 0.15rem;
    }
    .reward-empty {
        padding: 3rem 2rem;
        text-align: center;
        color: var(--text-muted);
    }
    .reward-empty-icon { font-size: 3rem; margin-bottom: 0.75rem; display: block; }

    /* Milestone badge */
    .milestone-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #78350f;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        margin-left: 0.4rem;
    }
</style>
@endpush

@section('content')

{{-- HERO STATS --}}
<div class="exp-hero">
    <div class="container">
        <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:1.25rem;">⚡ EXP & Koin Saya</h1>
        <div class="exp-hero-inner">
            <div class="exp-coin-display">
                <div class="exp-coin-icon">
                    <svg width="42" height="42" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;">
                        <circle cx="12" cy="12" r="10" fill="url(#goldGrad)" stroke="#f59e0b" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="7.5" stroke="#b45309" stroke-width="1" stroke-dasharray="2 2"/>
                        <text x="12" y="15.5" font-size="10" font-weight="900" fill="#78350f" text-anchor="middle" font-family="'Poppins', sans-serif">C</text>
                        <defs>
                            <linearGradient id="goldGrad" x1="4" y1="4" x2="20" y2="20" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#fef08a"/>
                                <stop offset="0.5" stop-color="#f59e0b"/>
                                <stop offset="1" stop-color="#d97706"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div>
                    <div class="exp-coin-val">{{ number_format($user->coins) }}</div>
                    <div class="exp-coin-label">Saldo Koin</div>
                </div>
            </div>
            <div class="exp-level-display">
                <div class="exp-level-icon">🏆</div>
                <div>
                    <div class="exp-level-val">Level {{ $user->reading_level }}</div>
                    <div class="exp-level-label">Level Membaca</div>
                </div>
            </div>
            <div class="exp-pts-display">
                <div class="exp-pts-icon">⭐</div>
                <div>
                    <div class="exp-pts-val">{{ number_format($user->reading_points) }}</div>
                    <div class="exp-pts-label">Total Poin EXP</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding-top: 1.75rem; padding-bottom: 4rem;">

    {{-- PROGRESS BAR --}}
    <div class="progress-section">
        <div class="progress-header">
            <div class="progress-title">📈 Progress ke Milestone Berikutnya</div>
            <div class="progress-info">{{ $levelProgress }}<span style="color:var(--text-dim)">/100 poin</span></div>
        </div>
        <div class="progress-bar-wrap">
            <div class="progress-bar-fill" style="width: {{ $levelProgress }}%"></div>
        </div>
        <div class="progress-caption">
            Butuh <strong>{{ $pointsToNextMilestone }} poin lagi</strong> untuk mendapatkan
            <strong style="color:var(--accent)">+2 <span class="coin-badge" style="width:1.3rem;height:1.3rem;font-size:0.7rem;font-weight:900;border:1.5px solid #f59e0b;background:linear-gradient(135deg,#fef08a,#f59e0b);color:#78350f;display:inline-flex;align-items:center;justify-content:center;border-radius:50%;vertical-align:-0.15rem;margin:0 0.15rem;">C</span> Koin</strong>
            &nbsp;·&nbsp;
            Total milestone dicapai: <strong>{{ $totalMilestones }}×</strong>
        </div>
    </div>

    {{-- HOW TO EARN --}}
    <div class="how-section">
        <div class="how-title">💡 Cara Mendapatkan Koin</div>
        <div class="how-steps">
            <div class="how-step">
                <span class="how-step-icon">📖</span>
                <div class="how-step-title">Baca Chapter</div>
                <div class="how-step-desc">Baca chapter novel sampai 80% dan klik "Tandai Selesai"</div>
                <span class="how-step-reward">+5 EXP</span>
            </div>
            <div class="arrow-connector">→</div>
            <div class="how-step">
                <span class="how-step-icon">⭐</span>
                <div class="how-step-title">Kumpulkan EXP</div>
                <div class="how-step-desc">Setiap chapter selesai memberikan 5 poin EXP untuk progress kamu</div>
                <span class="how-step-reward">Kumpul 100 EXP</span>
            </div>
            <div class="arrow-connector">→</div>
            <div class="how-step">
                <span class="how-step-icon" style="display:flex; justify-content:center; align-items:center;">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" fill="url(#stepGoldGrad)" stroke="#f59e0b" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="7.5" stroke="#b45309" stroke-width="1" stroke-dasharray="2 2"/>
                        <text x="12" y="15.5" font-size="10" font-weight="900" fill="#78350f" text-anchor="middle" font-family="'Poppins', sans-serif">C</text>
                        <defs>
                            <linearGradient id="stepGoldGrad" x1="4" y1="4" x2="20" y2="20" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#fef08a"/>
                                <stop offset="0.5" stop-color="#f59e0b"/>
                                <stop offset="1" stop-color="#d97706"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </span>
                <div class="how-step-title">Dapat Koin!</div>
                <div class="how-step-desc">Setiap kali mencapai kelipatan 100 EXP, kamu otomatis dapat bonus koin</div>
                <span class="how-step-reward">+2 Koin Gratis</span>
            </div>
        </div>
        <div style="margin-top:1rem; padding: 0.85rem 1rem; background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.83rem; color: var(--text-muted); line-height: 1.7;">
            💎 <strong style="color:var(--text)">Gunakan koin</strong> untuk membuka chapter premium berbayar di novel favoritmu. Semakin banyak membaca, semakin banyak koin yang kamu kumpulkan secara gratis!
        </div>
    </div>

    {{-- REWARD HISTORY --}}
    <div class="reward-section">
        <div class="reward-section-header">
            <div class="reward-section-title">
                📜 Riwayat Reward Membaca
                <span class="reward-count-badge">{{ $rewards->total() }} aktivitas</span>
            </div>
        </div>

        @forelse($rewards as $reward)
            <div class="reward-item">
                <div class="reward-item-left">
                    <div class="reward-novel-title">
                        {{ $reward->chapter->novel->title ?? '—' }}
                    </div>
                    <div class="reward-chapter-info">
                        Chapter {{ $reward->chapter->chapter_number ?? '—' }}: {{ $reward->chapter->title ?? '' }}
                    </div>
                </div>
                <div class="reward-item-right">
                    <div class="reward-pts">+{{ $reward->points }} EXP</div>
                    @if($reward->coins > 0)
                        <div class="reward-coin">
                            +{{ $reward->coins }} <span class="coin-badge" style="width:1.1rem;height:1.1rem;font-size:0.6rem;font-weight:900;border:1px solid #f59e0b;background:linear-gradient(135deg,#fef08a,#f59e0b);color:#78350f;display:inline-flex;align-items:center;justify-content:center;border-radius:50%;vertical-align:-0.1rem;">C</span>
                            <span class="milestone-badge">🏆 Milestone!</span>
                        </div>
                    @endif
                    <div class="reward-date">{{ $reward->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        @empty
            <div class="reward-empty">
                <span class="reward-empty-icon">📚</span>
                <strong>Belum ada reward.</strong>
                <p style="margin-top:0.5rem; font-size:0.85rem;">Mulai membaca chapter dan tandai selesai untuk mengumpulkan EXP & koin!</p>
                <a href="{{ route('novels.index') }}" class="btn btn-primary" style="margin-top:1rem;">Mulai Membaca</a>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($rewards->hasPages())
        <div style="margin-top: 1rem;">
            {{ $rewards->links() }}
        </div>
    @endif

</div>
@endsection
