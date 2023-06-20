<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsCategoryRequest;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::select('categories.id' , 'categories.slug', 'categories.publish', 'categories.created_at', 'categories.updated_at', 'category_translations.locale', 'category_translations.name',  'category_translations.description')
            ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
            ->where('category_translations.locale', '=', LaravelLocalization::getCurrentLocale())
            ->get();

        return view('admin.news.category.index', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsCategoryRequest $request)
    {
        $locale = LaravelLocalization::getCurrentLocale();

        $category = new Category();
        $category->slug = $request->slug;
        $category->publish = ($request->publish == 'on') ? 1 : 0;
        $category->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local) {
            $translation = new CategoryTranslation([
                'locale' => $localeCode,
                'name' => ($localeCode == $locale) ? $request->input('name') : null,
                'description' => ($localeCode == $locale) ? $request->input('description') : null,

            ]);
            $category->translations()->save($translation);
        }

        return redirect(route('category_list'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $locale = LaravelLocalization::getCurrentLocale();

        $category = Category::select('categories.id' ,'categories.slug' ,'categories.id' ,'categories.publish' )
            ->addSelect('category_translations.locale', 'category_translations.name', 'category_translations.description')
            ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
            ->where('category_translations.locale', '=', $locale)
            ->where('categories.id', '=', $id)
            ->first();

        return view('admin.news.category.edit', compact('category'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsCategoryRequest $request, string $id)
    {

        $category = Category::find($id);

        $category->update([
            'slug' => $request->slug,
            'publish' => $request->publish == 'on' ? 1 : 0,
        ]);

        $locale = LaravelLocalization::getCurrentLocale();

        CategoryTranslation::where('category_id', $id)
            ->where('locale', $locale)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

        return redirect()->route('edit_category',$id)->with( 'update', 'success' );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $category = Category::findOrFail($id);
        $category->translations()->forceDelete();
        $category->forceDelete();

        return response()->json(['success' => true]);
    }
}
