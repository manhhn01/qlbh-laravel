<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Repositories\ReceivedNote\ReceivedNoteRepositoryInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class OrderCreateRequest extends FormRequest
{
    protected $orderRepository;

    public function __construct(ReceivedNoteRepositoryInterface $orderRepository, $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->orderRepository = $orderRepository;
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'buy_place' => ['required'],
            'status' => ['required'],
            'payment_method' => ['required'],
            'products' => ['required', 'min:1'],
            'products.*.quantity' => ['required', 'integer', 'min:1', 'max:30000'],
            'products.*.product_id' => ['required', 'distinct'],
            'customer_email' => ['email', 'required_if:buy_place, "0"'],
            'deliver_to' => ['required_if:buy_place,"0"'],
        ];
    }

    public function prepareForValidation()
    {
        $attributes = $this->all();
        if (!isset($attributes['coupon_id'])) {
            $this->merge(['coupon_id' => null]);
        }
        if (!empty($attributes['products'])) {
            $updated_products = collect($attributes['products'])
                ->map(function ($item) {
                    $product = Product::find($item['product_id']);
                    if (isset($product)) {
                        $item['name'] = $product->name;
                        $item['sku'] = $product->sku;
                        $item['max_qty'] = $product->quantity; // lay so luong moi tren db
                        $item['price'] = $product->price;

                        return $item;
                    } else {
                        return [];
                    }
                })->reject(function ($item) { //https://laravel.com/docs/8.x/collections#method-reject xoa co dieu kien
                    return empty($item);
                })->toArray();
            $this->merge(['products' => $updated_products, 'employee_id' => auth()->user()->id]);
        }
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            back()->withInput($this->all())->withErrors($errors)
        );
    }

    public function messages()
    {
        return [
            'buy_place.required' => 'Địa điểm mua hàng không được để trống',
            'status.required' => 'Trạng thái không được để trống',
            'payment_method.required' => 'Phương thức thanh toán không được để trống',
            'product.required' => 'Sản phẩm không được để trống',
            'customer_email.required_if' => 'Email không được để trống khi mua hàng online',
            'customer_email.email' => 'Email không đúng định dạng',
            'deliver_to.required_if' => 'Địa chỉ không được để trống khi mua hàng online',
            'products.required' => 'Chưa có sản phẩm trong đơn hàng',
            'products.min' => 'Chưa có sản phẩm trong đơn hàng',
            'products.*.quantity.required' => 'Số lượng sản phẩm không được bỏ trống',
            'products.*.quantity.integer' => 'Số lượng sản phẩm phải là số nguyên',
            'products.*.quantity.max' => 'Số lượng sản phẩm không quá 30000',
            'products.*.product_id.distinct' => '1 Loại sản phẩm chỉ được nhập tối đa 1 lần',
        ];
    }
}
