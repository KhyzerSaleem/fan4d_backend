<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{

    public function __construct()
    {
//        $this->middleware('permission:pages_update', ['only' => ['edit','update']]);
    }

    public function edit($type)
    {
        $page = Page::where('type', $type)->firstOrFail();
        return view('pages.edit',compact('page'));
    }

    public function update(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'desc_ar' => 'required|min:10',
            'desc_en' => 'required|min:10',
            'image' => 'nullable',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $page = Page::where('type', $type)->firstOrFail();

        $page->update([
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'image' => $request->image,
        ]);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }
}
