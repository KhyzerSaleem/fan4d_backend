@component('components.crud.list')
    @slot('title')
        @lang('attributes')
    @endslot
    @slot('list')
        @lang('attributes List')
    @endslot
    @slot('add_new')
        @lang('Add attribute')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('attributes.data'))
    @slot('createRoute', route('attributes.create'))
    @slot('deleteRoute', route('attributes.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('attributes.bulkDelete'))
    @slot('changeStatusMultiRoute', route('attributes.bulkChangeStatus'))
    @slot('changeStatusRoute', route('attributes.changeStatus'))
@endcomponent
