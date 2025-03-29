<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $products = Product::with('subCategory')->paginate(10);
    
            return response()->json([
                'success' => true,
                'data' => $products->items(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve products',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'sub_category_id' => 'required|exists:sub_categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_sold' => 'boolean',
                'type' => 'nullable|string',
                'years_used' => 'nullable|integer',
            ]);

            $data = $request->all();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product = Product::create($data);
            return response()->json(['success' => true, 'message' => 'Product created successfully', 'data' => $product], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to create product', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'sub_category_id' => 'required|exists:sub_categories,id',
                'description' => 'nullable|string',
                'price' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
                'is_sold' => 'boolean',
                'type' => 'nullable|string',
                'years_used' => 'nullable|integer',
                
                // Max 2MB
            ]);
    
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }
    
            // Create subcategory
            $product = Product::create([
                'name' => $request->name,
                'sub_category_id' => $request->sub_category_id,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $imagePath,
                'is_sold' => $request->is_sold,
                'type' => $request->type,
                'years_used' => $request->years_used,

            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Product created successfully!',
                'data' => $product
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating product!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            return response()->json(['success' => true, 'data' => $product->load('subCategory')], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to retrieve product', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|required|numeric|min:0',
                'sub_category_id' => 'sometimes||exists:sub_categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_sold' => 'boolean',
                'type' => 'nullable|string',
                'years_used' => 'nullable|integer',
            ]);

            $product->update($request->only(['name', 'sub_category_id', 'description', 'price','is_sold','type','years_used']));

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                // Store new image
                $imagePath = $request->file('image')->store('products', 'public');
                $product->update(['image' => $imagePath]); // Update image separately
            }
    

            
            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully',
                'data' => $product
            ], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            // Delete image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
    
            $product->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'product deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'product not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
}
