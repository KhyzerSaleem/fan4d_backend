@component('components.crud.list')
    @slot('title')
        @lang('Categories')
    @endslot
    @slot('list')
        @lang('Categories List')
    @endslot
    @slot('add_new')
        @lang('Add Category')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('categories.data'))
    @slot('createRoute', route('categories.create'))
    @slot('deleteRoute', route('categories.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('categories.bulkDelete'))
    @slot('changeStatusMultiRoute', route('categories.bulkChangeStatus'))
@endcomponent
