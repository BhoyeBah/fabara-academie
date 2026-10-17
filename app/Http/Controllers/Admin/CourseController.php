<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $courses = Course::with('category')
            ->when($q !== '', fn ($c) => $c->where(fn ($w) => $w->where('title', 'like', "%{$q}%")->orWhere('code', 'like', "%{$q}%")))
            ->orderBy('code')->get();

        return view('admin.courses.index', ['courses' => $courses, 'q' => $q]);
    }

    public function create(): View
    {
        return view('admin.courses.form', ['course' => new Course(['level' => 'Débutant', 'is_published' => true]), 'categories' => Category::orderBy('position')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $course = Course::create($this->validated($request));

        return redirect()->route('admin.courses.index')->with('status', "Formation {$course->code} ajoutée.");
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.form', ['course' => $course, 'categories' => Category::orderBy('position')->get()]);
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $course->update($this->validated($request, $course));

        return redirect()->route('admin.courses.index')->with('status', "Formation {$course->code} enregistrée.");
    }

    public function destroy(Course $course): RedirectResponse
    {
        $code = $course->code;
        $course->delete(); // les commandes passées gardent le code et le titre

        return redirect()->route('admin.courses.index')->with('status', "Formation {$code} supprimée.");
    }

    private function validated(Request $request, ?Course $course = null): array
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9-]+$/', Rule::unique('courses')->ignore($course?->id)],
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:190'],
            'description' => ['required', 'string', 'max:500'],
            'level' => ['required', Rule::in(Course::LEVELS)],
            'hours' => ['nullable', 'integer', 'min:0', 'max:1000'],
            'lessons' => ['nullable', 'integer', 'min:0', 'max:5000'],
            'price' => ['required', 'integer', 'min:0'],
            'program' => ['nullable', 'string', 'max:5000'],
            'drive_url' => ['nullable', 'url:https', 'regex:#^https://(drive|docs)\.google\.com/#', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
        ], ['drive_url.regex' => 'Le lien doit être un lien Google Drive (https://drive.google.com/...).']);

        $data['code'] = strtoupper($data['code']);
        $data['slug'] = Str::slug($data['code'].' '.$data['title']);
        $data['hours'] = (int) ($data['hours'] ?? 0);
        $data['lessons'] = (int) ($data['lessons'] ?? 0);
        $data['program'] = collect(preg_split('/\R/', (string) ($data['program'] ?? '')))->map(fn ($l) => trim($l))->filter()->values()->all();
        $data['is_published'] = $request->boolean('is_published');
        $data['drive_url'] = $data['drive_url'] ?? null;

        return $data;
    }
}
