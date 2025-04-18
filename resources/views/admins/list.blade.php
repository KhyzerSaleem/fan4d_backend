@component('components.crud.list')
    @slot('title')
        @lang('translation.Admins')
    @endslot
    @slot('list')
        @lang('translation.Admins List')
    @endslot
    @slot('add_new')
        @lang('translation.Add Admin')
    @endslot
    @slot('search_keys')
        @lang('translation.User Name')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('admins.data'))
    @slot('createRoute', route('admins.create'))
    @slot('deleteRoute', route('admins.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('admins.bulkDelete'))
    @slot('changeStatusRoute', route('admins.changeStatus'))
@endcomponent
