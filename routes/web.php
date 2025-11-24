<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ScreeningWizard;
use App\Livewire\Profile;
use App\Livewire\ScreeningHistory;
use App\Livewire\LocationDropdowns;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\ScreeningResult;

Use App\Livewire\Admin\ScreeningResult\Index as ScreeningResultIndex;
Use App\Livewire\Admin\ScreeningResult\View as ScreeningResultView;

use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Livewire\Admin\Users\Create as UsersCreate;
use App\Livewire\Admin\Users\Edit as UsersEdit;

use App\Livewire\Admin\Instruments\Index as InstrumentIndex;
use App\Livewire\Admin\Instruments\Create as InstrumentCreate;
use App\Livewire\Admin\Instruments\Edit as InstrumentEdit;

use App\Livewire\Admin\Questions\Index as QuestionsIndex;
use App\Livewire\Admin\Questions\Create as QuestionsCreate;
use App\Livewire\Admin\Questions\Edit as QuestionsEdit;

use App\Livewire\Admin\Recommendations\Index as RecommendationsIndex;
use App\Livewire\Admin\Recommendations\Create as RecommendationsCreate;
use App\Livewire\Admin\Recommendations\Edit as RecommendationsEdit;

use App\Livewire\Admin\Report;
use App\Livewire\Screening\StepResult;

// Rute untuk Tamu
Route::get('/', function () {
    return view('welcome');
})->middleware('redirect.admin');

// Rute untuk Pengguna Masyarakat (User)
Route::middleware(['auth', 'verified', 'redirect.admin'])->group(function () {
    Route::get('/screening', ScreeningWizard::class)->name('screening.wizard'); 

    Route::get('/profile', Profile::class)->name('profile');

    Route::get('/history', ScreeningHistory::class)->name('history'); 
    
    Route::get('/result/{resultId}', StepResult::class)->name('screening.result'); 
});

// Rute KHUSUS untuk Admin
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard'); 

    Route::get('/screening-result', ScreeningResultIndex::class)->name('screeningresult'); 
    Route::get('/screening-result/{id}', ScreeningResultView::class)->name('screeningresultshow'); 

    Route::get('/users', UsersIndex::class)->name('adminusers');
    Route::get('/usersnew', UsersCreate::class)->name('userscreate');
    Route::get('/users/{id}/edit', UsersEdit::class)->name('usersedit');

    Route::get('/instrumentindex', InstrumentIndex::class)->name('instrumentindex');
    Route::get('/instrumentnew', InstrumentCreate::class)->name('instrumentcreate');
    Route::get('/instrument/{id}/edit', InstrumentEdit::class)->name('instrumentedit');
    
    Route::get('/questionsindex', QuestionsIndex::class)->name('questionsindex');
    Route::get('/questionsnew', QuestionsCreate::class)->name('questionscreate');
    Route::get('/questions/{id}/edit', QuestionsEdit::class)->name('questionsedit');
    
    Route::get('/recommendationsindex', RecommendationsIndex::class)->name('recommendationsindex');
    Route::get('/recommendationsnew', RecommendationsCreate::class)->name('recommendationscreate');
    Route::get('/recommendations/{id}/edit', RecommendationsEdit::class)->name('recommendationsedit');

    Route::get('/report', Report::class)->name('admin.report');
});

// Route::get('/tes-dropdown', LocationDropdowns::class)->name('location.dropdowns');

require __DIR__.'/auth.php';
