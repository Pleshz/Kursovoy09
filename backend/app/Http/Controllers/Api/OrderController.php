<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => ['required', 'integer', 'exists:cars,id'],
            'tariff' => ['nullable', 'in:minute,hour,day'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'end_zone' => ['nullable', 'string', 'max:255'],
        ]);

        $car = Car::query()->where('is_active', true)->findOrFail($validated['car_id']);
        $startAt = Carbon::parse($validated['start_at']);
        $endAt = Carbon::parse($validated['end_at']);

        if ($endAt->isPast()) {
            return response()->json([
                'message' => 'Время окончания аренды должно быть в будущем.',
            ], 422);
        }

        $hasOverlap = Order::query()
            ->where('car_id', $car->id)
            ->whereIn('status', ['created', 'active'])
            ->whereNotNull('start_at')
            ->whereNotNull('end_at')
            ->where(function ($query) use ($startAt, $endAt) {
                $query
                    ->where('start_at', '<', $endAt->toDateTimeString())
                    ->where('end_at', '>', $startAt->toDateTimeString());
            })
            ->exists();

        if ($hasOverlap) {
            return response()->json([
                'message' => 'Этот автомобиль уже забронирован на выбранный период.',
            ], 409);
        }

        $order = Order::query()->create([
            'car_id' => $car->id,
            'user_id' => $request->user()->id,
            'tariff' => $validated['tariff'] ?? 'minute',
            'start_at' => $startAt->toDateTimeString(),
            'end_at' => $endAt->toDateTimeString(),
            'start_at_text' => $startAt->format('d.m.Y H:i'),
            'end_zone' => $validated['end_zone'] ?? null,
            'status' => $startAt->isFuture() ? 'created' : 'active',
        ]);

        return response()->json([
            'data' => $order->load('car'),
        ], 201);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== request()->user()->id) {
            abort(403, 'Недостаточно прав для просмотра этого заказа.');
        }

        return response()->json([
            'data' => $order->load('car'),
        ]);
    }
}

