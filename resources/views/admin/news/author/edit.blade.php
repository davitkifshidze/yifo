@extends('admin.layouts.main_template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/news/author/edit.css') }}">
@endsection

@section('script')
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('js/admin/news/author/edit.js') }}"></script>

@endsection

@section('content')

    <div class="edit__page__container">
        <div class="edit__page__header">
            <p class="edit__title">
                {{ __('admin.edit_author') }}
            </p>

            <div class="lang__tabs">
                <a class="lang__tab active__lang" data-lang="ka" href="javascript:void(0)">Ka</a>
                <a class="lang__tab" data-lang="en" href="javascript:void(0)">En</a>
            </div>
        </div>

        <div class="form__container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('store_author') }}" method="POST" class="edit__form"  enctype="multipart/form-data">

                @csrf

                @foreach (LaravelLocalization::getSupportedLocales() as $locale_code => $local)

                    <div class="translatable hide" data-lang-container="{{ $locale_code }}">

                        {{-- Name --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="name" class="label">
                                    <p>{{ __('admin.name') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>
                                <input type="text" name="name[{{ $locale_code }}]" data-lang="{{ $locale_code }}" value="{{ $author[$locale_code]->name }}">
                            </div>
                        </div>

                        {{-- Intro --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="description" class="label">
                                    <p>{{ __('admin.description') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>

                                <textarea name="description[{{ $locale_code }}]">{{ $author[$locale_code]->description }}</textarea>
                            </div>
                        </div>

                        {{-- Meta --}}
                        <div class="meta__container mt-4">

                            <div class="meta__navigation">
                                <ul>
                                    <li data-tab="author_{{$locale_code}}" class="active__tab">{{ __('admin.author_meta') }}</li>
                                    <li data-tab="facebook_{{$locale_code}}">{{ __('admin.facebook_meta') }}</li>
                                    <li data-tab="tweeter_{{$locale_code}}">{{ __('admin.twitter_meta') }}</li>
                                </ul>
                            </div>

                            <div class="meta__section show" data-tab-content="author_{{$locale_code}}">
                                <div class="input__group full px-0">
                                    <label for="author_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="meta_title[{{ $locale_code }}]" value="{{ $author[$locale_code]->meta_title }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="author_meta_keywords" class="label">
                                        <p>{{ __('admin.keywords') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="meta_keywords[{{ $locale_code }}]" value="{{ $author[$locale_code]->meta_keywords }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="author_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>

                                    <textarea name="meta_description[{{ $locale_code }}]" cols="30" rows="5">{{ $author[$locale_code]->meta_description }}</textarea>
                                </div>
                            </div>

                            <div class="meta__section hide" data-tab-content="facebook_{{$locale_code}}">
                                <div class="input__group full px-0">
                                    <label for="facebook_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="facebook_meta_title[{{ $locale_code }}]" value="{{ $author[$locale_code]->facebook_meta_title }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="facebook_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake[{{ $locale_code }}]"></i></span>
                                    </label>

                                    <textarea name="facebook_meta_description[{{ $locale_code }}]" cols="30" rows="5">{{ $author[$locale_code]->facebook_meta_description }}</textarea>
                                </div>
                            </div>

                            <div class="meta__section hide" data-tab-content="tweeter_{{$locale_code}}">
                                <div class="input__group full px-0">
                                    <label for="twitter_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="twitter_meta_title[{{ $locale_code }}]" value="{{ $author[$locale_code]->twitter_meta_title }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="twitter_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>

                                    <textarea name="twitter_meta_description[{{ $locale_code }}]" cols="30" rows="5">{{ $author[$locale_code]->twitter_meta_description }}</textarea>
                                </div>
                            </div>

                        </div>

                    </div>

                @endforeach

                <div class="non__translatable">

                    {{-- Slug & Image & Publish--}}
                    <div class="form__group column">

                        <div class="input__group full px-0">
                            <label for="slug" class="label">
                                <p>{{ __('admin.slug') }}</p>
                                <span><i class="fa-solid fa-snowflake"></i></span>
                            </label>

                            <div class="slug__container">
                                <input type="text" name="slug" id="slug" value="{{ $author[$locale_code]->slug }}" readonly>
                                <div class="slug__edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </div>
                            </div>
                        </div>

                        <div class="image__container full px-0">
                            <div class="upload__image__container">
                                <!-- Upload image input-->
                                <input id="upload" type="file" class="upload__img" onchange="readURL(this);" name="image" value="{{ $author[$locale_code]->image  }}">
                                <!-- Uploaded image area-->
                                <div class="image__area" onclick="open_input('upload')">
                                    <p class="image__area__info" id="info">{{ __('admin.upload_image') }}</p>
                                    <img id="imageResult"src="#" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="input__group full px-0">
                            <label for="email" class="label">
                                <p>{{ __('admin.email') }}</p>
                            </label>
                            <input type="text" id="email" name="email" value="{{ $author[$locale_code]->email }}">
                        </div>

                        <div class="input__group  full px-0">
                            <label for="facebook" class="label">
                                <p>{{ __('admin.facebook') }}</p>
                            </label>
                            <input type="text" id="facebook" name="facebook" value="{{ $author[$locale_code]->facebook }}">
                        </div>

                        <div class="input__group full">
                            <div class="switch__container">
                                <label class="switch">
                                    <input type="checkbox" name="publish" id="publish" checked>
                                    <span class="slider round"></span>
                                </label>
                                <p>{{ __('admin.publish_author') }}</p>
                            </div>
                        </div>

                    </div>


                    <div class="edit__submit__container">
                        <input type="submit" value="{{ __('admin.save') }}" class="edit__btn">

                        <a href="{{ route('author_list') }}" class="cancel__btn">
                            {{ __('admin.cancel') }}
                        </a>
                    </div>

                </div>

            </form>
        </div>

    </div>

@endsection
