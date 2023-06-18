<nav class="sidebar__navigation__container">

    <div class="sidebar__header">
        <div class="shrink__btn">
            <i id="shrink" class="fa-solid fa-bars"></i>
        </div>
        <h3 class="header__title sidebar__logo__title">Yifo</h3>
    </div>

    <div class="sidebar__main__content">
        <ul>
            <li class="sidebar__menu__item">
                <a href="{{ route('dashboard') }}" class="sidebar__menu__link">
                    <i class="sidebar__menu__link__icon fa-solid fa-cubes-stacked"></i>
                    <span class="sidebar__menu__title">{{ __('admin.dashboard') }}</span>
                </a>
            </li>
            <li class="sidebar__menu__item sidebar__menu__item__parent">
                <a href="javascript:void(0)" class="sidebar__menu__link sidebar__menu__link__parent">
                    <i class="sidebar__menu__link__icon fa-solid fa-paste"></i>
                    <span class="sidebar__menu__title">{{ __('admin.news') }}</span>
                    <i class="fa fa-angle-down sidebar__menu__item__parent__arrow"></i>
                </a>
                <ul class="sidebar__submenu">
                    <li class="sidebar__submenu__item">
                        <a href="{{ route('news_list') }}" class="sidebar__submenu__link">
                            <i class="sidebar__submenu__link__icon fa-regular fa-paste"></i>

                            <span class="sidebar__submenu__title">{{ __('admin.news') }}</span>
                        </a>
                    </li>
                    <li class="sidebar__submenu__item">
                        <a href="{{ route('category_list') }}" class="sidebar__submenu__link ">
                            <i class="sidebar__submenu__link__icon fa-solid fa-bars-staggered"></i>
                            <span class="sidebar__submenu__title">{{ __('admin.category') }}</span>
                        </a>
                    </li>
                    <li class="sidebar__submenu__item">
                        <a href="{{ route('author_list') }}" class="sidebar__submenu__link">
                            <i class="sidebar__submenu__link__icon fa-solid fa-user-pen"></i>
                            <span class="sidebar__submenu__title">{{ __('admin.author') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar__menu__item">
                <a href="" class="sidebar__menu__link sidebar__menu__link__active">
                    <i class="sidebar__menu__link__icon fa-solid fa-gears"></i>
                    <span class="sidebar__menu__title">{{ __('admin.setting') }}</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
