<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter perPage dari request atau default ke 10
        $perPage = $request->query('per_page', 10);
        // Ambil halaman saat ini dari request atau default ke 1
        $currentPage = $request->query('page', 1);

        // Ambil parameter pencarian
        $searchBrand = $request->query('brand', null);
        $searchModel = $request->query('model', null);
        $searchPlateNumber = $request->query('plate_number', null);

        // Query dasar
        $query = Car::query();

        // Tambahkan kondisi pencarian jika ada
        if ($searchBrand) {
            $query->where('brand', 'like', "%{$searchBrand}%");
        }
        if ($searchModel) {
            $query->where('model', 'like', "%{$searchModel}%");
        }
        if ($searchPlateNumber) {
            $query->where('plate_number', 'like', "%{$searchPlateNumber}%");
        }

        // Ambil semua mobil dengan pagination
        $cars = $query->paginate($perPage);

        // Format respons
        $response = [
            'page' => $currentPage,
            'length' => $perPage,
            'dataCountAll' => Car::count(),
            'dataCountFiltered' => $cars->total(),
            'data' => $cars->items(),
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        $car = Car::getCarById($id);
        if ($car) {
            return response()->json($car);
        }
        return response()->json(['message' => 'Car not found'], 404);
    }

    public function store(Request $request)
    {
        $car = Car::createCar($request->all());
        return response()->json($car, 201);
    }

    public function update(Request $request, $id)
    {
        $car = Car::updateCarById($id, $request->all());
        if ($car) {
            return response()->json($car);
        }
        return response()->json(['message' => 'Car not found'], 404);
    }

    public function destroy($id)
    {
        if (Car::deleteCarById($id)) {
            return response()->json(['message' => 'Car deleted']);
        }
        return response()->json(['message' => 'Car not found'], 404);
    }
}
