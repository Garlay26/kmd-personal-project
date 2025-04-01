<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Admin;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request)
    {
        $total_orders = Order::where('status','approved')->count();
        $total_pending_orders = Order::where('status','pending')->count();
        $total_sales = Order::where('status','approved')->sum('total_amount');
        $total_customers = Customer::where('status','active')->count();
        $total_products = Product::count();
        $total_brands = Brand::count();
        $total_categories = Category::count();
        $total_admins = Admin::count();
        return view('dashboard',['total_orders' => $total_orders,'total_sales' => $total_sales,'total_customers' => $total_customers,'total_pending_orders' => $total_pending_orders,
                                'total_products' => $total_products,'total_brands' => $total_brands, 'total_categories' => $total_categories, 'total_admins' => $total_admins]);       
    }
}
