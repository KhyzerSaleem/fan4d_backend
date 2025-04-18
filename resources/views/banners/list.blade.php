@component('components.crud.list')
    @slot('title')
        @lang('banners')
    @endslot
    @slot('list')
        @lang('banners List')
    @endslot
    @slot('add_new')
        @lang('Add banner')
    @endslot
    @slot('search_keys')
        @lang('title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('banners.data'))
    @slot('createRoute', route('banners.create'))
    @slot('deleteRoute', route('banners.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('banners.bulkDelete'))
    @slot('changeStatusRoute', route('banners.changeStatus'))
@endcomponent
