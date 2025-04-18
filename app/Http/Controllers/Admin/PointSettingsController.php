<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\PointSetting;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PointSettingsController extends Controller
{
    public function index()
    {
        return view('point_settings.list', [
            'columns' => $this->columns()
        ]);
    }

    public function create()
    {
        $data['reward_money'] = Setting::where('key', 'reward_money')->first()->value;
        $data['reward_points'] = Setting::where('key', 'reward_points')->first()->value;
        $data['order_money'] = Setting::where('key', 'order_money')->first()->value;
        $data['order_points'] = Setting::where('key', 'order_points')->first()->value;
        return view('point_settings.create', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_money' => 'required|numeric|min:0',
            'order_points' => 'required|numeric|min:0',
            'reward_money' => 'required|numeric|min:0',
            'reward_points' => 'required|numeric|min:0',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        Setting::where('key', 'order_money')->update([
            'value' => $request->order_money,
        ]);
        Setting::where('key', 'order_points')->update([
            'value' => $request->order_points,
        ]);
        Setting::where('key', 'reward_points')->update([
            'value' => $request->reward_points,
        ]);
        Setting::where('key', 'reward_money')->update([
            'value' => $request->reward_money,
        ]);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $category = PointSetting::findOrFail($id);
        return view('point_settings.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|min:3',
            'points' => 'required|numeric|min:0',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $PointSetting = PointSetting::findOrFail($id);

        $PointSetting->update([
            'description' => $request->description,
            'points' => $request->points,
        ]);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->route('point_settings.index');
    }

    public function destroy($id)
    {
        try {
            $PointSetting = PointSetting::findOrFail($id);
            $PointSetting->delete();
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
                'ids.*' => 'required|integer|exists:point_settings,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            PointSetting::whereIn('id', $ids)->delete();

        } catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function bulkChangeStatus(Request $request)
    {
        try {
            $ids = explode(',', $request->ids);
            $validator = Validator::make(['ids' => $ids], [
                'ids' => 'required|array',
                'ids.*' => 'required|integer|exists:point_settings,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            PointSetting::whereIn('id', $ids)->update([
                'is_active' => $request->is_active ?? 0
            ]);

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
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('Edit') . '">
                        <a href="' . route('point_settings.edit', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
                            <i class="ri-pencil-fill fs-16"></i>
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
            ->rawColumns(['select', 'image', 'action'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request)
    {
        $point_settingsQuery = PointSetting::query()
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('title_ar', 'like', "%$searchKey%")
                        ->orWhere('title_en', 'like', "%$searchKey%");
                });
            })
            ->when($request->has('from_date') && $request->filled('from_date'), function ($query) use ($request) {
                $query->where('created_at', '>=', $request->from_date);
            })
            ->when($request->has('to_date') && $request->filled('to_date'), function ($query) use ($request) {
                $query->where('created_at', '<=', $request->to_date);
            })
            ->when($request->has('status') && $request->filled('status'), function ($query) use ($request) {
                if (in_array($request->status, [0, 1])) {
                    $query->where('is_active', $request->status);
                }
            });

        return $point_settingsQuery;
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:point_settings,id',
            'is_active' => 'required|in:0,1',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $PointSetting = PointSetting::findOrFail($request->id);
        $PointSetting->is_active = $request->is_active;
        $PointSetting->save();
        return response()->json(['success' => __('Operation Done Successfully')]);
    }

    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'key', 'name' => 'key' . App::getLocale(), 'label' => 'المفتاح'],
            ['data' => 'description', 'name' => 'description' . App::getLocale(), 'label' => 'الوصف'],
            ['data' => 'points', 'name' => 'points' . App::getLocale(), 'label' => 'النقاط'],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }
}
