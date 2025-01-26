<?php
namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Stop;
use Illuminate\Http\Request;

class BusController extends Controller
{
    /**
     * Поиск автобусов по остановкам.
     */
    public function findBus(Request $request)
    {
        $fromId = $request->get('from'); // "ID" начальной остановки
        $toId = $request->get('to'); // "ID" конечной остановки

        // Находим автобусы, которые проходят через указанные остановки
        $buses = Bus::with(['routes.stops']) // Загружаем связанные маршруты и остановки
                    ->whereHas('routes', function ($query) use ($fromId, $toId) {
                        $query->where('stop_id', $fromId)
                              ->orWhere('stop_id', $toId);
                    })
                    ->get();

        $response = [
            'from' => Stop::find($fromId)->name ?? 'Unknown',
            'to' => Stop::find($toId)->name ?? 'Unknown',
            'buses' => [],
        ];

        foreach ($buses as $bus) {
            foreach ($bus->routes as $route) {
                // Получаем конечную остановку маршрута
                $finalStop = $route->stops->last()->name ?? 'Unknown'; // Последняя остановка — конечная

                $response['buses'][] = [
                    'route' => "Автобус №{$bus->id} в сторону ост. {$finalStop}", // Форматируем строку маршрута
                    'next_arrivals' => ['08:15', '08:40', '09:15'], // Здесь можно потом добавить логику для времени
                ];
            }
        }

        return response()->json($response); // Возврат ответа в формате JSON
    }
}

