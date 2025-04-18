@component('components.crud.list')
    @slot('title')
        @lang('Car Colors')
    @endslot
    @slot('list')
        @lang('Car Colors List')
    @endslot
    @slot('add_new')
        @lang('Add Car Color')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('carColors.data'))
    @slot('createRoute', route('carColors.create'))
    @slot('deleteRoute', route('carColors.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('carColors.bulkDelete'))
    @slot('changeStatusRoute', route('carColors.changeStatus'))
@endcomponent
