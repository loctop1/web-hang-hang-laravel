<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    /**Hàm rules() được sử dụng trong một lớp Form Request của Laravel để xác định các quy tắc (rules) cho việc xác thực 
     * dữ liệu được gửi trong một yêu cầu HTTP. Các quy tắc này được sử dụng để kiểm tra và đảm bảo tính hợp lệ 
     * của dữ liệu trước khi nó được chấp nhận và xử lý. */
    {
        return [
            'name' => [
            'string'
            /**Quy tắc cho trường 'name' là kiểu dữ liệu là string (chuỗi ký tự). Điều này đảm bảo rằng giá trị của trường 
             * 'name' phải là một chuỗi ký tự. */ 
            ],
            'slug' =>[
                'required',
                'string'
                /**Quy tắc cho trường 'slug' bắt buộc (không được để trống) và kiểu dữ liệu là string (chuỗi ký tự). 
                 * Điều này đảm bảo rằng trường 'slug' phải có giá trị và là một chuỗi ký tự. */
            ],
            'description' =>[
                'required',
            ],
            'image' =>[
                'nullable',
                'mimes:png,jpg,jpeg'
                /**Quy tắc cho trường 'image' có thể null (có thể bỏ trống) và chỉ cho phép tải lên các tệp có phần mở rộng 
                 * là 'png', 'jpg' hoặc 'jpeg'. Điều này đảm bảo rằng trường 'image' có thể có giá trị null 
                 * hoặc phải là một tệp hợp lệ với các phần mở rộng được chỉ định. */
            ],
            'meta_title' =>[
                'required',
                'string'
            ],
            'meta_keyword' =>[
                'required',
                'string'
            ],
            'meta_description' =>[
                'required',
                'string'
            ],
        ];
        /**Các quy tắc này được sử dụng trong quá trình xác thực dữ liệu đầu vào của yêu cầu HTTP để đảm bảo tính hợp lệ 
         * và an toàn của dữ liệu trước khi nó được xử lý và lưu trữ trong cơ sở dữ liệu. */
    }
}
