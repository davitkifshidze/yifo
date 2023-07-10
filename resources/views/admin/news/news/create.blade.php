@extends('admin.layouts.main_template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/news/news/create.css') }}">
@endsection

@section('script')
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('js/admin/news/news/create.js') }}"></script>
    <script src="{{ asset('js/admin/news/news/tinymce.js') }}"></script>
@endsection

@section('content')

    <div class="create__page__container">
        <div class="create__page__header">
            <p class="create__title">
                {{ __('admin.create_news') }}
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

            <form action="{{ route('news_store') }}" method="POST" class="create__form" enctype="multipart/form-data">
                @csrf

                @foreach (LaravelLocalization::getSupportedLocales() as $locale_code => $local)

                    <div class="translatable hide" data-lang-container="{{ $locale_code }}">

                        {{-- Title & Tag --}}
                        <div class="form__group row">
                            <div class="input__group">
                                <label for="title" class="label">
                                    <p>{{ __('admin.title') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>
                                <input type="text" name="title[{{ $locale_code }}]" data-lang="{{ $locale_code }}" value="{{ old('title') }}">
                            </div>

                            <div class="input__group">
                                <label for="tag__input" class="label">
                                    <p>{{ __('admin.tag') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>
                                <input type="text" class="tag__input" name="tag[{{ $locale_code }}]" placeholder="{{ __('admin.write_tag') }}" value="{{ old('tag') }}">
                            </div>

                        </div>

                        {{-- Intro --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="intro" class="label">
                                    <p>{{ __('admin.intro') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>

                                <textarea name="intro[{{ $locale_code }}]">{{ old('intro') }}</textarea>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="text" class="label">
                                    <p>{{ __('admin.text') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>

                                <textarea class="text_tinymce" name="text[{{ $locale_code }}]">{{ old('text') }}</textarea>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="image__container full">
                            <div class="upload__image__container" data-image-container="image_{{ $locale_code }}">
                                {{-- Upload image input --}}
                                <input id="upload_{{ $locale_code }}" class="upload__img" type="file"  data-locale="{{ $locale_code }}" data-image-input onchange="readURL(this, 'imageResult_{{ $locale_code }}');" name="image[{{ $locale_code }}]" value="{{ old('image') }}">
                                {{-- Upload image area --}}
                                <div class="image__area" onclick="open_input('upload_{{ $locale_code }}')">
                                    <p class="image__area__info" id="info_{{ $locale_code }}">{{ __('admin.upload_image') }}</p>
                                    <img id="imageResult_{{ $locale_code }}" src="#" alt="">
                                </div>
                            </div>
                        </div>

                        {{-- Meta --}}
                        <div class="meta__container">

                            <div class="meta__navigation">
                                <ul>
                                    <li data-tab="news_{{$locale_code}}" class="active__tab">{{ __('admin.news_meta') }}</li>
                                    <li data-tab="facebook_{{$locale_code}}">{{ __('admin.facebook_meta') }}</li>
                                    <li data-tab="tweeter_{{$locale_code}}">{{ __('admin.twitter_meta') }}</li>
                                </ul>
                            </div>

                            <div class="meta__section show" data-tab-content="news_{{$locale_code}}">
                                <div class="input__group full px-0">
                                    <label for="meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="meta_title[{{ $locale_code }}]" value="{{ old('meta_title') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="meta_keywords" class="label">
                                        <p>{{ __('admin.keywords') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="meta_keywords[{{ $locale_code }}]" value="{{ old('meta_keywords') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>

                                    <textarea name="meta_description[{{ $locale_code }}]" cols="30" rows="5">{{ old('meta_description') }}</textarea>
                                </div>
                            </div>

                            <div class="meta__section hide" data-tab-content="facebook_{{$locale_code}}">
                                <div class="input__group full px-0">
                                    <label for="facebook_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="facebook_meta_title[{{ $locale_code }}]" value="{{ old('facebook_meta_title') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="facebook_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake[{{ $locale_code }}]"></i></span>
                                    </label>

                                    <textarea name="facebook_meta_description[{{ $locale_code }}]" cols="30" rows="5">{{ old('facebook_meta_description') }}</textarea>
                                </div>
                            </div>

                            <div class="meta__section hide" data-tab-content="tweeter_{{$locale_code}}">
                                <div class="input__group full px-0">
                                    <label for="twitter_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="twitter_meta_title[{{ $locale_code }}]" value="{{ old('twitter_meta_title') }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="twitter_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>

                                    <textarea name="twitter_meta_description[{{ $locale_code }}]" cols="30" rows="5">{{ old('twitter_meta_description') }}</textarea>
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

                        <div class="input__group full px-0">
                            <label for="datetimepicker" class="label">
                                <p>{{ __('admin.publish_date') }}</p>
                                <span><i class="fa-solid fa-snowflake"></i></span>
                            </label>
                            <input name="publish_date" type="date" value="" id="datetimepicker" class="pickaxe"/>
                        </div>

                        <div class="input__group full px-0 relative">
                            <label class="label">
                                <p>{{ __('admin.author') }}</p>
                                <span><i class="fa-solid fa-snowflake"></i></span>
                            </label>
                            <select name="author[]" id="create__author__select" multiple>

                                @foreach($authors as $key => $author)
                                    <option value="{{ $author->id }}" >{{ $author->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="input__group full px-0 relative">
                            <label class="label">
                                <p>{{ __('admin.category') }}</p>
                                <span><i class="fa-solid fa-snowflake"></i></span>
                            </label>
                            <div class="create__category">
                                <select name="category[]" id="create__category__select" multiple>

                                    @foreach($categories as $key => $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="input__group full">
                            <div class="switch__container">
                                <label class="switch">
                                    <input type="checkbox" name="publish" id="publish" checked>
                                    <span class="slider round"></span>
                                </label>
                                <p>{{ __('admin.publish_news') }}</p>
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
