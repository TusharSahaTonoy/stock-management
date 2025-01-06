<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductStockLog;
use App\Models\TransactionSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public static function Routes()
    {
        Route::controller(self::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/home', 'index')->name('home');
        });
    }

    function index()
    {
        $totalProducts = ProductStock::sum('stock');
        $totalProfit = TransactionSummary::where('type', 'sell')->sum('sum');
        $totalSellQty = ProductStockLog::where('action_type', 'out')->sum('quantity');
        
        return view('home', compact('totalProducts', 'totalProfit', 'totalSellQty'));
    }
}
