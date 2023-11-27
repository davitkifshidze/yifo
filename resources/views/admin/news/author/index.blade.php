@extends('admin.layouts.main_template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/news/author/index.css') }}">
@endsection

@section('translate')
    <script>
        let delete_author = '{{ __('admin.delete_author') }}';
        let confirm_author_delete = '{{ __('admin.confirm_author_delete') }}';
    </script>
@endsection

@section('script')
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('js/admin/news/author/index.js') }}"></script>
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
                <a href="{{ route('create_author') }}">
                    {{ __('admin.new_author') }}
                </a>
            </div>
        </div>

        <div class="author__table__container">

            <div class="author__header">
                <div class="search__author">
                    <form action="{{ route('author_list') }}" class="search__form" method="get">
                        <input name="search" class="search__input" type="text" placeholder="{{ __('admin.search') }}" value="{{ request('search') }}">


                        <button type="submit" class="search__icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                @if($request->has('search') && $request->filled('search'))
                    <a href="{{ route('author_list') }}" class="clear__btn">{{ __('admin.clear') }}</a>
                @endif
            </div>

            @if(!$authors->isEmpty())

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
                            <th>{{ __('admin.description') }}</th>
                            <th>{{ __('admin.last_update') }}</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="table__body">

                        @foreach($authors as $key => $author)

                            <tr>
                                <td>
                                    <input class="author__checkbox" type="checkbox" name="select__author" value="author">
                                </td>
                                <td class="tbody__td">{{ $author->name }}</td>
                                <td class="tbody__td">{{ $author->slug }}</td>
                                <td>
                                    <p class="author__status">
                                        <i class="fa-regular {{ $author->publish == 1 ? 'fa-circle-check approve' : 'fa-circle-xmark dismiss' }}"></i>
                                    </p>
                                </td>
                                <td class="tbody__td">{{ $author->email }}</td>
                                <td class="tbody__td">{{ $author->description }}</td>
                                <td class="tbody__td">{{ $author->updated_at }}</td>
                                <td>
                                    <a href="author/{{ $author->id }}/edit" class="edit__link">
                                        <i class="pen__icon fa-solid fa-pen"></i>
                                        <p>{{ __('admin.edit') }}</p>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="delete__link" data-id="{{ $author->id }}">
                                        <i class="delete__icon fa-solid fa-trash-can"></i>
                                        <p>{{ __('admin.delete') }}</p>
                                    </a>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                    <div>
                        {{ $authors->links('admin.pagination.full') }}
                    </div>

                </div>
            @else
                <div class="empty__container"></div>
            @endif

        </div>



    </div>
@endsection





