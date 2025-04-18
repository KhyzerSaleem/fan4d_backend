@component('components.crud.list')
    @slot('title')
        @lang('Services')
    @endslot
    @slot('list')
        @lang('Services List')
    @endslot
    @slot('add_new')
        @lang('Add Service')
    @endslot
    @slot('search_keys')
        @lang('Title'), @lang('Description')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('services.data'))
    @slot('createRoute', route('services.create'))
    @slot('deleteRoute', route('services.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('services.bulkDelete'))
    @slot('changeStatusRoute', route('services.changeStatus'))
{{--    @slot('changeShowOnAppRoute', route('services.changeShowOnApp'))--}}
@endcomponent
