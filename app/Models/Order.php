<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'address_id',
        'status',
        'payment_method',
        'payment_status',
        'sub_total',
        'discount',
        'tax',
        'shipping_cost',
        'total',
        'voucher_code',
        'completed_at',
        'notes',
        'system_notes',
    ];

    use HasFactory;

    const STATUS = ['pending', 'in_progress','in_way', 'complete', 'cancelled'];
    const PAYMENT_METHOD = ['credit', 'cash', 'wallet', 'apple', 'mada'];
    const PAYMENT_STATUS = ['partial_paid', 'paid', 'unpaid'];

    protected $appends = ['quantity'];

    public function getQuantityAttribute($total)
    {
        return $this->items()->count();
    }

    public function setSubTotalAttribute($sub_total)
    {
        $this->attributes['sub_total'] = round($sub_total, 2);
    }

    public function setDiscountAttribute($discount)
    {
        $this->attributes['discount'] = round($discount, 2);
    }

    public function setTaxAttribute($tax)
    {
        $this->attributes['tax'] = round($tax, 2);
    }


    public function setTotalAttribute($total)
    {
        $this->attributes['total'] = round($total, 2);
    }


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByDesc', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });

        $admin = auth('web')->user();
        // add global scope
        static::addGlobalScope('checkDelegate', function (Builder $builder) use ($admin) {

            if ($admin && $admin->type == 'delegate') {
                $builder->where('delegate_id', $admin->id);
            }
        });
    }

    /**
     * @return array
     */
    public static function statusList(): array
    {
        return [
            OrderStatusEnum::PENDING,
            OrderStatusEnum::IN_PROGRESS,
            OrderStatusEnum::COMPLETE,
            OrderStatusEnum::CANCELLED,
        ];
    }

    /**
     * @return array
     */
    public static function paymentStatusList(): array
    {
        return [
            PaymentStatusEnum::PARTIAL_PAID,
            PaymentStatusEnum::PAID,
            PaymentStatusEnum::UNPAID,
        ];
    }

    /**
     * @return array
     */
    public static function paymentMethodList(): array
    {
        return [
            PaymentMethodEnum::CREDIT,
            PaymentMethodEnum::CASH,
            PaymentMethodEnum::APPLE,
            PaymentMethodEnum::MADA,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function first_item()
    {
        return $this->hasOne(OrderItem::class, 'order_id');
    }
}
