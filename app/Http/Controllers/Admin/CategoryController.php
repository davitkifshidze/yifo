<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsCategoryRequest;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
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
    public function store(Request $request)
    {

        $category = new Category();
        $category->slug = $request->slug;
        $category->publish = ($request->publish == 'on') ? 1 : 0;

        /**
         * Image Upload
         */
        $current_date = Carbon::now();
        $month = $current_date->format('m');
        $year = $current_date->format('Y');

        $path = 'public/uploads/category/images/' . $year . '/' . $month;
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

        $category->image = $request->image ? $image_path : null;
        $category->thumb_image = $request->image ? $thumbnail_serialize : null;

        $category->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local) {
            $translation = new CategoryTranslation([
                'locale' => $localeCode,
                'name' => $request->name[$localeCode] ?? null,
                'description' => $request->description[$localeCode] ?? null,
                'category_meta_title' => $request->news_meta_title[$localeCode] ?? null,
                'category_meta_keywords' => $request->news_meta_keywords[$localeCode] ?? null,
                'category_meta_description' => $request->news_meta_description[$localeCode] ?? null,
                'facebook_meta_title' => $request->facebook_meta_title[$localeCode] ?? null,
                'facebook_meta_description' => $request->facebook_meta_description[$localeCode] ?? null,
                'twitter_meta_title' => $request->twitter_meta_title[$localeCode] ?? null,
                'twitter_meta_description' => $request->twitter_meta_description[$localeCode] ?? null,

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
