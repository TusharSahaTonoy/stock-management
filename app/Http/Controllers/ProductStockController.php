<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductStockLog;
use App\Models\TransactionSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ProductStockController extends Controller
{
    public static function Routes()
    {
        Route::controller(self::class)->prefix('stock')->name('stock.')->group(function () {
            Route::get('/', 'index');
            Route::get('/add', 'add')->name('add');
            Route::post('/store', 'addStock')->name('store');
            Route::get('/out', 'stockOutPage')->name('out');
            Route::post('/out', 'stockOut')->name('out-save');
        });
    }

    public function add()
    {
        $products = Product::all();
        return view('product.stock-add', compact('products'));
    }

    public function addStock(Request $request)
    {
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'quantity' => 'required|integer|min:1',
        // ]);

        // dd($request->all());

        DB::beginTransaction();
        try {
            foreach ($request->products as $prodId => $item) {

                ProductStockLog::create([
                    'product_id' => $prodId,
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'action_type' => 'in'
                ]);

                // stock update
                // self::productStockUpdate($prodId, $type, $price, $qty);
                $prodVari = ProductStock::firstOrCreate(['product_id' => $prodId, 'price' => $item['price']], ['stock' => 0]);
                $prodVari->stock = $prodVari->stock + $item['qty'];
                $prodVari->save();
                // end

            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->back()->with('success', 'Stock Updated Successfully!');
    }

    public function productStockUpdate($prodId, $type, $price, $qty)
    {
        $prodVari = ProductStock::firstOrCreate(['product_id' => $prodId, 'price' => $price]);

        if ($type) {
            $prodVari->stock = $prodVari->stock + $qty;
        } else {
        }

        $prodVari->stock = $type ? $prodVari->stock + $qty : $prodVari->stock - $qty;
        $prodVari->save();
    }

    public function sellStockPage()
    {
        $products = Product::all();
        return view('stock.sell', compact('products'));
    }

    public function stockOutPage()
    {
        return view('product.stock-out', ['products' => ProductStock::where('stock', '>', '0')->get()]);
    }

    public function stockOut(Request $request)
    {
        // Profit loss count
        DB::beginTransaction();
        try {
            foreach ($request->products ?? [] as $prodStockId => $item) {
                $stock =  ProductStock::find($prodStockId);
                $stock->stock = $stock->stock - $item['quantity'];
                $stock->save();

                ProductStockLog::create([
                    'product_id' => $stock->product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'action_type' => 'out'
                ]);

                $total = ($item['price'] - $stock->price) * $item['quantity'];

                TransactionSummary::create([
                    'product_stock_id' => $stock->id,
                    'sum' => $total,
                    'type' => 'sell'
                ]);

                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        // --Price trend 

        return back()->with('success', 'Transaction recorded successfully.');
    }
}
