<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class AdminsController extends Controller
{
    public function index()
    {
        return view('admins.list', [
            'columns' => $this->columns()
        ]);
    }

    public function create()
    {

        return view('admins.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required|min:7|unique:admins,phone',
            'password' => ['required','confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
//            'role_id' => 'nullable|exists:roles,id',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'type' => auth()->user()->type

        ]);

        // assign role
//        $admin->addRole($request->role_id);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        // prevent update super admin
        if ($this->checkSuperAdmin($admin)) {
            session()->flash('error', __('Cannot edit the first super admin.'));
            return redirect()->back();
        }

//        $roles = Role::where('name','!=','super_admin')->get();

//        $adminRole = $admin->roles()->first();

        return view('admins.edit',[
            'admin' => $admin,
//            'roles' => $roles,
//            'adminRole' => $adminRole,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:admins,email,' . $id,
            'phone' => 'required|min:7|unique:admins,phone,' . $id,
            'password' => ['nullable','confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
//            'role_id' => 'required|exists:roles,id',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $admin = Admin::findOrFail($id);

        // prevent update super admin
        if ($this->checkSuperAdmin($admin)) {
            session()->flash('error', __('Cannot edit the first super admin.'));
            return redirect()->back();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

//        $role = Role::findOrFail($request->role_id);

        // assign role
//        $admin->removeRole($role);

//        $admin->addRole($role);


        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $admin = Admin::findOrFail($id);

            // prevent update super admin
            if ($this->checkSuperAdmin($admin)) {
                session()->flash('error', 'Cannot delete the first super admin.');
                return redirect()->back();
            }

            $admin->delete();

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
                'ids.*' => 'required|integer|exists:admins,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator->validated());
            }

            $admins = Admin::whereIn('id',$ids)->get();

            // prevent update first admin
            $deleteAdmin = false;
            foreach ($admins as $admin) {
                // prevent update super admin
                if ($this->checkSuperAdmin($admin)) {
                    $deleteAdmin = true;
                }
            }
            if ($deleteAdmin) {
                session()->flash('error', 'Cannot delete the first super admin.');
                return redirect()->back();
            }

            $admins->delete();

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
            ->addColumn('role', function ($row) {
                $roles = $row->roles()->pluck('display_name_' . \app()->getLocale() )->toArray();
                if (!empty($roles)) {
                    $roleString = implode(', ', $roles);
                    return $roleString;
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                $actionButtons = '';
                if (!$row->hasRole('super_admin')) {
                    $actionButtons = '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="'.__('Edit').'">
                        <a href="'.route('admins.edit',$row->id).'" class="text-primary d-inline-block edit-item-btn">
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
        $adminsQuery = Admin::query()
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('name', 'like', "%$searchKey%")
                        ->orWhere('email', 'like', "%$searchKey%")
                        ->orWhere('phone', 'like', "%$searchKey%");
                })
                    ->orWhereHas('roles',function ($query) use ($searchKey) {
                        $query->where('name', 'like', "%$searchKey%")
                            ->orWhere('display_name_ar', 'like', "%$searchKey%")
                            ->orWhere('display_name_en', 'like', "%$searchKey%");
                    });
            })
            ->when($request->has('from_date') && $request->filled('from_date'), function ($query) use ($request) {
                $query->where('created_at','>=',$request->from_date);
            })
            ->when($request->has('to_date') && $request->filled('to_date'), function ($query) use ($request) {
                $query->where('created_at','<=',$request->to_date);
            });

        return $adminsQuery;
    }

    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'select', 'name' => 'select', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name', 'label' => __('Name')],
            ['data' => 'email', 'name' => 'email', 'label' => __('Email')],
            ['data' => 'phone', 'name' => 'phone', 'label' => __('Phone')],
//            ['data' => 'role', 'name' => 'role', 'label' => __('Role')],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Created At')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }

    public function checkSuperAdmin($admin)
    {
        if ($admin->hasRole('super_admin')) {
            return true;
        }
        return false;
    }
}
