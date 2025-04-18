@component('components.crud.list')
    @slot('title')
        @lang('plans')
    @endslot
    @slot('list')
        @lang('plans List')
    @endslot
    @slot('add_new')
        @lang('Add plan')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('plans.data'))
    @slot('createRoute', route('plans.create'))
    @slot('deleteRoute', route('plans.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('plans.bulkDelete'))
    @slot('changeStatusMultiRoute', route('plans.bulkChangeStatus'))
    @slot('changeStatusRoute', route('plans.changeStatus'))
@endcomponent
