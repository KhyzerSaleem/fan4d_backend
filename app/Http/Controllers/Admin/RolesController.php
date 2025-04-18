<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    public function index()
    {
        return view('roles.list', [
            'columns' => $this->columns()
        ]);
    }

    public function create()
    {
        $permissions = Permission::get()->groupBy('model')->map(function ($item) {
            return $item;
        });

        return view('roles.create',[
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'display_name_ar' => 'required|min:3',
            'display_name_en' => 'required|unique:roles,display_name_en|min:3',

        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $role = Role::create([
            'display_name_ar' => $request->display_name_ar,
            'display_name_en' => $request->display_name_en,
            'name' => str_replace(' ','_',$request->display_name_en)
        ]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        // prevent update super roles
        if ($this->checkSuperRole($role)) {
            session()->flash('error', __('Cannot edit or delete this role.'));
            return redirect()->back();
        }

        $permissions = Permission::all()->groupBy('model')->map(function ($item) {
            return $item;
        });
        return view('roles.edit',[
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $role->permissions()->pluck('id')->toArray()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'display_name_ar' => 'required|min:3',
            'display_name_en' => [
                'required',
                'min:3',
                Rule::unique('roles', 'display_name_en')->ignore($id),
            ],
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $role = Role::findOrFail($id);

        // prevent update super roles
        if ($this->checkSuperRole($role)) {
            session()->flash('error', __('Cannot edit or delete this role.'));
            return redirect()->back();
        }


        $role->update([
            'display_name_ar' => $request->display_name_ar,
            'display_name_en' => $request->display_name_en,
            'name' => str_replace(' ','_',$request->display_name_en)
        ]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        session()->flash('success', __('translation.Operation Done Successfully'));
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);

            // prevent update super roles
            if ($this->checkSuperRole($role)) {
                session()->flash('error', __('translation.Cannot edit or delete this role.'));
                return redirect()->back();
            }

            $role->delete();
        }catch (\Exception $e) {
            session()->flash('error', __('translation.Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }

        session()->flash('success', __('translation.Operation Done Successfully'));
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = explode(',',$request->ids);
            $validator = Validator::make(['ids' => $ids], [
                'ids' => 'required|array',
                'ids.*' => 'required|integer|exists:roles,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator->validated());
            }

            $roles = Role::whereIn('id',$ids)->get();
            $deleteRole = false;
            foreach ($roles as $role) {
                if ($this->checkSuperRole($role)) {
                    $deleteRole = true;
                }
            }
            if ($deleteRole) {
                session()->flash('error', __('Cannot edit or delete this role.'));
                return redirect()->back();
            }
        }catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
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
            ->addColumn('action', function ($row) {
                $actionButtons = '';
                if (!in_array($row->name, ['super_admin', 'delegate'])) {
                    $actionButtons = '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('translation.Edit') . '">
                        <a href="' . route('roles.edit', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
                            <i class="ri-pencil-fill fs-16"></i>
                        </a>
                    </li>
                ';
                    $actionButtons .= '
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('translation.Remove') . '">
                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-model-id="' . $row->id . '" href="#deleteRecordModal">
                                <i class="ri-delete-bin-5-fill fs-16"></i>
                            </a>
                        </li>
                    ';
                }
                return '
                    <ul class="list-inline hstack gap-2 mb-0">
                        ' . $actionButtons . '
                    </ul>
                ';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->toDateString();
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
        $rolesQuery = Role::query()
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('display_name_ar', 'like', "%$searchKey%")
                        ->orWhere('display_name_en', 'like', "%$searchKey%")
                        ->orWhere('name', 'like', "%$searchKey%");
                });
            })
            ->when($request->has('from_date') && $request->filled('from_date'), function ($query) use ($request) {
                $query->where('created_at','>=',$request->from_date);
            })
            ->when($request->has('to_date') && $request->filled('to_date'), function ($query) use ($request) {
                $query->where('created_at','<=',$request->to_date);
            });

        return $rolesQuery;
    }

    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'select', 'name' => 'select', 'orderable' => false, 'searchable' => false],
            ['data' => 'display_name_ar', 'name' => 'display_name_ar', 'label' => __('Title Ar')],
            ['data' => 'display_name_en', 'name' => 'display_name_en', 'label' => __('Title En')],
            ['data' => 'name', 'name' => 'name', 'label' => __('Name')],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Created At')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }

    public function checkSuperRole($role)
    {
        if (in_array($role->name, ['super_admin', 'delegate'])) {
            return true;
        }
        return false;
    }
}
