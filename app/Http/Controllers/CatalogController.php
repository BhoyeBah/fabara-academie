<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $domain = (string) $request->query('domaine', '');

        $categories = Category::withCount(['courses' => fn ($c) => $c->published()])
            ->orderBy('position')->get()->where('courses_count', '>', 0);

        $courses = Course::published()->with('category')
            ->when($domain !== '', fn ($c) => $c->whereHas('category', fn ($k) => $k->where('slug', $domain)))
            ->when($q !== '', fn ($c) => $c->where(fn ($w) => $w
                ->where('title', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")
                ->orWhere('code', 'like', "%{$q}%")))
            ->latest()->get();

        return view('catalog.index', [
            'categories' => $categories,
            'courses' => $courses,
            'total' => Course::published()->count(),
            'q' => $q,
            'domain' => $domain,
            'cart' => session('cart', []),
        ]);
    }

    public function show(Course $course): View
    {
        abort_unless($course->is_published, 404);

        return view('catalog.show', [
            'course' => $course->load('category'),
            'inCart' => in_array($course->id, session('cart', [])),
            'owned' => auth()->user()?->owns($course) ?? false,
        ]);
    }
}
