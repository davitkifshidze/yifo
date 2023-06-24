<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use App\Models\NewsTranslation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
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

        return view('admin.news.news.create', compact('authors', 'categories'));
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


        /**
        * Image Upload
        */
        $current_date = Carbon::now();
        $month = $current_date->format('m');
        $year = $current_date->format('Y');

        $path = 'public/uploads/news/images/' . $year . '/' . $month;
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0777, true);
        }

        $image_name = Str::random(20) . '.' . $request->image->getClientOriginalExtension();
        $image_path = $year . '/' . $month . '/' . $image_name;

        Storage::putFileAs($path, $request->image, $image_name);

        /**
         * Create Thumbnail
         */

        $thumbnail_size_list = [
            'small'=>[
                'width'=>'100',
                'height'=>'100',
            ],
            'medium'=>[
                'width'=>'400',
                'height'=>'400',
            ],
            'high'=>[
                'width'=>'600',
                'height'=>'600',
            ]
        ];


        $thumbnail_data = [];

        foreach ($thumbnail_size_list as $folder => $size):

            $thumbnai_path = $path . '/thumb/' . $folder;
            if (!Storage::exists($thumbnai_path)) {
                Storage::makeDirectory($thumbnai_path, 0777, true);
            }

            $thumb_image_path = $year . '/' . $month . '/thumb/' . $folder . '/' . $image_name;

            $thumbnail_data[$folder] = $thumb_image_path;

            $thumbnail_image_path = $thumbnai_path . '/' . $image_name;
            Image::make(storage_path('app/' . $path . '/' . $image_name))
                ->fit($size['width'], $size['height'])
                ->save(storage_path('app/' . $thumbnail_image_path));

        endforeach;

        $thumbnail_serialize = serialize($thumbnail_data);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local) {

            $translation = new NewsTranslation([
                'locale' => $localeCode,
                'title' => ($localeCode == $locale) ? $request->title : null,
                'text' => ($localeCode == $locale) ? $request->text : null,
                'image' => ($localeCode == $locale) ? $image_path : null,
                'thumb_image' => ($localeCode == $locale) ? $thumbnail_serialize : null,
                'tag' => ($localeCode == $locale) ? $request->tags : null,
            ]);

            $news->translations()->save($translation);

        }

        $authors_data = array_values($request->author);
        if (!empty($authors_data)):
            $news->authors()->sync($authors_data);
            $news->authors()->updateExistingPivot($authors_data, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        endif;

        $category_data = array_values($request->category);
        if (!empty($category_data)):
            $news->categories()->sync($category_data);
            $news->categories()->updateExistingPivot($category_data, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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
