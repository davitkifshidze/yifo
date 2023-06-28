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

    <div class="create__post__container">
        <div class="title__container">
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

                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local)

                    <div class="translatable hide" data-lang-container="{{ $localeCode }}">

                        {{-- Title & Tag --}}
                        <div class="form__group row">
                            <div class="input__group">
                                <label for="title" class="label">
                                    <p>{{ __('admin.title') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>

                                <input type="text" name="name" value="{{ old('title') }}">
                            </div>

                            <div class="input__group">
                                <label for="tag__input" class="label">
                                    <p>{{ __('admin.tag') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>
                                <input type="text" class="tag__input" name="tags[{{ $localeCode }}]" placeholder="{{ __('admin.write_tag') }}" value="{{ old('tags') }}">
                            </div>

                        </div>

                        {{-- Intro & Content --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="intro" class="label">
                                    <p>{{ __('admin.intro') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>

                                <textarea class="intro_tinymce" name="intro[{{ $localeCode }}]">{{ old('intro') }}</textarea>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="text" class="label">
                                    <p>{{ __('admin.text') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>

                                <textarea class="text_tinymce" name="text[{{ $localeCode }}]">{{ old('text') }}</textarea>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="create__image__container full">
                            <a href="javascript:void(0)" class="create__image">
                                <span>{{ __('admin.image') }}</span>
                                <i class="fa fa-angle-down upload__image__arrow"></i>
                            </a>

                            <div class="upload__image__container">
                                <!-- Upload image input-->
                                <div class="img__input__container">
                                    <input id="upload" type="file" onchange="readURL(this);" name="image" value="{{ old('image') }}">
                                    <label id="upload__label" for="upload" class="choose__img">{{ __('admin.chose_image') }}</label>
                                    <div class="chose__img__container">
                                        <label for="upload">
                                            <i class="fa fa-cloud-upload upload__arrow"></i>
                                            <small class="choose__file">{{ __('admin.chose_file') }}</small>
                                        </label>
                                    </div>
                                </div>
                                <!-- Uploaded image area-->
                                <div class="image__area">
                                    <img id="imageResult" src="#" alt="">
                                </div>
                            </div>
                        </div>

                        {{-- Meta --}}
                        <div class="meta__container">

                            <div class="meta__navigation">
                                <ul>
                                    <li data-tab="news_{{$localeCode}}" class="active__tab">{{ __('admin.news_meta') }}</li>
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

                            <input type="text" name="slug" value="{{ old('slug') }}">
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
                        <input type="submit" value="{{ __('admin.save') }}" class="create__post__btn">

                        <a href="{{ route('news_list') }}" class="cancel__post__btn">
                            {{ __('admin.cancel') }}
                        </a>
                    </div>

                </div>


            </form>
        </div>

    </div>


@endsection
