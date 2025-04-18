@component('components.crud.list')
    @slot('title')
        التواصل معنا
    @endslot
    @slot('list')
        قائمة التواصل معنا
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('contacts.data'))
    @slot('deleteRoute', route('contacts.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('contacts.bulkDelete'))
@endcomponent
