@extends('admin.layouts.main_template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/news/category/edit.css') }}">
@endsection

@section('script')
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('js/admin/news/category/edit.js') }}"></script>

@endsection

@section('content')

    @if(session('update'))
        <script>
            showMessage('success', '{{ __('admin.category_edit_success') }}' , 1000, 'top-end');
        </script>
    @endif

    <div class="edit__page__container">
        <div class="edit__page__header">
            <p class="edit__title">
                {{ __('admin.edit_category') }}
            </p>

            <div class="lang__tabs">
                <a class="lang__tab active__lang" data-lang="ka" href="javascript:void(0)">Ka</a>
                <a class="lang__tab" data-lang="en" href="javascript:void(0)">En</a>
            </div>

        </div>

        <div class="form__container">

            @if ($errors->any())
                <div class="error__container">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('update_category', $category_id) }}" method="POST" class="edit__form"  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                @foreach (LaravelLocalization::getSupportedLocales() as $locale_code => $local)

                    <div class="translatable hide" data-lang-container="{{ $locale_code }}">

                        {{-- Name --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="name" class="label">
                                    <p>{{ __('admin.title') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>
                                <input type="text" name="name[{{ $locale_code }}]" data-lang="{{ $locale_code }}" value="{{ $category[$locale_code]->name }}">
                            </div>
                        </div>

                        {{-- Intro --}}
                        <div class="form__group row">
                            <div class="input__group full">
                                <label for="description" class="label">
                                    <p>{{ __('admin.description') }}</p>
                                    <span><i class="fa-solid fa-snowflake"></i></span>
                                </label>

                                <textarea name="description[{{ $locale_code }}]">{{ $category[$locale_code]->description }}</textarea>

                            </div>
                        </div>

                        {{-- Meta --}}
                        <div class="meta__container mt-4">

                            <div class="meta__navigation">
                                <ul>
                                    <li data-tab="category_{{$locale_code}}" class="active__tab">{{ __('admin.category_meta') }}</li>
                                    <li data-tab="facebook_{{$locale_code}}">{{ __('admin.facebook_meta') }}</li>
                                    <li data-tab="tweeter_{{$locale_code}}">{{ __('admin.twitter_meta') }}</li>
                                </ul>
                            </div>

                            <div class="meta__section show" data-tab-content="category_{{$locale_code}}">
                                <div class="input__group full px-0">
                                    <label for="meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="meta_title[{{ $locale_code }}]" value="{{ $category[$locale_code]->meta_title }}">

                                </div>

                                <div class="input__group full px-0">
                                    <label for="meta_keywords" class="label">
                                        <p>{{ __('admin.keywords') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="meta_keywords[{{ $locale_code }}]" value="{{ $category[$locale_code]->meta_keywords }}">

                                </div>

                                <div class="input__group full px-0">
                                    <label for="meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <textarea name="meta_description[{{ $locale_code }}]" cols="30" rows="5">{{ $category[$locale_code]->meta_description }}</textarea>
                                </div>
                            </div>

                            <div class="meta__section hide" data-tab-content="facebook_{{$locale_code}}">
                                <div class="input__group full px-0">
                                    <label for="facebook_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="facebook_meta_title[{{ $locale_code }}]" value="{{ $category[$locale_code]->facebook_meta_title }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="facebook_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake[{{ $locale_code }}]"></i></span>
                                    </label>

                                    <textarea name="facebook_meta_description[{{ $locale_code }}]" cols="30" rows="5">{{ $category[$locale_code]->facebook_meta_description }}</textarea>
                                </div>
                            </div>

                            <div class="meta__section hide" data-tab-content="tweeter_{{$locale_code}}">
                                <div class="input__group full px-0">
                                    <label for="twitter_meta_title" class="label">
                                        <p>{{ __('admin.title') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>
                                    <input type="text" name="twitter_meta_title[{{ $locale_code }}]" value="{{ $category[$locale_code]->twitter_meta_title }}">
                                </div>

                                <div class="input__group full px-0">
                                    <label for="twitter_meta_description" class="label">
                                        <p>{{ __('admin.description') }}</p>
                                        <span><i class="fa-solid fa-snowflake"></i></span>
                                    </label>

                                    <textarea name="twitter_meta_description[{{ $locale_code }}]" cols="30" rows="5">{{ $category[$locale_code]->twitter_meta_description }}</textarea>
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
                                <input type="text" name="slug" id="slug" value="{{ $category[$locale_code]->slug }}" readonly>
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


                                    <p class="image__area__info <?= $category[$locale_code]->image ? 'none' : 'block' ?>" id="info">{{ __('admin.upload_image') }}</p>

                                    <span class="remove__btn <?= $category[$locale_code]->image ? 'block' : 'none' ?>" onclick="removeImage(event)">
                                        <i class="fa-regular fa-circle-xmark"></i>
                                    </span>

                                    <img id="upload__img__result" src="{{ $category[$locale_code]->image ? asset('storage/uploads/category/images/' . $category[$locale_code]->image) : ''  }}" alt="">


                                </div>
                            </div>
                        </div>


                        <div class="input__group full">
                            <div class="switch__container">
                                <label class="switch">
                                    <input type="checkbox" name="publish" id="publish" {{ $category[$locale_code]->publish == 1 ? 'checked' : '' }} >
                                    <span class="slider round"></span>
                                </label>
                                <p>{{ __('admin.publish_category') }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="edit__submit__container">
                        <input type="submit" value="{{ __('admin.save') }}" class="edit__btn">

                        <a href="{{ route('category_list') }}" class="cancel__btn">
                            {{ __('admin.cancel') }}
                        </a>
                    </div>

                </div>



            </form>
        </div>

    </div>

@endsection








