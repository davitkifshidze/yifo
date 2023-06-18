@extends('admin.layouts.main_template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/news/author/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/news/author/modal.css') }}">
@endsection

@section('script')
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('js/admin/news/author/modal.js') }}"></script>
@endsection

@section('content')

    <div class="author">

        <div class="page__header">
            <div class="page__title">
                <p>
                    {{ __('admin.author') }}
                </p>
            </div>
            <div class="new__author">
                <a href="javascript:void(0)" onclick="openModal('create__author')">{{ __('admin.new_author') }}</a>
            </div>
        </div>

        <div class="author__table__container">
            <div class="author__header">
                <div class="search__author">
                    <form action="search" class="search__form" method="get">
                        <input class="search__input" type="text" placeholder="{{ __('admin.search') }}">

                        <button type="submit" class="search__icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="table__container">
                <table class="author__table">
                    <thead>
                    <tr class="table__head">
                        <th>
                            <input class="author__checkbox" type="checkbox" name="all__author" value="author">
                        </th>
                        <th>{{ __('admin.name') }}</th>
                        <th>{{ __('admin.slug') }}</th>
                        <th>{{ __('admin.visibility') }}</th>
                        <th>{{ __('admin.email') }}</th>
                        <th>{{ __('admin.last_update') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table__body">
                    <tr>
                        <td>
                            <input class="author__checkbox" type="checkbox" name="select__author" value="author">
                        </td>
                        <td class="tbody__td">dato Kifshidze</td>
                        <td class="tbody__td">dato-kifshidze</td>
                        <td>
                            <p class="author__status">
                                <i class="fa-regular fa-circle-xmark dismiss"></i>
                            </p>
                        </td>
                        <td class="tbody__td">datokifshidze@gmail.com</td>
                        <td class="tbody__td">Sep 19, 2024</td>
                        <td>
                            <a href="javascript:void(0)" class="edit__link"  onclick="openModal('edit__author')">
                                <i class="pen__icon fa-solid fa-pen"></i>
                                <p>{{ __('admin.edit') }}</p>
                            </a>
                        </td>
                        <td>
                            <a href="" class="delete__link">
                                <i class="delete__icon fa-solid fa-trash-can"></i>
                                <p>{{ __('admin.delete') }}</p>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="author__checkbox" type="checkbox" name="select__author" value="author">
                        </td>
                        <td class="tbody__td">Davit Kifshidze</td>
                        <td class="tbody__td">davit-kifshidze</td>
                        <td>
                            <p class="author__status">
                                <i class="fa-regular fa-circle-check approve"></i>
                            </p>
                        </td>
                        <td class="tbody__td">davitkifshidze@gmail.com</td>
                        <td class="tbody__td">Sep 19, 2024</td>
                        <td>
                            <a href="javascript:void(0)" class="edit__link" onclick="openModal('edit__author')">
                                <i class="pen__icon fa-solid fa-pen"></i>
                                <p>{{ __('admin.edit') }}</p>
                            </a>
                        </td>
                        <td>
                            <a href="" class="delete__link">
                                <i class="delete__icon fa-solid fa-trash-can"></i>
                                <p>{{ __('admin.delete') }}</p>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @include('admin.news.author.create')
    @include('admin.news.author.edit')

@endsection





