<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Combo;
use App\Models\Product;

class ComboController extends Controller
{
    protected $product;
    protected $combo;

    public function __construct()
    {
        $this->product = new Product();
        $this->combo = new Combo();
    }

    public function index()
    {
        $combos = $this->combo->join('products', 'combo_products.combo_product_id', 'products.id')
            ->select('combo_products.*', 'products.name')
            ->orderBy('combo_products.id', 'desc')->paginate(config('constants.pagination_limit'));
        return view('combo.index', compact('combos'));
    }

    public function add($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'id not found!');
        }
        $product = $this->product->find($id);
        $products = $this->product->where('id', '!=', $id)->get();
        return view('combo.add', compact('product', 'products'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'combo_product_id' => 'required',
            'product_id' => 'required|array',
            'image' => 'required|image'
        ]);

        try {

            $imagePath = null;

            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('combo'), $imageName);
                $imagePath = 'combo/' . $imageName;
            }

            foreach ($request->product_id as $pid) {

                Combo::create([
                    'combo_product_id' => $request->combo_product_id,
                    'product_id'       => $pid,
                    'image'            => $imagePath,
                    'link'             => $request->link,
                    'description'      => $request->description,
                    'price'            => $request->price
                ]);
            }

            return redirect()->back()->with('success', 'Combo Created Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'id not found!');
        }

        $combo = $this->combo->find($id);

        $comboItems = Combo::where('combo_product_id', $combo->combo_product_id)
            ->with('product')
            ->get();

        $products = $this->product->where('id', '!=', $combo->combo_product_id)->get();

        return view('combo.edit', compact('combo', 'products', 'comboItems'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'combo_product_id' => 'required',
            'product_id' => 'required|array',
            'image' => 'nullable|image'
        ]);

        try {

            $comboId = $request->combo_product_id;

            $existingItems = Combo::where('combo_product_id', $comboId)->get();

            $existingProductIds = $existingItems->pluck('product_id')->toArray();

            $imagePath = optional($existingItems->first())->image;

            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('combo'), $imageName);
                $imagePath = 'combo/' . $imageName;
            }

            $newProductIds = $request->product_id;

            foreach ($newProductIds as $pid) {

                if (!in_array($pid, $existingProductIds)) {

                    Combo::create([
                        'combo_product_id' => $comboId,
                        'product_id'       => $pid,
                        'image'            => $imagePath,
                        'link'             => $request->link,
                        'description'      => $request->description,
                        'price'            => $request->price
                    ]);
                }
            }

            Combo::where('combo_product_id', $comboId)->update([
                'image'       => $imagePath,
                'link'        => $request->link,
                'description' => $request->description,
                'price'       => $request->price
            ]);

            Combo::where('combo_product_id', $comboId)
                ->whereNotIn('product_id', $newProductIds)
                ->delete();

            return redirect()->back()->with('success', 'Combo Updated Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteItem($id)
    {
        try {
            $combo = Combo::find($id);

            if (!$combo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Item not found'
                ]);
            }

            $combo->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
