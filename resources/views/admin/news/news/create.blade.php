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

    <div class="post__create">
        <div class="title__container">
            <p class="create__title">
                {{ __('admin.create_news') }}
            </p>

            <style>
                .lang__tabs{
                    display: flex;
                    flex-direction: row;
                }
                .lang__tab{
                    padding: 5px 10px;
                    border: 1px solid var(--green-dark);
                    color: var(--green-dark);
                    margin-left: 10px;
                    background-color:white;
                }
                .active{
                    padding: 5px 10px;
                    background-color: var(--green-dark) !important;
                    color: white !important;
                    margin-left: 10px;
                }

            </style>

            <div class="lang__tabs">
                <a class="lang__tab active" data-lang="ka" href="javascript:void(0)">Ka</a>
                <a class="lang__tab" data-lang="en" href="javascript:void(0)">En</a>
            </div>

        </div>

        <div class="create__post__container">
            <form action="{{ route('news_store') }}" method="POST" class="create__form" enctype="multipart/form-data">

                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Title & Slug --}}
                <div class="form__group">
                    <div class="input__group">
                        <label for="title" class="label">
                            <p>{{ __('admin.title') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>

                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local)
                            <input type="text" name="name[<?= $localeCode ?>]"  data-lang="<?= $localeCode ?>" value="{{ old('title') }}">
                        @endforeach

                    </div>

                    <div class="input__group">
                        <label for="slug" class="label">
                            <p>{{ __('admin.slug') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>

                        <input type="text" name="slug" value="{{ old('slug') }}">

                    </div>
                </div>


                {{-- Intro & Content --}}
                <div class="form__group">
                    <div class="input__group">
                        <label for="intro" class="label">
                            <p>{{ __('admin.intro') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>

                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local)
                            <textarea class="intro_tinymce" name="intro[<?= $localeCode ?>]" data-lang="<?= $localeCode ?>">{{ old('intro') }}</textarea>
                        @endforeach


                    </div>

                    <div class="input__group">
                        <label for="text" class="label">
                            <p>{{ __('admin.text') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>

                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local)
                            <textarea class="text_tinymce" name="text[<?= $localeCode ?>]" data-lang="<?= $localeCode ?>">{{ old('text') }}</textarea>
                        @endforeach

                    </div>
                </div>


                <!-- Author & Category -->
                <div class="form__group">
                    <div class="input__group">
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

                    <div class="input__group">
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
                </div>


                <!-- Tag & Publish Date-->
                <div class="form__group">
                    <div class="input__group">
                        <label for="tag__input" class="label">
                            <p>{{ __('admin.tag') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>

                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $local)
                            <input type="text"  class="tag__input" name="tags[<?= $localeCode ?>]"  data-lang="<?= $localeCode ?>" placeholder="{{ __('admin.write_tag') }}" value="{{ old('tags') }}">
                        @endforeach

                    </div>
                    <div class="input__group">
                        <label for="datetimepicker" class="label">
                            <p>{{ __('admin.publish_date') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input name="publish_date" type="date" value="" id="datetimepicker" class="pickaxe"/>
                    </div>
                </div>

                <!-- Status -->
                <div class="form__group">
                    <div class="switch__container">
                        <label class="switch">
                            <input type="checkbox" name="publish" id="publish" checked>
                            <span class="slider round"></span>
                        </label>
                        <p>{{ __('admin.publish_news') }}</p>
                    </div>
                </div>

                <!-- Image -->
                <div class="create__image__container">

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
                                <label for="upload" >
                                    <i class="fa fa-cloud-upload upload__arrow"></i>
                                    <small class="choose__file">{{ __('admin.chose_file') }}</small>
                                </label>
                            </div>
                        </div>
                        <!-- Uploaded image area-->
                        <div class="image__area">
                            <img id="imageResult"src="#" alt="">
                        </div>
                    </div>
                </div>


                <style>

                </style>
                <div class="create__submit__container">
                    <input type="submit" value="{{ __('admin.save') }}" class="create__post__btn">


                    <a href="{{ route('news_list') }}" class="cancel__post__btn">
                        {{ __('admin.cancel') }}
                    </a>

                </div>

            </form>
        </div>

    </div>


@endsection
