@component('components.crud.list')
    @slot('title')
        @lang('areas')
    @endslot
    @slot('list')
        @lang('areas List')
    @endslot
    @slot('add_new')
        @lang('Add areas')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('areas.data',$id))
    @slot('createRoute', route('areas.create',$id)))
    @slot('deleteRoute', route('areas.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('areas.bulkDelete'))
    @slot('changeStatusMultiRoute', route('areas.bulkChangeStatus'))
    @slot('changeStatusRoute', route('areas.changeStatus'))
@endcomponent
