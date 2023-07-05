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

        $authors = Author::select('authors.id', 'authors.slug', 'author_translations.locale', 'author_translations.name', 'authors.publish')
            ->join('author_translations', 'author_translations.author_id', '=', 'authors.id')
            ->where('author_translations.locale', '=', LaravelLocalization::getCurrentLocale())
            ->where('authors.publish', '=', 1)
            ->get();

        $categories = Category::select('categories.id', 'categories.slug', 'category_translations.locale', 'category_translations.name', 'categories.publish')
            ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
            ->where('category_translations.locale', '=', LaravelLocalization::getCurrentLocale())
            ->where('categories.publish', '=', 1)
            ->get();

        return view('admin.news.news.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $news = new News();
        $news->slug = $request->slug;
        $news->publish = ($request->publish == 'on') ? 1 : 0;
        $news->publish_date = $request->publish_date;
        $news->save();


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

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local):
            $image_name[$localeCode] = Str::random(20) . '.' . $request->image[$localeCode]->getClientOriginalExtension();
            $image_path[$localeCode] = $year . '/' . $month . '/' . $image_name[$localeCode];
            Storage::putFileAs($path, $request->image[$localeCode], $image_name[$localeCode]);
        endforeach;


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

            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local):
                $thumb_image_path[$localeCode] = $year . '/' . $month . '/thumb/' . $folder . '/' . $image_name[$localeCode];
                $thumbnail_data[$localeCode][$folder] = $thumb_image_path[$localeCode];

                $thumbnail_image_path[$localeCode] = $thumbnai_path . '/' . $image_name[$localeCode];

                Image::make(storage_path('app/' . $path . '/' . $image_name[$localeCode]))
                    ->fit($size['width'], $size['height'])
                    ->save(storage_path('app/' . $thumbnail_image_path[$localeCode]));
            endforeach;

        endforeach;


        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local):

            $translation[$localeCode] = new NewsTranslation([
                'locale' => $localeCode,
                'title' => $request->title[$localeCode] ?? null,
                'intro' => $request->intro[$localeCode] ?? null,
                'text' => $request->text[$localeCode] ?? null,
                'tag' => $request->tag[$localeCode] ?? null,
                'image' => $request->image[$localeCode] ? $image_path[$localeCode] : null ,
                'thumb_image' => $request->image[$localeCode] ? serialize($thumbnail_data[$localeCode]) : null ,
            ]);

            $news->translations()->save($translation[$localeCode]);

        endforeach;

        if (!empty($request->author)):
            $authors_data = array_values($request->author);
            if (!empty($authors_data)):
                $news->authors()->sync($authors_data);
                $news->authors()->updateExistingPivot($authors_data, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            endif;
        endif;

        if (!empty($request->category)):
            $category_data = array_values($request->category);
            if (!empty($category_data)):
                $news->categories()->sync($category_data);
                $news->categories()->updateExistingPivot($category_data, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            endif;
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
