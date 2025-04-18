@component('components.crud.list')
    @slot('title')
        @lang('medical_instructions')
    @endslot
    @slot('list')
        @lang('medical_instructions List')
    @endslot
    @slot('add_new')
        @lang('Add medical_instructions')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('medical_instructions.data'))
    @slot('createRoute', route('medical_instructions.create'))
    @slot('deleteRoute', route('medical_instructions.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('medical_instructions.bulkDelete'))
    @slot('changeStatusMultiRoute', route('medical_instructions.bulkChangeStatus'))
    @slot('changeStatusRoute', route('medical_instructions.changeStatus'))
@endcomponent
