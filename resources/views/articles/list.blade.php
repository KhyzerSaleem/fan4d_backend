@component('components.crud.list')
    @slot('title')
        @lang('articles')
    @endslot
    @slot('list')
        @lang('articles List')
    @endslot
    @slot('add_new')
        @lang('Add articles')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('articles.data'))
    @slot('createRoute', route('articles.create'))
    @slot('deleteRoute', route('articles.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('articles.bulkDelete'))
    @slot('changeStatusMultiRoute', route('articles.bulkChangeStatus'))
    @slot('changeStatusRoute', route('articles.changeStatus'))
@endcomponent
