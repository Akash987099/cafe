<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    protected $table;

    public function __construct()
    {
        $this->table = new Table();
    }

    public function index(Request $request)
    {
        $tables = $this->table->paginate(config('constants.pagination_limit'));
        return view('table.index', compact('tables'));
    }

    public function add()
    {
        return view('table.add');
    }
}
