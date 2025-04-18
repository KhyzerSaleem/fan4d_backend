@component('components.crud.list')
    @slot('title')
        @lang('day_meal_counts')
    @endslot
    @slot('list')
        @lang('day_meal_counts List')
    @endslot
{{--    @slot('add_new')--}}
{{--        @lang('Add day_meal_count')--}}
{{--    @endslot--}}
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('day_meal_counts.data'))
    @slot('createRoute', route('day_meal_counts.create'))
    @slot('deleteRoute', route('day_meal_counts.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('day_meal_counts.bulkDelete'))
    @slot('changeStatusMultiRoute', route('day_meal_counts.bulkChangeStatus'))
    @slot('changeStatusRoute', route('day_meal_counts.changeStatus'))
@endcomponent
