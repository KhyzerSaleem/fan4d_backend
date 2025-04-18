
<!-- Modal -->
<div class="modal fade zoomIn deleteRecordModal" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="deleteRecordForm" method="post" action="{{ isset($deleteRoute) ? $deleteRoute : '#' }}">
            @method('DELETE')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="btn-close deleteRecord-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                   colors="primary:#f7b84b,secondary:#f06548"
                                   style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>@lang('translation.Are you sure ?')</h4>
                            <p class="text-muted mx-4 mb-0">@lang('translation.Are you sure you want to remove this record ?')</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="submit" class="btn w-sm btn-danger " id="delete-record">
                            @lang('translation.Yes, Delete It!')
                        </button>
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            @lang('translation.Close')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end modal -->

<div class="modal fade zoomIn deleteMultiRecordModal" id="deleteMultiRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="deleteMultiRecordForm" method="post" action="{{ isset($deleteMultiRoute) ? $deleteMultiRoute : '#' }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="btn-close deleteRecord-close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="ids_input" name="ids">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                   colors="primary:#f7b84b,secondary:#f06548"
                                   style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>@lang('translation.Are you sure ?')</h4>
                            <p class="text-muted mx-4 mb-0">@lang('translation.Are you sure you want to remove selected records ?')</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="submit" class="btn w-sm btn-danger " id="delete-record">
                            @lang('translation.Yes, Delete It!')
                        </button>
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            @lang('translation.Close')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade zoomIn changeStatusMultiRecordModal" id="changeStatusMultiRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="changeStatusMultiRecordForm" method="post" action="{{ isset($changeStatusMultiRoute) ? $changeStatusMultiRoute : '#' }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="btn-close statusRecord-close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="ids_input" name="ids">
                    <div class="mt-2 text-center">
{{--                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"--}}
{{--                                   colors="primary:#0ab39c,secondary:#405189"--}}
{{--                                   style="width:100px;height:100px"></lord-icon>--}}
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="input-group-showcode" class="form-label text-muted">
                                    @lang('is_active')
                                </label>
                                <input class="form-check-input" name="is_active" value="1" checked type="checkbox" id="input-group-showcode">
                            </div>
                        </div>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>@lang('Are you sure ?')</h4>
                            <p class="text-muted mx-4 mb-0">@lang('Are you sure you want to change status selected records ?')</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="submit" class="btn w-sm btn-success " id="change-status-record">
                            @lang('Yes, Do It!')
                        </button>
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            @lang('Close')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade zoomIn generateGroupsModal" id="generateGroupsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="generateGroupsForm" method="post" action="{{ isset($generateGroupsRoute) ? $generateGroupsRoute : '#' }}">
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="btn-close generateGroups-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                   colors="primary:#0ab39c,secondary:#405189"
                                   style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>@lang('Are you sure ?')</h4>
                            <p class="text-muted mx-4 mb-0">@lang('Are you sure you want to generate groups ?')</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="submit" class="btn w-sm btn-success " id="generate-group">
                            @lang('Yes, Do It!')
                        </button>
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            @lang('Close')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end modal -->
