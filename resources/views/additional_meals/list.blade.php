@component('components.crud.list')
    @slot('title')
        @lang('additional_meals')
    @endslot
    @slot('list')
        @lang('additional_meals List')
    @endslot
    @slot('add_new')
        @lang('Add splash')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('additional_meals.data'))
    @slot('createRoute', route('additional_meals.create'))
    @slot('deleteRoute', route('additional_meals.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('additional_meals.bulkDelete'))
    @slot('changeStatusMultiRoute', route('additional_meals.bulkChangeStatus'))
    @slot('changeStatusRoute', route('additional_meals.changeStatus'))
@endcomponent
