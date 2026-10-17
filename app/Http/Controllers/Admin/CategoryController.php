<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories', ['categories' => Category::withCount('courses')->orderBy('position')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:categories,name'],
            'color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ]);
        Category::create($data + ['slug' => $this->slug($data['name']), 'position' => (int) Category::max('position') + 1]);

        return back()->with('status', 'Domaine ajouté.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:categories,name,'.$category->id],
            'color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);
        $category->update(['name' => $data['name'], 'color' => $data['color'], 'position' => (int) ($data['position'] ?? $category->position)]);

        return back()->with('status', 'Domaine enregistré.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->courses()->exists()) {
            return back()->with('status', 'Retirez ou déplacez d\'abord les formations de ce domaine.');
        }
        $category->delete();

        return back()->with('status', 'Domaine supprimé.');
    }

    private function slug(string $name): string
    {
        $base = Str::slug($name) ?: 'domaine';
        $slug = $base;
        $i = 2;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
