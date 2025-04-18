@component('components.crud.list')
    @slot('title')
        @lang('Sliders')
    @endslot
    @slot('list')
        @lang('Sliders List')
    @endslot
    @slot('add_new')
        @lang('Add Slider')
    @endslot
    @slot('search_keys')
        @lang('title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('sliders.data'))
    @slot('createRoute', route('sliders.create'))
    @slot('deleteRoute', route('sliders.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('sliders.bulkDelete'))
    @slot('changeStatusRoute', route('sliders.changeStatus'))
@endcomponent
