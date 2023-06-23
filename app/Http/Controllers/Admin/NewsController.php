<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

//        $values = array_map(function($item) {
//            return $item->value;
//        }, json_decode($request->tags));
//        $tag_data = collect(json_decode($request->tags, true));
//        $tags = json_encode($tag_data->pluck('value')->toArray());

        
        return view('admin.news.news.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $authors = Author::select('authors.id', 'authors.slug', 'author_translations.locale', 'author_translations.name')
            ->join('author_translations', 'author_translations.author_id', '=', 'authors.id')
            ->where('author_translations.locale', '=', LaravelLocalization::getCurrentLocale())
            ->get();

        $categories = Category::select('categories.id', 'categories.slug', 'category_translations.locale', 'category_translations.name')
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
        $news->save();

        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $local) {

            $translation = new NewsTranslation([
                'locale' => $localeCode,
                'title' => ($localeCode == $locale) ? $request->title : null,
                'text' => ($localeCode == $locale) ? $request->text : null,
                'image' => ($localeCode == $locale) ? $request->image : null,
                'tag' => ($localeCode == $locale) ? $request->tags : null,
            ]);

            $news->translations()->save($translation);

        }

        $authors_data = array_values($request->author);
        if(!empty($authors_data)):
            $news->authors()->sync($authors_data);
        endif;

        $category_data = array_values($request->category);
        if(!empty($category_data)):
            $news->categories()->sync($category_data);
        endif;


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


//        $values = array_map(function($item) {
//            return $item->value;
//        }, json_decode($request->tags));
//        $tag_data = collect(json_decode($request->tags, true));
//        $tags = json_encode($tag_data->pluck('value')->toArray());

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
