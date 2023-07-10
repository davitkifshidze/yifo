<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsAuthorRequest;
use App\Models\Author;
use App\Models\AuthorTranslations;
use Carbon\Carbon;
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
    public function store(Request $request)
    {

        $author = new Author();
        $author->slug = $request->slug;
        $author->facebook = $request->facebook;
        $author->email = $request->email;
        $author->publish = $request->has('publish') ? 1 : 0 ;

        /**
         * Image Upload
         */
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

        $locale = LaravelLocalization::getCurrentLocale();

        $author = Author::select('authors.id', 'authors.slug', 'authors.email', 'authors.facebook', 'authors.publish')
            ->addSelect('author_translations.locale', 'author_translations.name', 'author_translations.author_id', 'author_translations.description')
            ->join('author_translations', 'author_translations.author_id', '=', 'authors.id')
            ->where('author_translations.locale', '=', $locale)
            ->where('authors.id', '=', $id)
            ->first();

        return view('admin.news.author.edit', compact('author'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsAuthorRequest $request, string $id)
    {
        $author = Author::find($id);

        $author->update([
            'slug' => $request->slug,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'publish' => $request->publish == 'on' ? 1 : 0,
        ]);

        $locale = LaravelLocalization::getCurrentLocale();

        AuthorTranslations::where('author_id', $id)
            ->where('locale', $locale)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

        return redirect()->route('edit_author',$id)->with( 'update', 'success' );
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
