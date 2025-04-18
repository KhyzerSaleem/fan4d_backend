<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ContactsController extends Controller
{
    public function index()
    {
        return view('contacts.list', [
            'columns' => $this->columns()
        ]);
    }

    public function edit($id)
    {
        $data = Contact::findOrFail($id);
        $data->seen_at = Carbon::now();
        $data->save();
        return view('contacts.edit', compact('data'));
    }

    public function destroy($id)
    {
        try {
            $Contact = Contact::findOrFail($id);
            $Contact->delete();
        } catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }


        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = explode(',', $request->ids);
            $validator = Validator::make(['ids' => $ids], [
                'ids' => 'required|array',
                'ids.*' => 'required|integer|exists:contacts,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator->validated());
            }
            Contact::whereIn('id', $ids)->delete();

        } catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function getData(Request $request)
    {
        return DataTables::eloquent($this->filter($request))
            ->addIndexColumn()
            ->addColumn('select', function ($row) {
                return '
                    <th scope="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="selectedItems[]" value="' . $row->id . '">
                        </div>
                    </th>
                ';
            })

            ->addColumn('action', function ($row) {
                $actionButtons = '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('Edit') . '">
                        <a href="' . route('contacts.edit', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
                            <i class="ri-eye-fill fs-16"></i>
                        </a>
                    </li>
                ';
                $actionButtons .= '
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('Remove') . '">
                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-model-id="' . $row->id . '" href="#deleteRecordModal">
                                <i class="ri-delete-bin-5-fill fs-16"></i>
                            </a>
                        </li>
                    ';
                return '
                    <ul class="list-inline hstack gap-2 mb-0">
                        ' . $actionButtons . '
                    </ul>
                ';
            })

            ->editColumn('seen_at', function ($row) {
                return $row->seen_at?->translatedformat('Y-m-d g:i a');
            })
            ->rawColumns(['select', 'action'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request)
    {
        $contactsQuery = Contact::query()->orderBy('id','desc')
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('code', 'like', "%$searchKey%");
                });
            })
            ->when($request->has('from_date') && $request->filled('from_date'), function ($query) use ($request) {
                $query->where('start_date', '>=', $request->from_date);
            })
            ->when($request->has('to_date') && $request->filled('to_date'), function ($query) use ($request) {
                $query->where('expire_date', '<=', $request->to_date);
            })
            ->when($request->has('status') && $request->filled('status'), function ($query) use ($request) {
                if (in_array($request->status, [0, 1])) {
                    $query->where('is_active', $request->status);
                }
            });

        return $contactsQuery;
    }


    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'first_name', 'name' => 'first_name', 'label' => 'الاسم'],
            ['data' => 'email', 'name' => 'email', 'label' => 'البريد الإلكتروني'],
            ['data' => 'subject', 'name' => 'subject', 'label' => 'الموضوع'],
            ['data' => 'seen_at', 'name' => 'seen_at', 'label' => 'شوهد في'],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }
}
