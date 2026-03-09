<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    protected $attribute;

    public function __construct()
    {
        $this->attribute = new Attribute();
    }

    public function index()
    {
        $attributes = $this->attribute->orderBy('id', 'desc')->paginate(config('constants.pagination_limit'));
        return view('attribute.index', compact('attributes'));
    }

    public function add()
    {
        return view('attribute.add');
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $attribute = $this->attribute;
        $attribute->name = $request->name;
        $attribute->save();
        return redirect()->back()->with('success', 'Successfully!');
    }

    public function edit($id)
    {
        $attribute = $this->attribute->find($id);
        return view('attribute.edit', compact('attribute'));
    }

    public function update(Request $request)
    {
        $attribute = $this->attribute->find($request->id);
        $attribute->name = $request->name;
        if ($attribute->save()) {
            return redirect()->back()->with('success', 'Updated successfully!');
        }
        return redirect()->back()->with('error', 'Update failed!');
    }
}
