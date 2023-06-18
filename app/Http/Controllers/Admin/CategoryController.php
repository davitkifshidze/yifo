<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsCategoryRequest;
use App\Models\Admin\Category;
use App\Models\Admin\CategoryTranslation;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::with('translations')
            ->select('categories.id' , 'categories.slug', 'categories.publish', 'categories.created_at', 'categories.updated_at', 'category_translations.locale', 'category_translations.name',  'category_translations.description')
            ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
            ->where('category_translations.locale', '=', LaravelLocalization::getCurrentLocale())
            ->get();

        return view('admin.news.category.index', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $category = new Category();

        $category->slug = $request->slug;
        $category->publish = ($request->publish == 'on') ? 1 : 0;
        $category->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local) {
            $translation = new CategoryTranslation([
                'locale' => $localeCode,
                'name' => $request->input('name.'.$localeCode),
                'description' => $request->input('description.'.$localeCode),
            ]);
            $category->translations()->save($translation);
        }

        return response()->json(['success' => 'create_success']);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $category_id = $id;
        $categories = [];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local) {
            $categories[$localeCode] = Category::select('categories.id', 'categories.slug', 'categories.publish')
                ->addSelect('category_translations.locale', 'category_translations.name', 'category_translations.description')
                ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
                ->where('category_translations.locale', '=', $localeCode)
                ->where('categories.id', '=', $category_id)
                ->get();
        }

        return response()->json($categories);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $category = Category::find($id);

        $category->update([
            'slug' => $request->slug,
            'publish' => $request->publish == 'on' ? 1 : 0,
        ]);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local) {
            CategoryTranslation::where('category_id', $id)
                ->where('locale', $localeCode)
                ->update([
                    'name' => $request->name[$localeCode],
                    'description' => $request->description[$localeCode],
                ]);
        }

        return response()->json(['success' => 'true']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true]);
    }
}
