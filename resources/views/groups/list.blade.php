@component('components.crud.list')
    @slot('title')
        @lang('Groups')
    @endslot
    @slot('list')
        @lang('Groups List')
    @endslot
    @slot('add_new')
        @lang('Add Group')
    @endslot
    @slot('search_keys')
        @lang('Stock'), @lang('System Id')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('groups.data', $product))
    @slot('changeStatusRoute', route('groups.changeStatus', $product))
@endcomponent
