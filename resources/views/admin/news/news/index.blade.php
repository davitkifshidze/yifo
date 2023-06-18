@extends('admin.layouts.main_template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/news/news/index.css') }}">

@endsection

@section('script')
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('js/admin/news/news/index.js') }}"></script>
@endsection

@section('content')

    <div class="post">
        <div class="post__title__container">
            <p class="post__title">
                {{ __('admin.news') }}
            </p>

            <div class="new__post__btn__container">
                <a href="{{ route('news_create') }}">
                    {{ __('admin.new_news') }}
                </a>
            </div>
        </div>
        <div class="post__table__container">
            <div class="post__table__header">
                <div class="search__post__container">
                    <form action="searhch" method="get" class="search__post__form">
                        <input class="post__search__input" type="text" placeholder="{{ __('admin.search') }}">

                        <button type="submit" class="post__search__icon__btn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
                <div class="select__category__container">
                    <form action="">

                        <div>
                            <div style="height:100%">
                                <label class="post__category__label">
                                    <input mbsc-input id="post__category__input"
                                           placeholder="{{ __('admin.select_category') }}..." data-dropdown="true"
                                           data-input-style="outline" data-label-style="stacked"
                                           data-tags="true"/>
                                </label>
                                <select id="post__category__select" multiple>
                                    <option value="1">Books</option>
                                    <option value="2">Movies</option>
                                    <option value="4">Garden</option>
                                    <option value="6">Toys</option>
                                    <option value="7">Beauty</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="date__picker__container">
                    <input type="text" name="date_range" value="01/01/2018 - 01/15/2018"/>
                </div>
            </div>
            <div class="posts__table__container">
                <table class="posts__table">
                    <thead>
                    <tr class="table__head__row">
                        <th>
                            <input class="post__checkbox" type="checkbox" name="all__post" value="post">
                        </th>
                        <th>{{ __('admin.image') }}</th>
                        <th>{{ __('admin.title') }}</th>
                        <th>{{ __('admin.author') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th>{{ __('admin.publish_date') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table__body__row">
                    <tr>
                        <td>
                            <input class="post__checkbox" type="checkbox" name="select__post" value="post">
                        </td>
                        <td>
                            <img class="post__table__image" src="assets/images/logo/y_logo_purple.png" alt="">
                        </td>
                        <td class="post__table__content">The Power of Positive Thinking</td>
                        <td class="post__table__content">Arminda Pnel</td>
                        <td>
                            <p class="post__table__status__draft">
                                {{ __('admin.pending') }}
                            </p>
                        </td>
                        <td class="post__table__content">Sep 19, 2024</td>
                        <td>
                            <a href="" class="post__table__edit__link">
                                <i class="edit__pen__icon fa-solid fa-pen"></i>
                                <p>{{ __('admin.edit') }}</p>
                            </a>
                        </td>
                        <td>
                            <a href="" class="post__table__delete__link">
                                <i class="delete__trash__icon fa-solid fa-trash-can"></i>
                                <p>{{ __('admin.delete') }}</p>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="post__checkbox" type="checkbox" name="select__post" value="post">
                        </td>
                        <td>
                            <img class="post__table__image" src="assets/images/logo/y_logo_green.png" alt="">
                        </td>
                        <td class="post__table__content">Overcoming Procrastination</td>
                        <td class="post__table__content">Jane Toks</td>
                        <td>
                            <p class="post__table__status__publish">
                                {{ __('admin.publish') }}
                            </p>
                        </td>
                        <td class="post__table__content">Nov 3, 2022</td>
                        <td>
                            <a href="" class="post__table__edit__link">
                                <i class="edit__pen__icon fa-solid fa-pen"></i>
                                <p>{{ __('admin.edit') }}</p>
                            </a>
                        </td>
                        <td>
                            <a href="" class="post__table__delete__link">
                                <i class="delete__trash__icon fa-solid fa-trash-can"></i>
                                <p>{{ __('admin.delete') }}</p>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="post__checkbox" type="checkbox" name="select__post" value="post">
                        </td>
                        <td>
                            <img class="post__table__image" src="assets/images/logo/y_logo_purple.png" alt="">
                        </td>
                        <td class="post__table__content">The Power of Positive Thinking</td>
                        <td class="post__table__content">Arminda Pnel</td>
                        <td>
                            <p class="post__table__status__draft">
                                {{ __('admin.pending') }}
                            </p>
                        </td>
                        <td class="post__table__content">Sep 19, 2024</td>
                        <td>
                            <a href="" class="post__table__edit__link">
                                <i class="edit__pen__icon fa-solid fa-pen"></i>
                                <p>{{ __('admin.edit') }}</p>
                            </a>
                        </td>
                        <td>
                            <a href="" class="post__table__delete__link">
                                <i class="delete__trash__icon fa-solid fa-trash-can"></i>
                                <p>{{ __('admin.delete') }}</p>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="post__checkbox" type="checkbox" name="select__post" value="post">
                        </td>
                        <td>
                            <img class="post__table__image" src="assets/images/logo/y_logo_gray.png" alt="">
                        </td>
                        <td class="post__table__content">10 Tips for Productive Remote Work</td>
                        <td class="post__table__content">Arminda Pnel</td>
                        <td>
                            <p class="post__table__status__publish">
                                {{ __('admin.publish') }}
                            </p>
                        </td>
                        <td class="post__table__content">Jun 8, 2021</td>
                        <td>
                            <a href="" class="post__table__edit__link">
                                <i class="edit__pen__icon fa-solid fa-pen"></i>
                                <p>{{ __('admin.edit') }}</p>
                            </a>
                        </td>
                        <td>
                            <a href="" class="post__table__delete__link">
                                <i class="delete__trash__icon fa-solid fa-trash-can"></i>
                                <p>{{ __('admin.delete') }}</p>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="post__checkbox" type="checkbox" name="select__post" value="post">
                        </td>
                        <td>
                            <img class="post__table__image" src="assets/images/logo/y_logo_purple.png" alt="">
                        </td>
                        <td class="post__table__content">The Benefits of Mindfulness Meditation</td>
                        <td class="post__table__content">Pemon Clark</td>
                        <td>
                            <p class="post__table__status__publish">
                                {{ __('admin.publish') }}
                            </p>
                        </td>
                        <td class="post__table__content">Jan 21, 2019</td>
                        <td>
                            <a href="" class="post__table__edit__link">
                                <i class="edit__pen__icon fa-solid fa-pen"></i>
                                <p>{{ __('admin.edit') }}</p>
                            </a>
                        </td>
                        <td>
                            <a href="" class="post__table__delete__link">
                                <i class="delete__trash__icon fa-solid fa-trash-can"></i>
                                <p>{{ __('admin.delete') }}</p>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection




