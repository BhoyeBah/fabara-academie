<?php

use App\Http\Controllers\Account;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/* ---------- Site public ---------- */
Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/formation/{course}', [CatalogController::class, 'show'])->name('catalog.show');

// Ajouter une formation : un visiteur sans compte est envoyé vers l'inscription
Route::post('/panier/{course}', [CartController::class, 'add'])->name('cart.add');

Route::get('/confidentialite', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/conditions', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/suppression-compte', [PageController::class, 'deletion'])->name('pages.deletion');

/* ---------- Connexion / inscription (le seul accès, clients comme admin) ---------- */
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [Auth\LoginController::class, 'create'])->name('login');
    Route::post('/connexion', [Auth\LoginController::class, 'store'])->middleware('throttle:10,1');
    Route::get('/inscription', [Auth\RegisterController::class, 'create'])->name('register');
    Route::post('/inscription', [Auth\RegisterController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/mot-de-passe-oublie', [Auth\PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/mot-de-passe-oublie', [Auth\PasswordResetController::class, 'email'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/reinitialiser/{token}', [Auth\PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reinitialiser', [Auth\PasswordResetController::class, 'update'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/deconnexion', [Auth\LoginController::class, 'destroy'])->name('logout');
    Route::get('/conditions/accepter', [Account\TermsController::class, 'show'])->name('terms.accept');
    Route::post('/conditions/accepter', [Account\TermsController::class, 'store']);

    Route::middleware('terms')->group(function () {
        Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
        Route::delete('/panier/{course}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/commander', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/commande/{order:reference}', [CheckoutController::class, 'show'])->name('orders.show');

        Route::get('/mon-compte', [Account\DashboardController::class, 'index'])->name('account.dashboard');
        Route::get('/mon-compte/formation/{course}', [Account\DashboardController::class, 'access'])->name('account.access');
        Route::get('/mon-compte/profil', [Account\ProfileController::class, 'edit'])->name('account.profile');
        Route::put('/mon-compte/profil', [Account\ProfileController::class, 'update'])->name('account.profile.update');
        Route::put('/mon-compte/mot-de-passe', [Account\ProfileController::class, 'password'])->name('account.password');
        Route::get('/mon-compte/mes-donnees', [Account\ProfileController::class, 'export'])->name('account.export');
        Route::delete('/mon-compte', [Account\ProfileController::class, 'destroy'])->name('account.destroy');
    });
});

/* ---------- Espace admin : invisible (404) pour toute personne non admin ---------- */
Route::prefix(config('app.admin_path'))->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('formations', Admin\CourseController::class)->except('show')
        ->parameters(['formations' => 'course'])->names('courses');
    Route::get('domaines', [Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('domaines', [Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('domaines/{category}', [Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('domaines/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('commandes', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('commandes/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::post('commandes/{order}/payee', [Admin\OrderController::class, 'markPaid'])->name('orders.paid');
    Route::post('commandes/{order}/annuler', [Admin\OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('clients', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('reglages', [Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('reglages', [Admin\SettingController::class, 'update'])->name('settings.update');
    Route::get('mon-login', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('mon-login', [Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('mon-login/mot-de-passe', [Admin\ProfileController::class, 'password'])->name('profile.password');
});
