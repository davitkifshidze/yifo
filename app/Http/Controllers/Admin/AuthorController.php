<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsAuthorRequest;
use App\Models\Author;
use App\Models\AuthorTranslations;
use Illuminate\Http\Request;
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
        $locale = LaravelLocalization::getCurrentLocale();

        $author = new Author();
        $author->slug = $request->slug;
        $author->facebook = $request->facebook;
        $author->email = $request->email;
        $author->publish = $request->has('publish') ? 1 : 0 ;
        $author->save();
        
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local):
            $translation = new AuthorTranslations([
                'locale' => $localeCode,
                'name' => ($localeCode == $locale) ? $request->name : null,
                'description' => ($localeCode == $locale) ? $request->description : null,
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
