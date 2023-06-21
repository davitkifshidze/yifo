@extends('admin.layouts.main_template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/news/category/index.css') }}">

@endsection

@section('script')
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('js/admin/news/category/index.js') }}"></script>
@endsection

@section('content')

    <div class="category">
        <div class="page__header">
            <div class="page__title">
                <p>
                    {{ __('admin.category') }}
                </p>
            </div>
            <div class="new__category">
                <a href="{{ route('create_category') }}">
                    {{ __('admin.new_category') }}
                </a>
            </div>

        </div>
        <div class="category__table__container">
            <div class="category__header">
                <div class="search__category">
                    <form action="search" class="search__form" method="get">
                        <input class="search__input" type="text" placeholder="{{ __('admin.search') }}">

                        <button type="submit" class="search__icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="table__container">
                <table class="category__table">
                    <thead>
                    <tr class="table__head">
                        <th>
                            <input class="category__checkbox" type="checkbox" name="all__category" value="category">
                        </th>
                        <th>{{ __('admin.name') }}</th>
                        <th>{{ __('admin.slug') }}</th>
                        <th>{{ __('admin.visibility') }}</th>
                        <th>{{ __('admin.last_update') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table__body">

                        <?php foreach ($categories as $key => $category): ?>
                        <tr>
                            <td>
                                <input class="category__checkbox" type="checkbox" name="select__category" value="category">
                            </td>
                            <td class="tbody__td">{{ $category->name }}</td>
                            <td class="tbody__td">{{ $category->slug }}</td>
                            <td>
                                <p class="category__status">
                                    <i class="fa-regular {{ $category->publish == 1 ? 'fa-circle-check approve' : 'fa-circle-xmark dismiss' }}"></i>
                                </p>
                            </td>
                            <td class="tbody__td">{{ $category->updated_at }}</td>
                            <td>
                                <a href="category/{{$category->id}}/edit" class="edit__link">
                                    <i class="pen__icon fa-solid fa-pen"></i>
                                    <p>{{ __('admin.edit') }}</p>
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="delete__link" data-id="{{ $category->id }}">
                                    <i class="delete__icon fa-solid fa-trash-can"></i>
                                    <p>{{ __('admin.delete') }}</p>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection
