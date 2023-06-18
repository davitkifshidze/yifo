<div id="create__author" class="author__modal">

    <div class="modal__content">
        <div class="modal__header">
            <p class="modal__title">{{ __('admin.create_author') }}</p>
            <span class="create__close" onclick="closeModal('create__author')">&times;</span>
        </div>
        <div class="modal__body">

            <form action="" method="post">

                <div class="form__group">
                    <div class="input__group">
                        <label for="name" class="label">
                            <p>{{ __('admin.name') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div class="input__group">
                        <label for="slug" class="label">
                            <p>{{ __('admin.slug') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input type="text" id="slug" name="slug">
                    </div>
                </div>

                <div class="form__group">
                    <div class="input__group__full">
                        <label for="description" class="label">
                            <p>{{ __('admin.description') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <textarea name="description" id="description" cols="20" rows="5"></textarea>
                    </div>
                </div>

                <div class="form__group">
                    <div class="input__group">
                        <label for="email" class="label">
                            <p>{{ __('admin.email') }}</p>
                        </label>
                        <input type="text" id="email" name="email">
                    </div>
                    <div class="input__group">
                        <label for="facebook" class="label">
                            <p>{{ __('admin.facebook') }}</p>
                        </label>
                        <input type="text" id="facebook" name="facebook">
                    </div>
                </div>

                <div class="form__group">
                    <div class="switch__container">
                        <label class="switch">
                            <input type="checkbox" name="publish" id="publish" checked>
                            <span class="slider round"></span>
                        </label>
                        <p>{{ __('admin.publish_author') }}</p>
                    </div>
                </div>


                <div class="form__buttons">
                    <input class="modal__btn" type="submit" name="create" value="{{ __('admin.create') }}">
                    <p></p>
                </div>


            </form>

        </div>
    </div>

</div>
