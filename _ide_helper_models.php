<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Category
 *
 * @method ofType($filter)
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property string $name
 * @property int $discount
 * @property int|null $remain
 * @property string|null $description
 * @property string $expire_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $is_usable
 * @method static \Database\Factories\CouponFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereRemain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Image
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ImageFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property string|null $customer_email
 * @property int $employee_id
 * @property int $buy_place
 * @property int $status
 * @property int $payment_method
 * @property int|null $coupon_id
 * @property string|null $deliver_to
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \App\Models\User|null $customer
 * @property-read \App\Models\User $employee
 * @property-read mixed $discount_amount
 * @property-read mixed $total_price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order ofType($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBuyPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliverTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @method ofType($filter)
 * @property int $id
 * @property int $category_id
 * @property int $supplier_id
 * @property string $name
 * @property string $sku
 * @property string $description
 * @property int $quantity
 * @property int $price
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReceivedNote[] $receivedNotes
 * @property-read int|null $received_notes_count
 * @property-read \App\Models\Supplier $supplier
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceivedNote
 *
 * @property int $id
 * @property int $manager_id
 * @property string $deliver_name
 * @property string $receive_at
 * @property int $status
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $total_price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ReceivedNoteFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote ofType($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote whereDeliverName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote whereReceiveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivedNote whereUpdatedAt($value)
 */
	class ReceivedNote extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Statistic
 *
 * @property int $id
 * @property int $order_total
 * @property int $product_total
 * @property int $proceeds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\StatisticFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Statistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Statistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Statistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Statistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statistic whereOrderTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statistic whereProceeds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statistic whereProductTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statistic whereUpdatedAt($value)
 */
	class Statistic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Supplier
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\SupplierFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier ofType($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUpdatedAt($value)
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $phone_number
 * @property string|null $address
 * @property string|null $avatar_image
 * @property int $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $created_orders
 * @property-read int|null $created_orders_count
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $has_orders
 * @property-read int|null $has_orders_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatarImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

