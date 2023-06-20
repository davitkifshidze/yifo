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


    @if(session('update') === 'success')
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'კატეგორია წარმატებით განახლდა'
            })
        </script>
    @endif

    <div class="category__edit">
        <div class="title__container">
            <p class="edit__title">
                {{ __('admin.edit_category') }}
            </p>
        </div>

        <div class="edit__category__container">
            <form action="{{ route('update_category', $category->id) }}" class="edit__form" method="POST">

                @csrf
                @method('PUT')

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
                        <input type="text" name="name" id="name" value="{{ $category->name }}">
                    </div>

                    <div class="input__group">
                        <label for="slug" class="label">
                            <p>{{ __('admin.slug') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>

                        <div class="input__group__line">
                            <input readonly class="tag__input readonly__input" type="text" name="slug" id="slug"  value="{{ $category->slug }}">

                            <span id="generate__slug" class="generate__slug">
                                <i class="fa-regular fa-pen-to-square generate__slug__icon"></i>
                            </span>
                        </div>

                    </div>
                </div>

                <div class="form__group">
                    <div class="input__group full__width">
                        <label for="description" class="label">
                            <p>{{ __('admin.description') }}</p>
                        </label>
                        <textarea name="description" id="description" cols="20" rows="5">{{ $category->description }}</textarea>
                    </div>
                </div>

                <!-- Status -->
                <div class="form__group">
                    <div class="switch__container">
                        <label class="switch">
                            <input type="checkbox" name="publish" id="publish" {{ $category->publish == 1 ? 'checked' : '' }} >
                            <span class="slider round"></span>
                        </label>
                        <p>{{ __('admin.publish_category') }}</p>
                    </div>
                </div>

                <div class="edit__submit__container">
                    <input type="submit" value="{{ __('admin.edit') }}" class="edit__category__btn">

                    <a href="{{ route('category_list') }}" class="cancel__post__btn">
                        {{ __('admin.cancel') }}
                    </a>

                </div>


            </form>
        </div>

    </div>

@endsection







