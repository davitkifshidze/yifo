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

    <div class="category__create">
        <div class="title__container">
            <p class="create__title">
                {{ __('admin.create_category') }}
            </p>
        </div>

        <div class="create__category__container">
            <form action="{{ route('store_category') }}" method="POST" class="create__form">

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

                <!-- Title & Slug -->
                <div class="form__group">
                    <div class="input__group">
                        <label for="title" class="label">
                            <p>{{ __('admin.title') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input type="text" name="name" id="name"  value="{{ old('name') }}">
                    </div>

                    <div class="input__group">
                        <label for="slug" class="label">
                            <p>{{ __('admin.slug') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input readonly class="tag__input readonly__input" type="text" name="slug" id="slug"  value="{{ old('slug') }}">

                    </div>
                </div>

                <div class="form__group">
                    <div class="input__group full__width">
                        <label for="description" class="label">
                            <p>{{ __('admin.description') }}</p>
                        </label>
                        <textarea name="description" id="description" cols="20" rows="5">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Status -->
                <div class="form__group">
                    <div class="switch__container">
                        <label class="switch">
                            <input type="checkbox" name="publish" id="publish" checked>
                            <span class="slider round"></span>
                        </label>
                        <p>{{ __('admin.publish_category') }}</p>
                    </div>
                </div>

                <div class="create__submit__container">
                    <input type="submit" value="{{ __('admin.save') }}" class="create__category__btn">
                </div>

            </form>
        </div>

    </div>

@endsection





