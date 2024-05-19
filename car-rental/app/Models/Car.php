<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
        'brand',
        'model',
        'plate_number',
        'rental_rate_per_day',
        'available'
    ];

    public static function getAllCars($perPage)
    {
        return self::paginate($perPage);
    }

    public static function getCarById($id)
    {
        return self::find($id);
    }

    public static function createCar($data)
    {
        return self::create($data);
    }

    public static function updateCarById($id, $data)
    {
        $car = self::find($id);
        if ($car) {
            $car->update($data);
            return $car;
        }
        return null;
    }

    public static function deleteCarById($id)
    {
        $car = self::find($id);
        if ($car) {
            $car->delete();
            return true;
        }
        return false;
    }

    public $timestamps = false;
}
