@component('components.crud.list')
    @slot('title')
        @lang('Production Years')
    @endslot
    @slot('list')
        @lang('Production Years List')
    @endslot
    @slot('add_new')
        @lang('Add ProductionYear')
    @endslot
    @slot('search_keys')
        @lang('Production Year'), @lang('Modell')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('productionYears.data'))
    @slot('createRoute', route('productionYears.create'))
    @slot('deleteRoute', route('productionYears.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('productionYears.bulkDelete'))
    @slot('changeStatusRoute', route('productionYears.changeStatus'))
@endcomponent
