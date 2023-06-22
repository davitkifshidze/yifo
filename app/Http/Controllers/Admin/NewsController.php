<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.news.news.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $authors = Author::select('authors.*', 'author_translations.*')
            ->join('author_translations', 'author_translations.author_id', '=', 'authors.id')
            ->where('author_translations.locale', '=', LaravelLocalization::getCurrentLocale())
            ->get();

        $categories = Category::select('categories.*', 'category_translations.*')
            ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
            ->where('category_translations.locale', '=', LaravelLocalization::getCurrentLocale())
            ->get();


        return view('admin.news.news.create', compact('authors','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $locale = LaravelLocalization::getCurrentLocale();

        $news = new News();
        $news->slug = $request->slug;
        $news->publish = ($request->publish == 'on') ? 1 : 0;
        $news->publish_date = $request->publish_date;
//        $news->save();

        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $locale):

            $translation = new NewsTranslation([
                'locale' => $localeCode,
                'title' => ($localeCode == $locale) ? $request->title : null,
                'text' => ($localeCode == $locale) ? $request->text : null,
                'image' => ($localeCode == $locale) ? $request->image : null,
                'tag' => ($localeCode == $locale) ? $request->tag : null,

            ]);

            dd($translation);
        
            $news->translations()->save($translation);

        endforeach;

        return redirect(route('news_list'));


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
