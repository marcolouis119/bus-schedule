<?php
namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Stop;
use App\Models\StopTime;
use Illuminate\Http\Request;
use App\Models\RouteStop;

class BusController extends Controller {

    // Метод для поиска автобусов
    public function findBus(Request $request) {
        // Валидация входных параметров
        $request->validate([
            'from' => 'required|integer|exists:stops,id',
            'to' => 'required|integer|exists:stops,id'
        ]);

        // Получаем остановки
        $fromStop = Stop::find($request->from);
        $toStop = Stop::find($request->to);

        // Получаем маршруты
        $routes = Route::whereHas('routeStops', function($query) use ($request) {
            $query->where('stop_id', $request->from);
        })->whereHas('routeStops', function($query) use ($request) {
            $query->where('stop_id', $request->to);
        })->with('routeStops.stop')
        ->get();

        $buses = [];

        foreach ($routes as $route) {
            $nextArrivals = $this->getNextArrivals($route);

            $buses[] = [
                'route' => $route->name,
                'next_arrivals' => $nextArrivals
            ];
        }

        return response()->json([
            'from' => $fromStop->name,
            'to' => $toStop->name,
            'buses' => $buses
        ]);
    }

    // Метод для получения следующих прибытий
    private function getNextArrivals($route) {
        // Получаем текущее время
        $currentTime = now()->format('H:i:s');

        // Извлекаем расписание для этого маршрута
        $nextArrivals = StopTime::where('route_id', $route->id)
            ->where('arrival_time', '>', $currentTime) // Убираем прошедшие времена
            ->orderBy('arrival_time')
            ->take(3) // Берем только первые три значения
            ->pluck('arrival_time') // Извлекаем только время прибытия
            ->toArray();

        return array_map(function($time) {
            return \Carbon\Carbon::parse($time)->format('H:i');
        }, $nextArrivals);
    }
    public function editRoute(Request $request, $routeId) {
        $request->validate([
            'stops' => 'required|array',
            'stops.*' => 'integer|exists:stops,id' // Убедитесь, что все указанные остановки существуют
        ]);
    
        // Удаляем старые остановки
        RouteStop::where('route_id', $routeId)->delete();
    
        // Добавляем новые остановки
        foreach ($request->stops as $stopId) {
            RouteStop::create([
                'route_id' => $routeId,
                'stop_id' => $stopId,
                'stop_order' => array_search($stopId, $request->stops) // Опционально, установите порядок
            ]);
        }
    
        return response()->json(['message' => 'Marshrut updated successfully']);
    }
}

