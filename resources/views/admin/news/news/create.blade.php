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
        </div>

        <div class="create__post__container">
            <form action="test" method="post" class="create__form">

                <!-- Title & Slug -->
                <div class="create__input__group">
                    <div class="input__label">
                        <label for="title" class="label">
                            <p>{{ __('admin.title') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input type="text" name="title" id="title">
                    </div>

                    <div class="input__label">
                        <label for="slug" class="label">
                            <p>{{ __('admin.slug') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input class="tag__input" type="text" name="slug" id="slug">
                    </div>
                </div>

                <!-- Content -->
                <div class="create__content">
                    <textarea id="content">Welcome to TinyMCE!</textarea>
                </div>

                <!-- Author & Category -->
                <div class="create__input__group">
                    <div class="input__label">
                        <label class="label">
                            <p>{{ __('admin.author') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>

                        <div class="create__author">
                            <label class="input">
                                <input mbsc-input id="create__author__input"
                                       placeholder="{{ __('admin.select_author') }}..." data-dropdown="true"
                                       data-input-style="outline" data-label-style="stacked"
                                       data-tags="true"/>
                            </label>
                            <select name="author" id="create__author__select" multiple>
                                <option value="1">Emanuel Adams</option>
                                <option value="2">Adam Mitch</option>
                                <option value="4">Larry Manet</option>
                                <option value="6">Tomas jerkin</option>
                            </select>
                        </div>
                    </div>

                    <div class="input__label">
                        <label class="label">
                            <p>{{ __('admin.category') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <div class="create__category">
                            <label class="input">
                                <input mbsc-input id="create__category__input"
                                       placeholder="{{ __('admin.select_category') }}..." data-dropdown="true"
                                       data-input-style="outline" data-label-style="stacked"
                                       data-tags="true"/>
                            </label>
                            <select name="author" id="create__category__select" multiple>
                                <option value="1">Books</option>
                                <option value="2">Movies</option>
                                <option value="4">Garden</option>
                                <option value="6">Toys</option>
                                <option value="7">Beauty</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tag & Publish Date-->
                <div class="create__input__group">
                    <div class="input__label">
                        <label for="tag__input" class="label">
                            <p>{{ __('admin.tag') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input name="tags" id="tag__input" placeholder="{{ __('admin.write_tag') }}" value="sport,book">
                    </div>
                    <div class="input__label">
                        <label for="datetimepicker" class="label">
                            <p>{{ __('admin.publish_date') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input type="date" value="" id="datetimepicker" class="pickaxe"/>
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
                            <input id="upload" type="file" onchange="readURL(this);" >
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
                            <img id="imageResult" src="#" alt="">
                        </div>
                    </div>
                </div>


                <style>

                </style>
                <div class="create__submit__container">
                    <input type="submit" value="{{ __('admin.save') }}" class="create__post__btn">
                    <input type="submit" value="{{ __('admin.cancel') }}" class="cancel__post__btn">
                </div>

            </form>
        </div>

    </div>


@endsection





