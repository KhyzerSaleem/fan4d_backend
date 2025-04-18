@component('components.crud.list')
    @slot('title')
        @lang('translation.Roles & Permissions')
    @endslot
    @slot('list')
        @lang('translation.Roles List')
    @endslot
    @slot('add_new')
        @lang('translation.Add Role')
    @endslot
    @slot('search_keys')
        @lang('translation.Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('roles.data'))
    @slot('createRoute', route('roles.create'))
    @slot('deleteRoute', route('roles.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('roles.bulkDelete'))
    @slot('changeStatusRoute', route('roles.changeStatus'))
@endcomponent
