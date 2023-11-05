<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserDetail;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_as'
    ];

    //
    public function userDetail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
        /**Dòng này thực hiện việc định nghĩa một mối quan hệ "hasOne" giữa lớp hiện tại (được tham chiếu thông qua $this) và lớp UserDetail. Điều này có nghĩa là mỗi đối tượng của lớp 
         * hiện tại có một bản ghi tương ứng trong bảng UserDetail.
         * UserDetail::class: Đây là cách sử dụng "class reference" để xác định tên của lớp UserDetail mà mối quan hệ được thiết lập đến.
         * 'user_id': Đây là tên cột trong bảng UserDetail chứa khóa ngoại (foreign key) để liên kết với bảng hiện tại.
         * 'id': Đây là tên cột trong bảng hiện tại đại diện cho khóa chính. */
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
