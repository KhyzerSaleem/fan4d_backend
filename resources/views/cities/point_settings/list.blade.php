@component('components.crud.list')
    @slot('title')
        إعدادات النقاط
    @endslot
    @slot('list')
        قائمة إعدادات النقاط
    @endslot
    @slot('add_new')
        اعدادات تحويل النقاط الى مبلغ للاستخدام
    @endslot
{{--    @slot('search_keys')--}}
{{--        @lang('Title')--}}
{{--    @endslot--}}
    @slot('columns', $columns)
    @slot('getDataRoute', route('point_settings.data'))
    @slot('createRoute', route('point_settings.create'))
{{--    @slot('deleteRoute', route('point_settings.destroy', ':modelId'))--}}
{{--    @slot('deleteMultiRoute', route('point_settings.bulkDelete'))--}}
{{--    @slot('changeStatusMultiRoute', route('point_settings.bulkChangeStatus'))--}}
{{--    @slot('changeStatusRoute', route('point_settings.changeStatus'))--}}
@endcomponent
