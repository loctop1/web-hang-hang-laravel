<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
    * Register any application services.
    */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        $websiteSetting = Setting::first();
        /**Dòng này truy vấn và lấy ra bản ghi đầu tiên từ bảng settings (có thể khác tên tùy thuộc vào cấu hình 
         * của bạn). Bản ghi này đại diện cho các cài đặt của trang web. */
        View::share('appSetting', $websiteSetting);
        /**Dòng này chia sẻ biến $appSetting với tất cả các view trong ứng dụng. Điều này có nghĩa là bạn có thể 
         * truy cập biến $appSetting từ mọi view trong ứng dụng của bạn mà không cần phải truyền nó qua mỗi view 
         * một cách riêng lẻ. Biến $appSetting sẽ chứa thông tin từ bản ghi cài đặt của trang web đã được truy vấn 
         * ở trên. */
    }
}
