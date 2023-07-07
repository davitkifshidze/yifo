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

            <form action="{{ route('store_category') }}" method="POST" class="create__form">

                @csrf

                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local)

                    <div class="translatable hide" data-lang-container="{{ $localeCode }}">

                        {{-- Title --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="title" class="label">
                                    <p>{{ __('admin.title') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>
                                <input type="text" name="title[{{ $localeCode }}]" data-lang="{{ $localeCode }}" value="{{ old('title') }}">
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
                                    <li data-tab="news_{{$localeCode}}" class="active__tab">{{ __('admin.category_meta') }}</li>
                                    <li data-tab="facebook_{{$localeCode}}">{{ __('admin.facebook_meta') }}</li>
                                    <li data-tab="tweeter_{{$localeCode}}">{{ __('admin.twitter_meta') }}</li>
                                </ul>
                            </div>

                            <div class="meta__section show" data-tab-content="news_{{$localeCode}}">
                                <div class="input__group full px-0">
                                    <label for="news_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="news_meta_title[{{ $localeCode }}]" value="{{ old('news_meta_title') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="news_meta_keywords" class="label">
                                        <p>{{ __('admin.keywords') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="news_meta_keywords[{{ $localeCode }}]" value="{{ old('news_meta_keywords') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="news_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>

                                    <textarea name="news_meta_description[{{ $localeCode }}]" cols="30" rows="5">{{ old('news_meta_description') }}</textarea>
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

                    <!-- Slug & Date & Author & Category & Status -->
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

                        <a href="{{ route('news_list') }}" class="cancel__btn">
                            {{ __('admin.cancel') }}
                        </a>
                    </div>

                </div>



            </form>
        </div>

    </div>

@endsection





