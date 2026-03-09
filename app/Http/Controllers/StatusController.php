<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    protected $status;

    public function __construct()
    {
        $this->status = new Status();
    }

    public function index()
    {
        $status = $this->status->orderBy('id', 'desc')->paginate(config('constants.pagination_limit'));
        return view('status.index', compact('status'));
    }

    public function add()
    {
        return view('status.add');
    }

    public function save(Request $request)
    {
        $data = [
            'name'       => $request->name,
        ];

        $this->status->create($data);
        return redirect()->back()->with('success', 'Success!');
    }

    public function edit($id)
    {
        $status = $this->status->find($id);
        return view('status.edit', compact('status'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $status = $this->status->find($request->id);

        $data = [
            'name'       => $request->name,
        ];

        $status->save($data);
        return redirect()->back()->with('success', 'Success!');
    }
}
