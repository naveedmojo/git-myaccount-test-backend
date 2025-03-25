<?php

namespace App\Http\Controllers;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    public function mainindex(){
        try {
            $categories = MainCategory::all();
            return response()->json([
                'status' => true,
                'message' => 'Main categories retrieved successfully',
                'data' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch main categories',
                'error' => $e->getMessage()
            ], 500);
        } 
    }
    public function mainstore(){
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
            ]);
    
            // Initialize image path as null
            $imagePath = null;
    
            // Check if an image is uploaded
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('main_categories', 'public');
            }
    
            // Create the main category
            $category = MainCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $imagePath,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Main category created successfully!',
                'data' => $category
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating main category!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function mainupdate(Request $request, $id){
        try {
            $category = MainCategory::findOrFail($id);

            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('image')) {
                // Delete old image
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $category->image = $request->file('image')->store('main_categories', 'public');
            }

            $category->update($request->only(['name', 'description', 'image']));

            return response()->json([
                'status' => true,
                'message' => 'Main category updated successfully',
                'data' => $category
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Main category not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update main category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function maindestroy($id){
        try {
            $category = MainCategory::findOrFail($id);

            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Main category deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Main category not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete main category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function subindex(){
        try {
            $categories = SubCategory::all();
            return response()->json([
                'status' => true,
                'message' => 'sub categories retrieved successfully',
                'data' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch sub categories',
                'error' => $e->getMessage()
            ], 500);
        } 
        }
    public function substore(Request $request){
        try {
            // Validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'main_category_id' => 'required|exists:main_categories,id',
                'description' => 'nullable|string',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
            ]);
    
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('sub_categories', 'public');
            }
    
            // Create subcategory
            $subcategory = SubCategory::create([
                'name' => $request->name,
                'main_category_id' => $request->main_category_id,
                'description' => $request->description,
                'stock' => $request->stock,
                'image' => $imagePath,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Subcategory created successfully!',
                'data' => $subcategory
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating subcategory!',
                'error' => $e->getMessage()
            ], 500);
        }
        }
        public function subupdate(Request $request, $id) {
            try {
                $subcategory = SubCategory::findOrFail($id);
        
                $request->validate([
                    'name' => 'sometimes|required|string|max:255',
                    'main_category_id' => 'sometimes|required|exists:main_categories,id',
                    'description' => 'nullable|string',
                    'stock' => 'sometimes|required|integer|min:0',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
                ]);
        
                // Update fields except image
                $subcategory->update($request->only(['name', 'main_category_id', 'description', 'stock']));
        
                // Handle image update
                if ($request->hasFile('image')) {
                    // Delete old image if exists
                    if ($subcategory->image) {
                        Storage::disk('public')->delete($subcategory->image);
                    }
                    // Store new image
                    $imagePath = $request->file('image')->store('sub_categories', 'public');
                    $subcategory->update(['image' => $imagePath]); // Update image separately
                }
        
                return response()->json([
                    'status' => true,
                    'message' => 'Subcategory updated successfully',
                    'data' => $subcategory
                ], 200);
            
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to update subcategory',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        
    public function subdestroy(){
        try {
            $subcategory = SubCategory::findOrFail($id);
    
            // Delete image if exists
            if ($subcategory->image) {
                Storage::disk('public')->delete($subcategory->image);
            }
    
            $subcategory->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Subcategory deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Subcategory not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete subcategory',
                'error' => $e->getMessage()
            ], 500);
        }
        }
    
}
