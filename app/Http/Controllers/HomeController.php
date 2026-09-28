<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Topping;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::with('stok')->orderBy('id_menu', 'asc')->get();
        $toppings = Topping::orderBy('id_topping', 'asc')->get();
        $storeStatus = \App\Services\StoreSchedule::getStatus();

        return view('frontend.home', compact('menus', 'toppings', 'storeStatus'));
    }
}
