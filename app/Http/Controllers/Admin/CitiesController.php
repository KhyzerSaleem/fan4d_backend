<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CitiesController extends Controller
{
    public function index()
    {
        return view('cities.list', [
            'columns' => $this->columns()
        ]);
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required|min:3',
            'title_en' => 'required|min:3',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        City::create([
            'title_ar' => $request->title_ar,
            'title_en' =>$request->title_en,
            'is_active' => $request->has('is_active'),
        ]);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $category = City::findOrFail($id);
        return view('cities.edit',compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required|min:3',
            'title_en' => 'required|min:3',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $category = City::findOrFail($id);

        $category->update([
            'title_ar' => $request->title_ar,
            'title_en' =>$request->title_en,
            'is_active' => $request->has('is_active'),
        ]);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->route('cities.index');
    }

    public function destroy($id)
    {
        try {
            $category = City::findOrFail($id);
            $category->delete();
        }catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }


        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = explode(',',$request->ids);
            $validator = Validator::make(['ids' => $ids], [
                'ids' => 'required|array',
                'ids.*' => 'required|integer|exists:cities,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator->validated());
            }
            City::whereIn('id',$ids)->delete();

        }catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function bulkChangeStatus(Request $request)
    {
        try {
            $ids = explode(',',$request->ids);
            $validator = Validator::make(['ids' => $ids], [
                'ids' => 'required|array',
                'ids.*' => 'required|integer|exists:cities,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator->validated());
            }
            City::whereIn('id',$ids)->update([
                'is_active' => $request->is_active ?? 0
            ]);

        }catch (\Exception $e) {
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
                            <input class="form-check-input" type="checkbox" name="selectedItems[]" value="'.$row->id.'">
                        </div>
                    </th>
                ';
            })
            ->editColumn('is_active', function ($row) {
                $isChecked = $row->is_active ? 'checked' : '';

                return '
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <input class="form-check-input switch-status" data-id="' . $row->id . '" name="is_active" value="1" type="checkbox" ' . $isChecked . ' id="input-group-showcode">
                    </div>
                ';
            })
            ->addColumn('action', function ($row) {
                $actionButtons = '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="'.__('Edit').'">
                        <a href="'.route('cities.edit',$row->id).'" class="text-primary d-inline-block edit-item-btn">
                            <i class="ri-pencil-fill fs-16"></i>
                        </a>
                    </li>
                ';
                $actionButtons .= '
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="'.__('Remove').'">
                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-model-id="'.$row->id.'" href="#deleteRecordModal">
                                <i class="ri-delete-bin-5-fill fs-16"></i>
                            </a>
                        </li>
                    ';
                return '
                    <ul class="list-inline hstack gap-2 mb-0">
                        ' . $actionButtons . '
                    </ul>
                ';
            }) ->addColumn('areas', function ($row) {
                $actionButtons = '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="'.__('Edit').'">
                        <a href="' . route('areas.index', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
                            <i class="ri-eye-fill fs-16"></i>
                            '.$row->areas->count().'
                        </a>
                    </li>
                ';

                return '
                    <ul class="list-inline hstack gap-2 mb-0">
                        ' . $actionButtons . '
                    </ul>
                ';
            })

            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->toDateString();
            })
            ->rawColumns(['select','image', 'action','areas'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request)
    {
        $citiesQuery = City::query()
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('title_ar', 'like', "%$searchKey%")
                        ->orWhere('title_en', 'like', "%$searchKey%");
                });
            })
            ->when($request->has('from_date') && $request->filled('from_date'), function ($query) use ($request) {
                $query->where('created_at','>=',$request->from_date);
            })
            ->when($request->has('to_date') && $request->filled('to_date'), function ($query) use ($request) {
                $query->where('created_at','<=',$request->to_date);
            })
            ->when($request->has('status') && $request->filled('status'), function ($query) use ($request) {
                if (in_array($request->status,[0,1])) {
                    $query->where('is_active',$request->status);
                }
            });

        return $citiesQuery;
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cities,id',
            'is_active' => 'required|in:0,1',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $category = City::findOrFail($request->id);
        $category->is_active = $request->is_active;
        $category->save();
        return response()->json(['success' => __('Operation Done Successfully')]);
    }

    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'title_' . App::getLocale(), 'name' => 'title_' . App::getLocale(), 'label' => __('Title')],
            ['data' => 'areas' , 'name' => 'areas' , 'label' => 'المناطق'],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }
}
