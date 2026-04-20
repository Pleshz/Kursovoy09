<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now()->toDateTimeString();
        $busyCarIds = Order::query()
            ->whereIn('status', ['created', 'active'])
            ->where(function ($query) use ($now) {
                $query
                    ->whereNull('end_at')
                    ->orWhere('end_at', '>', $now);
            })
            ->pluck('car_id');

        $cars = Car::query()
            ->where('is_active', true)
            ->whereNotIn('id', $busyCarIds)
            ->orderBy('id')
            ->get([
                'id',
                'slug',
                'name',
                'segment',
                'transmission',
                'fuel',
                'description',
                'image_url',
                'latitude',
                'longitude',
                'rate_minute',
                'rate_hour',
                'rate_day',
                'range_km',
            ]);

        return response()->json([
            'data' => $cars,
        ]);
    }

    public function show(Car $car)
    {
        $now = Carbon::now()->toDateTimeString();
        $isBusy = Order::query()
            ->where('car_id', $car->id)
            ->whereIn('status', ['created', 'active'])
            ->where(function ($query) use ($now) {
                $query
                    ->whereNull('end_at')
                    ->orWhere('end_at', '>', $now);
            })
            ->exists();

        $carData = $car->toArray();
        $carData['is_available'] = !$isBusy && (bool) $car->is_active;

        return response()->json([
            'data' => $carData,
        ]);
    }
}

