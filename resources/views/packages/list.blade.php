@component('components.crud.list')
    @slot('title')
        @lang('packages')
    @endslot
    @slot('list')
        @lang('packages List')
    @endslot
{{--    @slot('add_new')--}}
{{--        @lang('Add package')--}}
{{--    @endslot--}}
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('packages.data'))
    @slot('createRoute', route('packages.create'))
    @slot('deleteRoute', route('packages.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('packages.bulkDelete'))
    @slot('changeStatusMultiRoute', route('packages.bulkChangeStatus'))
    @slot('changeStatusRoute', route('packages.changeStatus'))
@endcomponent
