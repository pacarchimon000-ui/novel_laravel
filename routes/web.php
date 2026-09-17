<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NovelController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DocumentationController;

// ==================== PUBLIC ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/novels', [NovelController::class, 'index'])->name('novels.index');
Route::get('/novels/{novel}', [NovelController::class, 'show'])->name('novels.show');
Route::get('/novels/{novel}/chapters/{chapter}', [ChapterController::class, 'show'])->name('chapters.show');
Route::get('/novels/{novel}/chapters/{chapter}/pdf', [ChapterController::class, 'downloadPdf'])->name('chapters.pdf');
Route::get('/documentation/pdf', [DocumentationController::class, 'pdf'])->name('documentation.pdf');

// ==================== AUTH (user) ====================
Route::middleware(['auth'])->group(function () {
    // Rating & Review
    Route::post('/novels/{novel}/ratings', [\App\Http\Controllers\RatingController::class, 'store'])->name('ratings.store');
    Route::post('/novels/{novel}/chapters/{chapter}/unlock', [ChapterController::class, 'unlock'])->name('chapters.unlock');
    Route::post('/novels/{novel}/chapters/{chapter}/complete', [ChapterController::class, 'complete'])->name('chapters.complete');

    // Bookmark
    Route::post('/novels/{novel}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');

    // Coins
    Route::get('/coins', [\App\Http\Controllers\CoinController::class, 'index'])->name('coins.index');

    // Like
    Route::post('/novels/{novel}/like', [LikeController::class, 'toggle'])->name('like.toggle');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/request-writer', [\App\Http\Controllers\ProfileController::class, 'requestWriter'])->name('profile.request-writer');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Reports
    Route::post('/comments/{comment}/report', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');

    // Comments
    Route::post('/chapters/{chapter}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// ==================== WRITER ====================
Route::middleware(['auth', 'writer'])->prefix('writer')->name('writer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\WriterController::class, 'dashboard'])->name('dashboard');

    Route::get('/novels', [\App\Http\Controllers\WriterController::class, 'novelsIndex'])->name('novels.index');
    Route::get('/novels/create', [\App\Http\Controllers\WriterController::class, 'novelsCreate'])->name('novels.create');
    Route::post('/novels', [\App\Http\Controllers\WriterController::class, 'novelsStore'])->name('novels.store');
    Route::get('/novels/{novel}/edit', [\App\Http\Controllers\WriterController::class, 'novelsEdit'])->name('novels.edit');
    Route::put('/novels/{novel}', [\App\Http\Controllers\WriterController::class, 'novelsUpdate'])->name('novels.update');
    Route::delete('/novels/{novel}', [\App\Http\Controllers\WriterController::class, 'novelsDestroy'])->name('novels.destroy');

    Route::get('/novels/{novel}/chapters/create', [\App\Http\Controllers\WriterController::class, 'chaptersCreate'])->name('chapters.create');
    Route::post('/novels/{novel}/chapters', [\App\Http\Controllers\WriterController::class, 'chaptersStore'])->name('chapters.store');
    Route::get('/novels/{novel}/chapters/{chapter}/edit', [\App\Http\Controllers\WriterController::class, 'chaptersEdit'])->name('chapters.edit');
    Route::put('/novels/{novel}/chapters/{chapter}', [\App\Http\Controllers\WriterController::class, 'chaptersUpdate'])->name('chapters.update');
    Route::delete('/novels/{novel}/chapters/{chapter}', [\App\Http\Controllers\WriterController::class, 'chaptersDestroy'])->name('chapters.destroy');
});

// ==================== ADMIN ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Reports Management
    Route::get('/reports', [AdminController::class, 'reportsIndex'])->name('reports.index');
    Route::post('/reports/{report}/resolve', [AdminController::class, 'reportsResolve'])->name('reports.resolve');
    Route::post('/reports/{report}/dismiss', [AdminController::class, 'reportsDismiss'])->name('reports.dismiss');

    // Novels
    Route::get('/novels', [AdminController::class, 'novelsIndex'])->name('novels.index');
    Route::get('/novels/create', [AdminController::class, 'novelsCreate'])->name('novels.create');
    Route::post('/novels', [AdminController::class, 'novelsStore'])->name('novels.store');
    Route::get('/novels/{novel}', [AdminController::class, 'novelsShow'])->name('novels.show');
    Route::get('/novels/{novel}/edit', [AdminController::class, 'novelsEdit'])->name('novels.edit');
    Route::put('/novels/{novel}', [AdminController::class, 'novelsUpdate'])->name('novels.update');
    Route::delete('/novels/{novel}', [AdminController::class, 'novelsDestroy'])->name('novels.destroy');

    // Chapters
    Route::get('/novels/{novel}/chapters/create', [AdminController::class, 'chaptersCreate'])->name('chapters.create');
    Route::post('/novels/{novel}/chapters', [AdminController::class, 'chaptersStore'])->name('chapters.store');
    Route::get('/novels/{novel}/chapters/{chapter}/edit', [AdminController::class, 'chaptersEdit'])->name('chapters.edit');
    Route::put('/novels/{novel}/chapters/{chapter}', [AdminController::class, 'chaptersUpdate'])->name('chapters.update');
    Route::delete('/novels/{novel}/chapters/{chapter}', [AdminController::class, 'chaptersDestroy'])->name('chapters.destroy');

    // Users
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/pending-writers', [AdminController::class, 'writerRequestsIndex'])->name('users.pending-writers');
    Route::post('/users/{user}/toggle-role', [AdminController::class, 'usersToggleRole'])->name('users.toggle-role');
    Route::post('/users/{user}/approve-writer', [AdminController::class, 'approveWriter'])->name('users.approve-writer');
    Route::post('/users/{user}/reject-writer', [AdminController::class, 'rejectWriter'])->name('users.reject-writer');
    Route::delete('/users/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
});

// Redirect dashboard sesuai role user
Route::middleware(['auth'])->get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->isWriter()) {
        return redirect()->route('writer.dashboard');
    }

    return redirect()->route('home');
})->name('dashboard');

require __DIR__ . '/auth.php';

