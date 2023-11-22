<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsAuthorRequest;
use App\Models\Author;
use App\Models\AuthorTranslations;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $authors = Author::select('authors.id', 'authors.slug','authors.publish','authors.facebook','authors.email', 'authors.created_at', 'authors.updated_at', 'author_translations.locale', 'author_translations.name',  'author_translations.description')
            ->join('author_translations','author_translations.author_id','=','authors.id')
            ->where('locale', '=', LaravelLocalization::getCurrentLocale())
            ->get();

        return view('admin.news.author.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.author.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsAuthorRequest $request)
    {

        $author = new Author();
        $author->slug = $request->slug;
        $author->facebook = $request->facebook ?? null;
        $author->email = $request->email;
        $author->publish = $request->has('publish') ? 1 : 0 ;


        /**
         * Image Upload
         */
        if ($request->hasFile('image')) {

            $current_date = Carbon::now();
            $month = $current_date->format('m');
            $year = $current_date->format('Y');

            $path = 'public/uploads/author/images/' . $year . '/' . $month;
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

            $author->image = $request->image ? $image_path : null;
            $author->thumb_image = $request->image ? $thumbnail_serialize : null;

        }

        $author->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local):
            $translation = new AuthorTranslations([
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
            $author->translations()->save($translation);

        endforeach;

        return redirect(route('author_list'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        foreach(LaravelLocalization::getSupportedLocales() as $locale_code => $locale):

            $author[$locale_code] = Author::select('authors.id', 'authors.slug', 'authors.image', 'authors.thumb_image', 'authors.email', 'authors.facebook', 'authors.publish')
                ->addSelect(
                    'author_translations.id as translation_id',
                    'author_translations.locale',
                    'author_translations.name',
                    'author_translations.description',
                    'author_translations.meta_title',
                    'author_translations.meta_keywords',
                    'author_translations.meta_description',
                    'author_translations.facebook_meta_title',
                    'author_translations.facebook_meta_description',
                    'author_translations.twitter_meta_title',
                    'author_translations.twitter_meta_description'
                )
                ->join('author_translations', 'author_translations.author_id', '=', 'authors.id')
                ->where('author_translations.locale', '=', $locale_code)
                ->where('authors.id', '=', $id)
                ->first();
        endforeach;

        $author_id = $author[LaravelLocalization::getCurrentLocale()]->id;

        return view('admin.news.author.edit', compact('author', 'author_id'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsAuthorRequest $request, $id): RedirectResponse
    {
        $author = Author::findOrFail($id);
        $author->slug = $request->slug;
        $author->facebook = $request->facebook;
        $author->email = $request->email;
        $author->publish = $request->has('publish') ? 1 : 0;

        if ($request->hasFile('image')) {

            /** Remove Old Image & Thumb Image & Also Empty Folder */
            if ($author->image) {
                Storage::delete('public/uploads/author/images/' . $author->image);
            }

            if ($author->thumb_image) {
                $thumbnail_data = unserialize($author->thumb_image);
                foreach ($thumbnail_data as $thumbnail) {
                    Storage::delete('public/uploads/author/images/' . $thumbnail);
                }
            }

            /** Upload new image */
            $author_image_dir = storage_path('app/public/uploads/author/images/');
            deleteEmptyFolders($author_image_dir);

            /** Upload new image */
            $current_date = Carbon::now();
            $month = $current_date->format('m');
            $year = $current_date->format('Y');

            $path = 'public/uploads/author/images/' . $year . '/' . $month;
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

            $author->image = $image_path;
            $author->thumb_image = $thumbnail_serialize;
        }

        $author->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local) {
            $translation = AuthorTranslations::where('author_id', $author->id)
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

        return redirect()->route('edit_author',$id)->with( ['update' => 'success'] );

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $authors = Author::findOrFail($id);
        $authors->translations()->forceDelete();
        $authors->forceDelete();

        return response()->json(['succes' => true]);

    }
}
