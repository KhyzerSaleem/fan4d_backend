@component('components.crud.list')
    @slot('title')
        @lang('reviews')
    @endslot
    @slot('list')
        @lang('reviews List')
    @endslot
    @slot('add_new')
        @lang('Add review')
    @endslot
    @slot('search_keys')
        @lang('title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('reviews.data'))
    @slot('createRoute', route('reviews.create'))
    @slot('deleteRoute', route('reviews.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('reviews.bulkDelete'))
    @slot('changeStatusRoute', route('reviews.changeStatus'))
@endcomponent
