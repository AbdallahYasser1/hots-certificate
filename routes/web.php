<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController;
use App\Models\Template;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tcpdf\Fpdi;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    $template = Template::find(1);
    $filename = $template->template;
    $certificatePath = Storage::disk('public')->path($filename);
    $studentName = "عبدالله ياسر";
    $pdf = new Fpdi();
    $pdf->setSourceFile($certificatePath);
    $tplId = $pdf->importPage(1);
    $pdf->AddPage();
    $pdf->useTemplate($tplId, 0, 0, 1100, 777, true);


// Set the template as the background
//    $pdf->AddFont('beinnormal', '', 'beinnormal.php');
    $pdf->SetFont('beinnormal', 'B', 80); // 'B' for bold

    // Add the student's name
    $pdf->SetXY(40, 300); // Set the position where you want to print the name
    $pdf->Cell(0, 0, $studentName, 0, 1, 'C', 0, '', 0);

    // Save the PDF to a file
    $pdfOutput = storage_path('certificates/' . 'test' . '.pdf');
    $pdf->Output($pdfOutput, 'F');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('groups', GroupController::class);
    Route::resource('templates', TemplateController::class);
    Route::post('templates/{template}/group', [TemplateController::class, 'sendTemplateToGroup'])->name(
        'template.send'
    );
    Route::get('templates/{template}/group', [TemplateController::class, 'showSendTemplateForm'])->name(
        'template.send.form'
    );
    Route::prefix('groups/{group}')->group(function () {
        Route::resource('group_members', GroupMemberController::class);
        Route::get('/import-members', [GroupMemberController::class, 'showImportForm'])->name('members.import.form');
        Route::post('/import-members', [GroupMemberController::class, 'import'])->name('members.import');
    });
});

require __DIR__ . '/auth.php';
