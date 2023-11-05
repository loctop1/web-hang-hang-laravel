<?php

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//
Route::controller(App\Http\Controllers\Frontend\FrontendController::class)->group(function () {
    //giao diện trang chủ web bán hàng
    Route::get('/', 'index');
    //giao diện danh mục sản phẩm
    Route::get('/collections', 'categories');
    //phân loại các danh mục sản phẩm
    Route::get('/collections/{category_slug}', 'products');
    //giao diện thông tin chi tiết từng sản phẩm
    Route::get('/collections/{category_slug}/{product_slug}', 'productView');
    //giao diện các sản phẩm mới
    Route::get('/new-arrivals', 'newArrival');
    //giao diện các sản phẩm nổi bật
    Route::get('/featured-products', 'featuredProducts');
    //giao diện tìm kiếm sản phẩm
    Route::get('search', 'searchProducts');
});

//tạo chức năng khi muốn truy cập vào danh sách sản phẩm yêu thích thì phải đăng nhập
Route::middleware(['auth'])->group(function () {
    //giao diện danh mục sản phẩm yêu thích
    Route::get('wishlist', [App\Http\Controllers\Frontend\WishlistController::class, 'index']);
    //giao diện danh sách sản phẩm trong giỏ hàng
    Route::get('cart', [App\Http\Controllers\Frontend\CartController::class, 'index']);
    //giao diện hóa đơn sản phẩm
    Route::get('checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'index']);
    
    //giao diện danh sách đơn hàng của tôi
    Route::get('orders', [App\Http\Controllers\Frontend\OrderController::class, 'index']);
    //giao diện thông tin từng đơn hàng của tôi
    Route::get('orders/{orderId}', [App\Http\Controllers\Frontend\OrderController::class, 'show']);
    
    //giao diện form thông tin người dùng
    Route::get('profile', [App\Http\Controllers\Frontend\UserController::class, 'index']);
    //chức năng cập nhật dữ liệu form thông tin người dùng
    Route::post('profile', [App\Http\Controllers\Frontend\UserController::class, 'updateUserDetails']);
    
    //giao diện thay đổi mật khẩu người dùng
    Route::get('change-password', [App\Http\Controllers\Frontend\UserController::class, 'passwordCreate']);
    //chức năng cập nhật mật khẩu thành công khi gửi dữ liệu
    Route::post('change-password', [App\Http\Controllers\Frontend\UserController::class, 'changePassword']);
});

//giao diện thông báo lời cảm ơn khách hàng đã mua sản phẩm
Route::get('/thank-you', [App\Http\Controllers\Frontend\FrontendController::class, 'thankyou']);

//giao diện trang chủ
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);

    //giao diện cài đặt chung trong trang Admin
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index']);
    
    //tạo chức năng gửi dữ liệu cho form cài đặt chung trang Admin
    Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'store']);
    //Thanh trượt
    Route::controller(App\Http\Controllers\Admin\SliderController::class)->group(function () {
        //giao diện thanh trượt sản phẩm
        Route::get('sliders', 'index');
        //giao diện thêm thanh trượt sản phẩm
        Route::get('sliders/create', 'create');
        //tạo chức năng gửi dữ liệu khi thêm thanh trượt sản phẩm
        Route::post('sliders/create', 'store');
        //tạo trang chỉnh sửa thanh trượt sản phẩm
        Route::get('sliders/{slider}/edit', 'edit');
        //tạo chức năng gửi dữ liệu khi cập nhật thanh trượt sản phẩm
        Route::put('sliders/{slider}', 'update');
        //tạo chức năng xóa thanh trượt sản phẩm
        Route::get('sliders/{slider}/delete', 'destroy');
    });

    //Danh mục sản phẩm
    Route::controller(App\Http\Controllers\Admin\CategoryController::class)->group(function ()
    /**Trong trường hợp này, App\Http\Controllers\Admin\CategoryController::class là tên của controller mà bạn muốn đăng ký 
     * routes. Bằng cách sử dụng Route::controller và chỉ định tên của controller, Laravel sẽ tự động đăng ký các routes 
     * cho các phương thức trong controller. 
     * Sau đó, bạn có thể sử dụng các routes được đăng ký trong controller thông qua các phương thức tương ứng, như 
     * 'index', 'create', 'store', 'edit', v.v.*/
    {
        //tạo danh mục sản phẩm
        Route::get('/category', 'index');
        /**Định nghĩa một route GET cho URL /category và liên kết nó với phương thức index trong CategoryController. 
         * Khi truy cập vào /category, phương thức index trong CategoryController sẽ được gọi để xử lý yêu cầu. */

        //tạo chức năng thêm danh mục sản phẩm
        Route::get('/category/create', 'create');
        /** Định nghĩa một route GET cho URL /category/create và liên kết nó với phương thức create trong CategoryController. 
         * Khi truy cập vào /category/create, phương thức create trong CategoryController sẽ được gọi để xử lý yêu cầu. */

        //tạo chức năng gửi dữ liệu khi thêm danh mục sản phẩm
        Route::post('/category', 'store');
        /**Định nghĩa một route POST cho URL /category và liên kết nó với phương thức store trong CategoryController. 
         * Khi gửi một yêu cầu POST đến /category, phương thức store trong CategoryController sẽ được gọi để xử lý yêu cầu. */

        //tạo trang chỉnh sửa sản phẩm
        Route::get('/category/{category}/edit', 'edit');
        /**Định nghĩa một route GET cho URL /category/{category}/edit và liên kết nó với phương thức edit trong 
         * CategoryController. Khi truy cập vào /category/{category}/edit, phương thức edit trong CategoryController sẽ 
         * được gọi để xử lý yêu cầu. Chú ý rằng {category} là một tham số động, và giá trị của tham số này sẽ được 
         * truyền vào phương thức edit. */

        //tạo chức năng gửi dữ liệu khi cập nhật sản phẩm
        Route::put('/category/{category}', 'update');
    });

    //xây dựng dao diện trang thêm danh mục sản phẩm
    Route::controller(App\Http\Controllers\Admin\ProductController::class)->group(function () {
        //giao diện danh sách sản phẩm
        Route::get('/products', 'index');
        //giao diện thêm sản phẩm
        Route::get('/products/create', 'create');
        //giao diện danh sách sản phẩm khi gửi dữ liệu thành công
        Route::post('/products', 'store');
        //giao diện chỉnh sửa sản phẩm
        Route::get('/products/{product}/edit', 'edit');
        //giao diện cập nhật sản phẩm khi gửi dữ liệu
        Route::put('/products/{product}', 'update');
        //tạo chức năng xóa sản phẩm
        Route::get('/products/{product_id}/delete', 'destroy');
        //tạo chức năng xóa ảnh sản phẩm
        Route::get('product-image/{product_image_id}/delete', 'destroyImage');
        //tạo chức năng cập nhật số lượng màu sắc sản phẩm bằng ajax trong form edit sản phẩm
        Route::post('product-color/{prod_color_id}', 'updateProdColorQty');
        //tạo chức năng xóa màu sắc sản phẩm bằng ajax trong form edit sản phẩm
        Route::get('product-color/{prod_color_id}/delete', 'deleteProdColor');
    });

    //xây dựng trang nhãn hiệu sản phẩm
    Route::get('/brands', App\Http\Livewire\Admin\Brand\Index::class);

    //giao diện màu sắc thêm sửa xóa sản phẩm
    Route::controller(App\Http\Controllers\Admin\ColorController::class)->group(function () {
        //giao diện màu sắc danh sách sản phẩm
        Route::get('/colors', 'index');
        //giao diện màu sắc thêm sản phẩm
        Route::get('/colors/create', 'create');
        //giao diện danh sách màu sắc sản phẩm khi gửi dữ liệu thành công
        Route::post('/colors/create', 'store');
        //giao diện chỉnh sửa sản phẩm
        Route::get('/colors/{color}/edit', 'edit');
        //giao diện cập nhật màu sắc sản phẩm khi gửi dữ liệu
        Route::put('/colors/{color_id}', 'update');
        ////tạo chức năng xóa màu sắc sản phẩm
        Route::get('/colors/{color_id}/delete', 'destroy');
    });

    // Trang quản trị đơn hàng
    Route::controller(App\Http\Controllers\Admin\OrderController::class)->group(function () {
        //giao diện quản trị đơn hàng
        Route::get('/orders', 'index');
        //giao diện thông tin hóa đơn trong trang quản trị
        Route::get('/orders/{orderId}', 'show' );
        //giao diện chỉnh sửa trạng thái đơn hàng
        Route::put('/orders/{orderId}', 'updateOrderStatus');
        //chức năng xem hóa đơn khi tải lên
        Route::get('/invoice/{orderId}', 'viewInvoice');
        //chức năng tải hóa đơn lên trình duyệt
        Route::get('/invoice/{orderId}/generate', 'generateInvoice');
        //chức năng gửi email hóa đơn sản phẩm
        Route::get('/invoice/{orderId}/mail', 'mailInvoice');
    });

    //Trang quản trị người dùng
    Route::controller(App\Http\Controllers\Admin\UserController::class)->group(function () {
        //giao diện quản trị người dùng
        Route::get('/users', 'index');
        //giao diện thêm tài khoản người dùng trang quản Admin
        Route::get('/users/create', 'create'); 
        //chức năng gửi dữ liệu khi gửi thông tin khách hàng
        Route::post('/users', 'store');
        //chức năng chỉnh sửa tài khoản người dùng
        Route::get('/users/{user_id}/edit', 'edit');
        //chức năng cập nhật thông tin tài khoản người dùng
        Route::put('/users/{user_id}', 'update');
        //chức năng xóa tài khoản người dùng
        Route::get('/users/{user_id}/delete', 'destroy');
    });
});
/**prefix là thuộc tính trong Laravel để thêm tiền tố vào đường dẫn của các tuyến đường trong một nhóm. 
 * Nghĩa là tất cả các tuyến đường trong nhóm sẽ bắt đầu với tiền tố đó.
 * group là một phương thức để nhóm các tuyến đường liên quan lại với nhau. Bằng cách sử dụng group, 
 * bạn có thể áp dụng các thuộc tính chung cho nhóm tuyến đường như tiền tố, middleware, namespace, và nhiều thuộc tính khác.
 * Tóm lại, đoạn mã trên định nghĩa một tuyến đường '/admin/dashboard' trong Laravel, 
 * và khi bạn truy cập vào đường dẫn này, nó sẽ gọi phương thức index 
 * trong lớp DashboardController để xử lý yêu cầu và trả về kết quả tương ứng. 
 * Mã middleware(['auth','isAdmin']) được sử dụng để áp dụng hai middleware cho nhóm các route nằm trong tiền tố 'admin'. 
 * Cụ thể:
 * auth: Middleware auth được tích hợp sẵn trong Laravel và được sử dụng để xác thực người dùng. Khi một route được bao bọc 
 * bởi middleware auth, nó yêu cầu người dùng đã đăng nhập để truy cập vào route đó. Nếu người dùng chưa đăng nhập, 
 * họ sẽ được chuyển hướng đến trang đăng nhập trước khi có thể truy cập vào route.
 * isAdmin: Middleware isAdmin là một middleware tùy chỉnh bạn đã tạo. Chức năng của nó là kiểm tra vai trò của người dùng 
 * và chỉ cho phép những người dùng có vai trò quản trị viên truy cập vào các route bên trong nhóm này. 
 * Nếu vai trò của người dùng không phải là quản trị viên, yêu cầu sẽ bị từ chối hoặc chuyển hướng đến trang lỗi 
 * hoặc trang truy cập bị từ chối.*/
