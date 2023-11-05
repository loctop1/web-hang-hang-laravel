<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Đếm tổng số sản phẩm trong bảng 'products'
    $totalProducts = Product::count();

    // Đếm tổng số danh mục trong bảng 'categories'
    $totalCategories = Category::count();

    // Đếm tổng số thương hiệu trong bảng 'brands'
    $totalBrands = Brand::count();

    // Đếm tổng số người dùng trong bảng 'users'
    $totalAllUsers = User::count();

    // Đếm tổng số người dùng có vai trò là '0'
    $totalUser = User::where('role_as', '0')->count();

    // Đếm tổng số người dùng có vai trò là '1'
    $totalAdmin = User::where('role_as', '1')->count();

    // Lấy ngày hôm nay và định dạng thành 'd-m-y'
    $todayDate = Carbon::now()->format('d-m-y');

    // Lấy tháng hiện tại
    $thisMonth = Carbon::now()->format('m');

    // Lấy năm hiện tại
    $thisYear = Carbon::now()->format('Y');

    // Đếm tổng số đơn hàng trong bảng 'orders'
    $totalOrder = Order::count();

    // Đếm số đơn hàng được tạo trong ngày hôm nay
    $todayOrder = Order::whereDate('created_at', $todayDate)->count();

    // Đếm số đơn hàng được tạo trong tháng hiện tại
    $thisMonthOrder = Order::whereMonth('created_at', $thisMonth)->count();

    // Đếm số đơn hàng được tạo trong năm hiện tại
    $thisYearOrder = Order::whereYear('created_at', $thisYear)->count();

    // Trả về view 'admin.dashboard' với các biến compact để truyền dữ liệu sang view
    return view('admin.dashboard', compact('totalProducts', 
                                            'totalCategories', 
                                            'totalBrands', 
                                            'totalAllUsers', 
                                            'totalUser',
                                            'totalAdmin',  
                                            'totalOrder',
                                            'todayOrder',
                                            'thisMonthOrder',
                                            'thisYearOrder'
                                        ));
}

}
