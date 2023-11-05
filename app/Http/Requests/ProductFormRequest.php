<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
    {
        return [
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'slug' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'small_description' => 'required|string',
            'description' => 'required|string',
            'original_price' => 'required|integer',
            'selling_price' => 'required|integer',
            'quantity' => 'required|integer',
            'trending' => 'nullable',
            'status' => 'nullable',
            'meta_title' => 'required|string|max:255',
            'meta_keyword' => 'required|string',
            'meta_description' => 'required|string',
            'image' => 'nullable',
        ];
    }

    public function messages(): array
    {
        // Ghi đè phương thức messages()
        return $this->customMessages();
    }

    public function customMessages(): array
    {
        return [
            'category_id.required' => 'Vui lòng điền thông tin này!',
            'category_id.integer' => 'Chỉ được nhập số nguyên cho trường này!',
            'name.required' => 'Vui lòng điền tên sản phẩm!',
            'name.string' => 'Chỉ được nhập ký tự cho mục tên sản phẩm!',
            'slug.required' => 'Vui lòng điền từ khóa sản phẩm!',
            'slug.string' => 'Chỉ được nhập ký tự cho từ khóa sản phẩm này!',
            'slug.max' => 'Tối đa 255 ký tự cho từ khóa sản phẩm này!',
            'brand.required' => 'Vui lòng nhập tên thương hiệu sản phẩm này!',
            'brand.string' => 'Chỉ được nhập ký tự cho thương hiệu sản phẩm!',
            'brand.max' => 'Tối đa 255 ký tự cho thương hiệu sản phẩm này!',
            'small_description.required' => 'Vui lòng điền mô tả ngắn sản phẩm!',
            'small_description.string' => 'Chỉ được nhập ký tự cho mô tả ngắn!',
            'description.required' => 'Vui lòng điền mô tả sản phẩm!',
            'description.string' => 'Chỉ được nhập ký tự cho mô tả sản phẩm!',
            'original_price.required' => 'Vui lòng nhập giá tiền!',
            'original_price.integer' => 'Chỉ được nhập số nguyên cho giá tiền!',
            'selling_price.required' => 'Vui lòng nhập giá sale!',
            'selling_price.integer' => 'Chỉ được nhập số nguyên cho giá sale!',
            'quantity.required' => 'Vui lòng nhập số lượng sản phẩm!',
            'quantity.integer' => 'Chỉ được nhập số nguyên cho số lượng sản phẩm!',
            'trending.nullable' => 'Vui lòng chọn xu hướng!',
            'status.nullable' => 'Vui lòng chọn status!',
            'meta_title.required' => 'Vui lòng điền chú thích!',
            'meta_title.string' => 'Chỉ được nhập ký tự cho chú thích!',
            'meta_title.max' => 'Tối đa 255 ký tự cho chú thích!',
            'meta_keyword.required' => 'Vui lòng điền từ khóa!',
            'meta_keyword.string' => 'Chỉ được nhập ký tự cho từ khóa!',
            'meta_description.required' => 'Vui lòng điền meta mô tả!',
            'meta_description.string' => 'Chỉ được nhập ký tự cho meta mô tả!',
            
        ];
    }
}
