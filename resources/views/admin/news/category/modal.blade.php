<div id="modal" class="category__modal">

    <div class="modal__content">
        <div class="modal__header">
            <p class="modal__title"></p>
            <span class="close" onclick="closeModal('modal')">&times;</span>
        </div>
        <div class="modal__body">

            <div class="lang__tab__switcher">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <button
                        class="lang__tab{{ LaravelLocalization::getCurrentLocale() === $localeCode ? ' active' : '' }}"
                        data-lang-selector="{{ $localeCode }}">{{ $properties['native'] }}</button>
                @endforeach
            </div>

            <form>
                @csrf

                <div class="form__group">
                    <div class="input__group">
                        <label for="name" class="label">
                            <p>{{ __('admin.name') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>

                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <input type="text" id="name_{{ $localeCode }}" name="name[{{ $localeCode }}]"
                                   data-lang="{{ $localeCode }}">
                        @endforeach

                        <div class="input__error"></div>

                    </div>
                    <div class="input__group">
                        <label for="slug" class="label">
                            <p>{{ __('admin.slug') }}</p>
                            <span><i class="fa-solid fa-snowflake"></i></span>
                        </label>
                        <input readonly type="text" id="slug" name="slug">
                        <div class="input__error"></div>
                    </div>
                </div>

                <div class="form__group">
                    <div class="input__group__full">
                        <label for="description" class="label">
                            <p>{{ __('admin.description') }}</p>
                        </label>
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <textarea name="description[{{ $localeCode }}]" id="description"
                                      data-lang="{{ $localeCode }}" cols="20" rows="5"></textarea>
                        @endforeach

                        <div class="input__error"></div>
                    </div>
                </div>

                <div class="form__group">
                    <div class="switch__container">
                        <label class="switch">
                            <input type="checkbox" name="publish" id="publish" checked>
                            <span class="slider round"></span>
                        </label>
                        <p>{{ __('admin.publish_category') }}</p>
                    </div>
                </div>


                <div class="form__buttons">
                    <input class="modal__btn" type="submit">
                </div>


            </form>

        </div>
    </div>

</div>


<script>

    function openModal(modalId, action, categoryId = null) {
        const modal = document.getElementById(modalId);
        const form = modal.querySelector('form');

        if (action === 'create') {

            clearModal();

            form.action = '{{ route('create_category') }}';
            form.method = 'post';
            form.setAttribute('name', 'create');
            form.setAttribute('id', 'category_create_form');

            modal.querySelector('.modal__title').textContent = '{{ __('admin.create_category') }}';
            modal.querySelector('.modal__btn').value = '{{ __('admin.create') }}';

            createCategory();

        } else if (action === 'edit') {

            form.action = 'category/' + categoryId;
            form.method = 'PUT';
            form.setAttribute('name', 'edit');
            form.setAttribute('id', 'category_edit_form');

            modal.querySelector('.modal__title').textContent = '{{ __('admin.edit_category') }}';
            modal.querySelector('.modal__btn').value = '{{ __('admin.edit') }}';

            $.ajax({
                url: 'category/' + categoryId + '/edit',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response) {

                        Object.keys(response).forEach(function (key) {
                            const langData = response[key][0];

                            document.querySelector(`#name_${langData.locale}`).value = langData.name;
                            document.querySelector(`[name="description[${langData.locale}]"]`).value = langData.description;
                        });

                        form.querySelector('#slug').value = response.ka[0].slug;
                        form.querySelector('#publish').checked = response.ka[0].publish === 1;

                    }
                },
                error: function (response) {

                }
            });

            editCategory(categoryId);

        }


        modal.style.display = "flex";
    }

</script>


