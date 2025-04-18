@component('components.crud.list')
    @slot('title')
        @lang('foods')
    @endslot
    @slot('list')
        @lang('foods List')
    @endslot
    @slot('add_new')
        @lang('Add food')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('foods.data'))
    @slot('createRoute', route('foods.create'))
    @slot('deleteRoute', route('foods.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('foods.bulkDelete'))
    @slot('changeStatusMultiRoute', route('foods.bulkChangeStatus'))
    @slot('changeStatusRoute', route('foods.changeStatus'))
@endcomponent
