@component('components.crud.list')
    @slot('title')
        @lang('branches')
    @endslot
    @slot('list')
        @lang('branches List')
    @endslot
    @slot('add_new')
        @lang('Add branch')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('branches.data'))
    @slot('createRoute', route('branches.create'))
    @slot('deleteRoute', route('branches.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('branches.bulkDelete'))
    @slot('changeStatusMultiRoute', route('branches.bulkChangeStatus'))
    @slot('changeStatusRoute', route('branches.changeStatus'))
@endcomponent
