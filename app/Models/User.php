<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
        'country_code',
        'phone',
        'image',
        'password',
        'email_verified_at',
        'fcm_token',
        'platform',
        'login_code',
        'points',
        'city_id',
        'gender',
        'date_of_birth',
        'refer_code',
        'manual_deleted',
        'is_active',
        'value_added_certificate',
        'value_added_certificate_file',
        'company_name',
        'job_name',
        'discount',
    ];

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

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        if (isset($this->date_of_birth)) {
            $dob = Carbon::parse($this->date_of_birth);

            $this->age = $dob->age;
            return $dob->age;

        } else {
            return 0;
        }
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function user_points()
    {
        return $this->hasMany(UserPoint::class, 'user_id');
    }

    public function default_address()
    {
        return $this->hasOne(Address::class, 'user_id')->where('is_default', 1);
    }


    public function vouchers()
    {
        return $this->hasMany(VoucherUser::class, 'user_id');
    }

    public function getImageAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/clients_images/' . $image))) {
            return asset('storage') . '/clients_images/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image, 'clients_images');
            }
            $this->attributes['image'] = $imageFields;
        } else {
            $this->attributes['image'] = $image;
        }
    }
    public function getValueAddedCertificateFileAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/value_added_certificate_files/' . $image))) {
            return asset('storage') . '/value_added_certificate_files/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setValueAddedCertificateAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image, 'value_added_certificate_files');
            }
            $this->attributes['value_added_certificate_file'] = $imageFields;
        } else {
            $this->attributes['value_added_certificate_file'] = $image;
        }
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


}
