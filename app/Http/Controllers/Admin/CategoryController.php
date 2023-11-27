<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsCategoryRequest;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
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
    public function index(Request $request)
    {

        $categories = Category::select('categories.id' , 'categories.slug', 'categories.publish', 'categories.created_at', 'categories.updated_at', 'category_translations.locale', 'category_translations.name',  'category_translations.description')
            ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
            ->where('category_translations.locale', '=', LaravelLocalization::getCurrentLocale())
            ->get();

        return view('admin.news.category.index', compact('categories', 'request'));

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

        $category = new Category();
        $category->slug = $request->slug;
        $category->publish = ($request->publish == 'on') ? 1 : 0;

        /**
         * Image Upload
         */
        if ($request->hasFile('image')) {

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

        }

        $category->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local) {
            $translation = new CategoryTranslation([
                'locale' => $localeCode,
                'name' => $request->name[$localeCode] ?? null,
                'description' => $request->description[$localeCode] ?? null,
                'meta_title' => $request->meta_title[$localeCode] ?? null,
                'meta_keywords' => $request->meta_keywords[$localeCode] ?? null,
                'meta_description' => $request->meta_description[$localeCode] ?? null,
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

        foreach(LaravelLocalization::getSupportedLocales() as $locale_code => $locale):

            $category[$locale_code] = Category::select('categories.id', 'categories.slug', 'categories.image', 'categories.thumb_image', 'categories.publish')
                ->addSelect(
                    'category_translations.id as translation_id',
                    'category_translations.locale',
                    'category_translations.name',
                    'category_translations.description',
                    'category_translations.meta_title',
                    'category_translations.meta_keywords',
                    'category_translations.meta_description',
                    'category_translations.facebook_meta_title',
                    'category_translations.facebook_meta_description',
                    'category_translations.twitter_meta_title',
                    'category_translations.twitter_meta_description'
                )
                ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
                ->where('category_translations.locale', '=', $locale_code)
                ->where('categories.id', '=', $id)
                ->first();
        endforeach;

        $category_id = $category[LaravelLocalization::getCurrentLocale()]->id;

        return view('admin.news.category.edit', compact('category', 'category_id'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsCategoryRequest $request, string $id): RedirectResponse
    {

        $category = Category::findOrFail($id);
        $category->slug = $request->slug;
        $category->publish = $request->has('publish') ? 1 : 0;

        if ($request->hasFile('image')) {

            /** Remove Old Image & Thumb Image & Also Empty Folder */
            if ($category->image) {
                Storage::delete('public/uploads/category/images/' . $category->image);
            }

            if ($category->thumb_image) {
                $thumbnail_data = unserialize($category->thumb_image);
                foreach ($thumbnail_data as $thumbnail) {
                    Storage::delete('public/uploads/category/images/' . $thumbnail);
                }
            }

            /** Upload new image */
            $category_image_dir = storage_path('app/public/uploads/category/images/');
            deleteEmptyFolders($category_image_dir);

            /** Upload new image */
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

            /** Create new thumbnails */
            $thumbnail_size_list = [
                'small' => [
                    'width' => '100',
                    'height' => '100',
                ],
                'medium' => [
                    'width' => '400',
                    'height' => '400',
                ],
                'high' => [
                    'width' => '600',
                    'height' => '600',
                ]
            ];

            $thumbnail_data = [];

            foreach ($thumbnail_size_list as $folder => $size) {
                $thumbnail_path = $path . '/thumb/' . $folder;
                if (!Storage::exists($thumbnail_path)) {
                    Storage::makeDirectory($thumbnail_path, 0777, true);
                }

                $thumb_image_path = $year . '/' . $month . '/thumb/' . $folder . '/' . $image_name;

                $thumbnail_data[$folder] = $thumb_image_path;

                $thumbnail_image_path = $thumbnail_path . '/' . $image_name;
                Image::make(storage_path('app/' . $path . '/' . $image_name))
                    ->fit($size['width'], $size['height'])
                    ->save(storage_path('app/' . $thumbnail_image_path));
            }

            $thumbnail_serialize = serialize($thumbnail_data);

            $category->image = $image_path;
            $category->thumb_image = $thumbnail_serialize;
        }

        $category->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local) {
            $translation = CategoryTranslation::where('category_id', $category->id)
                ->where('locale', $localeCode)
                ->firstOrFail();

            $translation->name = $request->name[$localeCode] ?? null;
            $translation->description = $request->description[$localeCode] ?? null;
            $translation->meta_title = $request->meta_title[$localeCode] ?? null;
            $translation->meta_keywords = $request->meta_keywords[$localeCode] ?? null;
            $translation->meta_description = $request->meta_description[$localeCode] ?? null;
            $translation->facebook_meta_title = $request->facebook_meta_title[$localeCode] ?? null;
            $translation->facebook_meta_description = $request->facebook_meta_description[$localeCode] ?? null;
            $translation->twitter_meta_title = $request->twitter_meta_title[$localeCode] ?? null;
            $translation->twitter_meta_description = $request->twitter_meta_description[$localeCode] ?? null;

            $translation->save();
        }

        return redirect()->route('edit_category',$id)->with( ['update' => 'success'] );

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
