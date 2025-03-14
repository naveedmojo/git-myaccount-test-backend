<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query();

          
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->has('price_min')) {
                $query->where('price', '>=', $request->price_min);
            }

            if ($request->has('price_max')) {
                $query->where('price', '<=', $request->price_max);
            }

            if ($request->has('limited_edition')) {
                $query->where('is_limited_edition', $request->limited_edition);
            }

            if ($request->has('with_games')) {
                $query->where('is_with_games', $request->with_games);
            }

            if ($request->has('edition')) {
                $query->where('edition', $request->edition);
            }

           
            if ($request->has('latest') && $request->latest == true) {
                $query->orderBy('created_at', 'desc');
            }

           
            if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
                $query->orderBy('price', $request->sort);
            }

            $products = $query->paginate(12);

            return response()->json([
                'status' => true,
                'message' => 'Products fetched successfully',
                'data' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
