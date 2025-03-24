<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        Log::info('API addcategory received a request', ['request_data' => $request->all()]);

        try {
            // Kiểm tra dữ liệu đầu vào
            $request->validate([
                'name' => 'required|string|unique:categories,name',
            ]);
            Log::info('Validation passed');

            // Lưu category vào database
            $category = Category::create([
                'name' => $request->name,
            ]);
            Log::info('Category created successfully', ['category' => $category]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category added successfully!',
                'data' => $category,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error in storing category', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
