@extends('admin.layouts.main_template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/news/category/create.css') }}">
@endsection

@section('script')
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('js/admin/news/category/create.js') }}"></script>

@endsection

@section('content')

    <div class="create__page__container">
        <div class="create__page__header">
            <p class="create__title">
                {{ __('admin.create_category') }}
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

            <form action="{{ route('store_category') }}" method="POST" class="create__form" enctype="multipart/form-data">

                @csrf

                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local)

                    <div class="translatable hide" data-lang-container="{{ $localeCode }}">

                        {{-- Name --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="name" class="label">
                                    <p>{{ __('admin.title') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>
                                <input type="text" name="name[{{ $localeCode }}]" data-lang="{{ $localeCode }}" value="{{ old('name') }}">
                            </div>
                        </div>

                        {{-- Intro --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="description" class="label">
                                    <p>{{ __('admin.description') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>

                                <textarea name="description[{{ $localeCode }}]">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        {{-- Meta --}}
                        <div class="meta__container mt-4">

                            <div class="meta__navigation">
                                <ul>
                                    <li data-tab="category_{{$localeCode}}" class="active__tab">{{ __('admin.category_meta') }}</li>
                                    <li data-tab="facebook_{{$localeCode}}">{{ __('admin.facebook_meta') }}</li>
                                    <li data-tab="tweeter_{{$localeCode}}">{{ __('admin.twitter_meta') }}</li>
                                </ul>
                            </div>

                            <div class="meta__section show" data-tab-content="category_{{$localeCode}}">
                                <div class="input__group full px-0">
                                    <label for="meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="meta_title[{{ $localeCode }}]" value="{{ old('meta_title') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="meta_keywords" class="label">
                                        <p>{{ __('admin.keywords') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="meta_keywords[{{ $localeCode }}]" value="{{ old('meta_keywords') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>

                                    <textarea name="meta_description[{{ $localeCode }}]" cols="30" rows="5">{{ old('meta_description') }}</textarea>
                                </div>
                            </div>

                            <div class="meta__section hide" data-tab-content="facebook_{{$localeCode}}">
                                <div class="input__group full px-0">
                                    <label for="facebook_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="facebook_meta_title[{{ $localeCode }}]" value="{{ old('facebook_meta_title') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="facebook_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake[{{ $localeCode }}]"></i></span>
                                    </label>

                                    <textarea name="facebook_meta_description[{{ $localeCode }}]" cols="30" rows="5">{{ old('facebook_meta_description') }}</textarea>
                                </div>
                            </div>

                            <div class="meta__section hide" data-tab-content="tweeter_{{$localeCode}}">
                                <div class="input__group full px-0">
                                    <label for="twitter_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="twitter_meta_title[{{ $localeCode }}]" value="{{ old('twitter_meta_title') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="twitter_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>

                                    <textarea name="twitter_meta_description[{{ $localeCode }}]" cols="30" rows="5">{{ old('twitter_meta_description') }}</textarea>
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
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" readonly>
                                <div class="slug__edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </div>
                            </div>
                        </div>

                        <div class="image__container full px-0">
                            <div class="upload__image__container">
                                <!-- Upload image input-->
                                <input id="upload" type="file" class="upload__img" onchange="readURL(this);" name="image" value="{{ old('image') }}">
                                <!-- Uploaded image area-->
                                <div class="image__area" onclick="open_input('upload')">
                                    <p class="image__area__info" id="info">ატვირთეთ სურათი</p>
                                    <img id="imageResult"src="#" alt="">
                                </div>
                            </div>
                        </div>


                        <div class="input__group full">
                            <div class="switch__container">
                                <label class="switch">
                                    <input type="checkbox" name="publish" id="publish" checked>
                                    <span class="slider round"></span>
                                </label>
                                <p>{{ __('admin.publish_category') }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="create__submit__container">
                        <input type="submit" value="{{ __('admin.save') }}" class="create__btn">

                        <a href="{{ route('category_list') }}" class="cancel__btn">
                            {{ __('admin.cancel') }}
                        </a>
                    </div>

                </div>



            </form>
        </div>

    </div>

@endsection





