@component('components.crud.users_list')
    @slot('title')
        @lang('translation.Users')
    @endslot
    @slot('list')
        @lang('translation.Users List')
    @endslot
    @slot('add_new')
        @lang('Add new user')
    @endslot
    @slot('search_keys')
        @lang('translation.Name'), @lang('translation.Phone')
    @endslot
    @slot('columns', $columns)

    @slot('getDataRoute', route('users.data'))
    @slot('createRoute', route('users.create'))

    @slot('changeStatusRoute', route('users.changeStatus'))
@endcomponent
