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
            'buy_place.required' => '?????a ??i???m mua h??ng kh??ng ???????c ????? tr???ng',
            'status.required' => 'Tr???ng th??i kh??ng ???????c ????? tr???ng',
            'payment_method.required' => 'Ph????ng th???c thanh to??n kh??ng ???????c ????? tr???ng',
            'product.required' => 'S???n ph???m kh??ng ???????c ????? tr???ng',
            'customer_email.required_if' => 'Email kh??ng ???????c ????? tr???ng khi mua h??ng online',
            'customer_email.email' => 'Email kh??ng ????ng ?????nh d???ng',
            'deliver_to.required_if' => '?????a ch??? kh??ng ???????c ????? tr???ng khi mua h??ng online',
            'products.required' => 'Ch??a c?? s???n ph???m trong ????n h??ng',
            'products.min' => 'Ch??a c?? s???n ph???m trong ????n h??ng',
            'products.*.quantity.required' => 'S??? l?????ng s???n ph???m kh??ng ???????c b??? tr???ng',
            'products.*.quantity.integer' => 'S??? l?????ng s???n ph???m ph???i l?? s??? nguy??n',
            'products.*.quantity.max' => 'S??? l?????ng s???n ph???m kh??ng qu?? 30000',
            'products.*.product_id.distinct' => '1 Lo???i s???n ph???m ch??? ???????c nh???p t???i ??a 1 l???n',
        ];
    }
}
