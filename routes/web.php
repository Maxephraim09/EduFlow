<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\OnlineCourseController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    
    // Student Management Routes
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/', [StudentController::class, 'store'])->name('store');
        Route::get('/{student}', [StudentController::class, 'show'])->name('show');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-import', [StudentController::class, 'bulkImport'])->name('bulk.import');
        Route::get('/export', [StudentController::class, 'export'])->name('export');
    });
    
    // Teacher Management Routes
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/', [TeacherController::class, 'store'])->name('store');
        Route::get('/{teacher}', [TeacherController::class, 'show'])->name('show');
        Route::get('/{teacher}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
        Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
        Route::get('/export', [TeacherController::class, 'export'])->name('export');
    });
    
    // Parent Management Routes
    Route::prefix('parents')->name('parents.')->group(function () {
        Route::get('/', [ParentController::class, 'index'])->name('index');
        Route::get('/create', [ParentController::class, 'create'])->name('create');
        Route::post('/', [ParentController::class, 'store'])->name('store');
        Route::get('/{parent}', [ParentController::class, 'show'])->name('show');
        Route::get('/{parent}/edit', [ParentController::class, 'edit'])->name('edit');
        Route::put('/{parent}', [ParentController::class, 'update'])->name('update');
        Route::delete('/{parent}', [ParentController::class, 'destroy'])->name('destroy');
    });
    
    // Class Management Routes
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClassesController::class, 'index'])->name('index');
        Route::get('/create', [ClassesController::class, 'create'])->name('create');
        Route::post('/', [ClassesController::class, 'store'])->name('store');
        Route::get('/{class}', [ClassesController::class, 'show'])->name('show');
        Route::get('/{class}/edit', [ClassesController::class, 'edit'])->name('edit');
        Route::put('/{class}', [ClassesController::class, 'update'])->name('update');
        Route::delete('/{class}', [ClassesController::class, 'destroy'])->name('destroy');
        Route::get('/{class}/students', [ClassesController::class, 'students'])->name('students');
        Route::get('/{class}/timetable', [ClassesController::class, 'timetable'])->name('timetable');
    });
    
    // Section Management Routes
    Route::prefix('sections')->name('sections.')->group(function () {
        Route::get('/', [SectionController::class, 'index'])->name('index');
        Route::get('/create', [SectionController::class, 'create'])->name('create');
        Route::post('/', [SectionController::class, 'store'])->name('store');
        Route::get('/{section}', [SectionController::class, 'show'])->name('show');
        Route::get('/{section}/edit', [SectionController::class, 'edit'])->name('edit');
        Route::put('/{section}', [SectionController::class, 'update'])->name('update');
        Route::delete('/{section}', [SectionController::class, 'destroy'])->name('destroy');
    });
    
    // Subject Management Routes
    Route::prefix('subjects')->name('subjects.')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('index');
        Route::get('/create', [SubjectController::class, 'create'])->name('create');
        Route::post('/', [SubjectController::class, 'store'])->name('store');
        Route::get('/{subject}', [SubjectController::class, 'show'])->name('show');
        Route::get('/{subject}/edit', [SubjectController::class, 'edit'])->name('edit');
        Route::put('/{subject}', [SubjectController::class, 'update'])->name('update');
        Route::delete('/{subject}', [SubjectController::class, 'destroy'])->name('destroy');
        Route::post('/{subject}/assign-teacher', [SubjectController::class, 'assignTeacher'])->name('assign-teacher');
    });
    
    // Attendance Routes
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/mark', [AttendanceController::class, 'mark'])->name('mark');
        Route::post('/store', [AttendanceController::class, 'store'])->name('store');
        Route::get('/report', [AttendanceController::class, 'report'])->name('report');
        Route::get('/export', [AttendanceController::class, 'export'])->name('export');
        Route::post('/bulk-mark', [AttendanceController::class, 'bulkMark'])->name('bulk.mark');
    });
    
    // Exam Routes
    Route::prefix('exams')->name('exams.')->group(function () {
        Route::get('/', [ExamController::class, 'index'])->name('index');
        Route::get('/create', [ExamController::class, 'create'])->name('create');
        Route::post('/', [ExamController::class, 'store'])->name('store');
        Route::get('/{exam}', [ExamController::class, 'show'])->name('show');
        Route::get('/{exam}/edit', [ExamController::class, 'edit'])->name('edit');
        Route::put('/{exam}', [ExamController::class, 'update'])->name('update');
        Route::delete('/{exam}', [ExamController::class, 'destroy'])->name('destroy');
        Route::post('/{exam}/publish', [ExamController::class, 'publish'])->name('publish');
        Route::get('/{exam}/results', [ExamController::class, 'results'])->name('results');
    });
    
    // Results Routes
    Route::prefix('results')->name('results.')->group(function () {
        Route::get('/', [ResultController::class, 'index'])->name('index');
        Route::get('/entry', [ResultController::class, 'entry'])->name('entry');
        Route::post('/store', [ResultController::class, 'store'])->name('store');
        Route::get('/student/{student}', [ResultController::class, 'studentResults'])->name('student');
        Route::get('/class/{class}/term/{term}', [ResultController::class, 'classResults'])->name('class');
        Route::post('/bulk-store', [ResultController::class, 'bulkStore'])->name('bulk.store');
        Route::get('/export/{class}/{term}', [ResultController::class, 'export'])->name('export');
        Route::get('/report-card/{student}/{term}', [ResultController::class, 'reportCard'])->name('report-card');
        Route::post('/report-card/bulk', [ResultController::class, 'bulkReportCard'])->name('report-card.bulk');
    });
    
    // Fee Management Routes
    Route::prefix('fees')->name('fees.')->group(function () {
        Route::get('/', [FeeController::class, 'index'])->name('index');
        Route::get('/structures', [FeeController::class, 'structures'])->name('structures');
        Route::post('/structures', [FeeController::class, 'storeStructure'])->name('structures.store');
        Route::get('/structures/{structure}/edit', [FeeController::class, 'editStructure'])->name('structures.edit');
        Route::put('/structures/{structure}', [FeeController::class, 'updateStructure'])->name('structures.update');
        Route::delete('/structures/{structure}', [FeeController::class, 'destroyStructure'])->name('structures.destroy');
        Route::get('/payments', [FeeController::class, 'payments'])->name('payments');
        Route::get('/payments/create', [FeeController::class, 'createPayment'])->name('payments.create');
        Route::post('/payments', [FeeController::class, 'storePayment'])->name('payments.store');
        Route::get('/payments/{payment}', [FeeController::class, 'showPayment'])->name('payments.show');
        Route::get('/payments/{payment}/receipt', [FeeController::class, 'receipt'])->name('payments.receipt');
        Route::post('/payments/{payment}/send-receipt', [FeeController::class, 'sendReceipt'])->name('payments.send-receipt');
        Route::get('/invoices', [FeeController::class, 'invoices'])->name('invoices');
        Route::post('/invoices/generate', [FeeController::class, 'generateInvoice'])->name('invoices.generate');
        Route::get('/reports', [FeeController::class, 'reports'])->name('reports');
        Route::get('/reports/export', [FeeController::class, 'exportReport'])->name('reports.export');
        Route::get('/defaulters', [FeeController::class, 'defaulters'])->name('defaulters');
        Route::post('/send-reminders', [FeeController::class, 'sendReminders'])->name('send-reminders');
    });
    
    // Events Routes
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/calendar', [EventController::class, 'calendar'])->name('calendar');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
        Route::post('/{event}/register', [EventController::class, 'register'])->name('register');
        Route::post('/{event}/cancel', [EventController::class, 'cancel'])->name('cancel');
        Route::get('/export', [EventController::class, 'export'])->name('export');
    });
    
    // Library Management Routes
    Route::prefix('library')->name('library.')->group(function () {
        Route::get('/', [LibraryController::class, 'index'])->name('index');
        Route::get('/books', [LibraryController::class, 'books'])->name('books');
        Route::get('/books/create', [LibraryController::class, 'createBook'])->name('books.create');
        Route::post('/books', [LibraryController::class, 'storeBook'])->name('books.store');
        Route::get('/books/{book}', [LibraryController::class, 'showBook'])->name('books.show');
        Route::get('/books/{book}/edit', [LibraryController::class, 'editBook'])->name('books.edit');
        Route::put('/books/{book}', [LibraryController::class, 'updateBook'])->name('books.update');
        Route::delete('/books/{book}', [LibraryController::class, 'destroyBook'])->name('books.destroy');
        Route::get('/issues', [LibraryController::class, 'issues'])->name('issues');
        Route::get('/issues/create', [LibraryController::class, 'createIssue'])->name('issues.create');
        Route::post('/issues', [LibraryController::class, 'storeIssue'])->name('issues.store');
        Route::post('/issues/{issue}/return', [LibraryController::class, 'returnBook'])->name('issues.return');
        Route::get('/categories', [LibraryController::class, 'categories'])->name('categories');
        Route::post('/categories', [LibraryController::class, 'storeCategory'])->name('categories.store');
        Route::get('/search', [LibraryController::class, 'search'])->name('search');
        Route::get('/reports', [LibraryController::class, 'reports'])->name('reports');
    });
    
    // Transport Management Routes
    Route::prefix('transport')->name('transport.')->group(function () {
        Route::get('/', [TransportController::class, 'index'])->name('index');
        Route::get('/routes', [TransportController::class, 'routes'])->name('routes');
        Route::get('/routes/create', [TransportController::class, 'createRoute'])->name('routes.create');
        Route::post('/routes', [TransportController::class, 'storeRoute'])->name('routes.store');
        Route::get('/routes/{route}', [TransportController::class, 'showRoute'])->name('routes.show');
        Route::get('/routes/{route}/edit', [TransportController::class, 'editRoute'])->name('routes.edit');
        Route::put('/routes/{route}', [TransportController::class, 'updateRoute'])->name('routes.update');
        Route::delete('/routes/{route}', [TransportController::class, 'destroyRoute'])->name('routes.destroy');
        Route::get('/buses', [TransportController::class, 'buses'])->name('buses');
        Route::get('/buses/create', [TransportController::class, 'createBus'])->name('buses.create');
        Route::post('/buses', [TransportController::class, 'storeBus'])->name('buses.store');
        Route::get('/buses/{bus}', [TransportController::class, 'showBus'])->name('buses.show');
        Route::get('/buses/{bus}/edit', [TransportController::class, 'editBus'])->name('buses.edit');
        Route::put('/buses/{bus}', [TransportController::class, 'updateBus'])->name('buses.update');
        Route::delete('/buses/{bus}', [TransportController::class, 'destroyBus'])->name('buses.destroy');
        Route::get('/assignments', [TransportController::class, 'assignments'])->name('assignments');
        Route::post('/assignments', [TransportController::class, 'storeAssignment'])->name('assignments.store');
        Route::delete('/assignments/{assignment}', [TransportController::class, 'destroyAssignment'])->name('assignments.destroy');
        Route::get('/reports', [TransportController::class, 'reports'])->name('reports');
    });
    
    // Hostel Management Routes
    Route::prefix('hostel')->name('hostel.')->group(function () {
        Route::get('/', [HostelController::class, 'index'])->name('index');
        Route::get('/hostels', [HostelController::class, 'hostels'])->name('hostels');
        Route::get('/hostels/create', [HostelController::class, 'createHostel'])->name('hostels.create');
        Route::post('/hostels', [HostelController::class, 'storeHostel'])->name('hostels.store');
        Route::get('/hostels/{hostel}', [HostelController::class, 'showHostel'])->name('hostels.show');
        Route::get('/hostels/{hostel}/edit', [HostelController::class, 'editHostel'])->name('hostels.edit');
        Route::put('/hostels/{hostel}', [HostelController::class, 'updateHostel'])->name('hostels.update');
        Route::delete('/hostels/{hostel}', [HostelController::class, 'destroyHostel'])->name('hostels.destroy');
        Route::get('/rooms', [HostelController::class, 'rooms'])->name('rooms');
        Route::get('/rooms/create', [HostelController::class, 'createRoom'])->name('rooms.create');
        Route::post('/rooms', [HostelController::class, 'storeRoom'])->name('rooms.store');
        Route::get('/rooms/{room}', [HostelController::class, 'showRoom'])->name('rooms.show');
        Route::get('/rooms/{room}/edit', [HostelController::class, 'editRoom'])->name('rooms.edit');
        Route::put('/rooms/{room}', [HostelController::class, 'updateRoom'])->name('rooms.update');
        Route::delete('/rooms/{room}', [HostelController::class, 'destroyRoom'])->name('rooms.destroy');
        Route::get('/allocations', [HostelController::class, 'allocations'])->name('allocations');
        Route::post('/allocations', [HostelController::class, 'storeAllocation'])->name('allocations.store');
        Route::post('/allocations/{allocation}/checkout', [HostelController::class, 'checkout'])->name('allocations.checkout');
        Route::get('/attendance', [HostelController::class, 'attendance'])->name('attendance');
        Route::post('/attendance', [HostelController::class, 'storeAttendance'])->name('attendance.store');
    });
    
    // Timetable Routes
    Route::prefix('timetable')->name('timetable.')->group(function () {
        Route::get('/', [TimetableController::class, 'index'])->name('index');
        Route::get('/create', [TimetableController::class, 'create'])->name('create');
        Route::post('/', [TimetableController::class, 'store'])->name('store');
        Route::get('/{timetable}/edit', [TimetableController::class, 'edit'])->name('edit');
        Route::put('/{timetable}', [TimetableController::class, 'update'])->name('update');
        Route::delete('/{timetable}', [TimetableController::class, 'destroy'])->name('destroy');
        Route::get('/class/{class}', [TimetableController::class, 'classTimetable'])->name('class');
        Route::get('/teacher/{teacher}', [TimetableController::class, 'teacherTimetable'])->name('teacher');
        Route::get('/export/{class}', [TimetableController::class, 'export'])->name('export');
        Route::post('/copy', [TimetableController::class, 'copy'])->name('copy');
    });
    
    // Announcement Routes
    Route::prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
        Route::post('/', [AnnouncementController::class, 'store'])->name('store');
        Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('show');
        Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
        Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
        Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
        Route::post('/{announcement}/publish', [AnnouncementController::class, 'publish'])->name('publish');
    });
    
    // Inventory Routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/items', [InventoryController::class, 'items'])->name('items');
        Route::get('/items/create', [InventoryController::class, 'createItem'])->name('items.create');
        Route::post('/items', [InventoryController::class, 'storeItem'])->name('items.store');
        Route::get('/items/{item}', [InventoryController::class, 'showItem'])->name('items.show');
        Route::get('/items/{item}/edit', [InventoryController::class, 'editItem'])->name('items.edit');
        Route::put('/items/{item}', [InventoryController::class, 'updateItem'])->name('items.update');
        Route::delete('/items/{item}', [InventoryController::class, 'destroyItem'])->name('items.destroy');
        Route::get('/categories', [InventoryController::class, 'categories'])->name('categories');
        Route::post('/categories', [InventoryController::class, 'storeCategory'])->name('categories.store');
        Route::get('/transactions', [InventoryController::class, 'transactions'])->name('transactions');
        Route::post('/transactions', [InventoryController::class, 'storeTransaction'])->name('transactions.store');
        Route::get('/reports', [InventoryController::class, 'reports'])->name('reports');
        Route::get('/reports/low-stock', [InventoryController::class, 'lowStock'])->name('reports.low-stock');
    });
    
    // Payroll Routes
    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('index');
        Route::get('/create', [PayrollController::class, 'create'])->name('create');
        Route::post('/', [PayrollController::class, 'store'])->name('store');
        Route::get('/{payroll}', [PayrollController::class, 'show'])->name('show');
        Route::get('/{payroll}/payslip', [PayrollController::class, 'payslip'])->name('payslip');
        Route::post('/{payroll}/process', [PayrollController::class, 'process'])->name('process');
        Route::post('/{payroll}/pay', [PayrollController::class, 'markAsPaid'])->name('pay');
        Route::get('/salary-structure', [PayrollController::class, 'salaryStructure'])->name('structure');
        Route::post('/salary-structure', [PayrollController::class, 'storeSalaryStructure'])->name('structure.store');
        Route::get('/reports', [PayrollController::class, 'reports'])->name('reports');
    });
    
    // Online Learning Routes
    Route::prefix('online-learning')->name('online-learning.')->group(function () {
        Route::get('/', [OnlineCourseController::class, 'index'])->name('index');
        Route::get('/courses', [OnlineCourseController::class, 'courses'])->name('courses');
        Route::get('/courses/create', [OnlineCourseController::class, 'createCourse'])->name('courses.create');
        Route::post('/courses', [OnlineCourseController::class, 'storeCourse'])->name('courses.store');
        Route::get('/courses/{course}', [OnlineCourseController::class, 'showCourse'])->name('courses.show');
        Route::get('/courses/{course}/edit', [OnlineCourseController::class, 'editCourse'])->name('courses.edit');
        Route::put('/courses/{course}', [OnlineCourseController::class, 'updateCourse'])->name('courses.update');
        Route::delete('/courses/{course}', [OnlineCourseController::class, 'destroyCourse'])->name('courses.destroy');
        Route::post('/courses/{course}/enroll', [OnlineCourseController::class, 'enroll'])->name('enroll');
        Route::post('/courses/{course}/unenroll', [OnlineCourseController::class, 'unenroll'])->name('unenroll');
        Route::post('/courses/{course}/progress', [OnlineCourseController::class, 'updateProgress'])->name('progress.update');
        Route::get('/certificates/{enrollment}', [OnlineCourseController::class, 'certificate'])->name('certificate');
    });
    
    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/students', [ReportController::class, 'studentReport'])->name('students');
        Route::get('/students/export', [ReportController::class, 'exportStudents'])->name('students.export');
        Route::get('/teachers', [ReportController::class, 'teacherReport'])->name('teachers');
        Route::get('/attendance', [ReportController::class, 'attendanceReport'])->name('attendance');
        Route::get('/attendance/export', [ReportController::class, 'exportAttendance'])->name('attendance.export');
        Route::get('/financial', [ReportController::class, 'financialReport'])->name('financial');
        Route::get('/financial/export', [ReportController::class, 'exportFinancial'])->name('financial.export');
        Route::get('/academic', [ReportController::class, 'academicReport'])->name('academic');
        Route::get('/academic/export', [ReportController::class, 'exportAcademic'])->name('academic.export');
        Route::get('/custom', [ReportController::class, 'customReport'])->name('custom');
        Route::post('/custom/generate', [ReportController::class, 'generateCustomReport'])->name('custom.generate');
    });
    
    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('general.update');
        Route::get('/academic', [SettingsController::class, 'academic'])->name('academic');
        Route::post('/academic', [SettingsController::class, 'updateAcademic'])->name('academic.update');
        Route::get('/payment', [SettingsController::class, 'payment'])->name('payment');
        Route::post('/payment', [SettingsController::class, 'updatePayment'])->name('payment.update');
        Route::get('/sms', [SettingsController::class, 'sms'])->name('sms');
        Route::post('/sms', [SettingsController::class, 'updateSms'])->name('sms.update');
        Route::get('/email', [SettingsController::class, 'email'])->name('email');
        Route::post('/email', [SettingsController::class, 'updateEmail'])->name('email.update');
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
        Route::post('/backup', [SettingsController::class, 'createBackup'])->name('backup.create');
        Route::get('/permissions', [SettingsController::class, 'permissions'])->name('permissions');
        Route::post('/permissions', [SettingsController::class, 'updatePermissions'])->name('permissions.update');
    });
});

// Include authentication routes
require __DIR__.'/auth.php';