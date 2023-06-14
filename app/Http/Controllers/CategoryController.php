<?php

namespace App\Http\Controllers;

use App\Http\Utils\Constants;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json(['status' => Constants::$statusSuccess, 'categories' => $categories]);
        } catch (\Exception $e) {
            return response()->json(['status' => Constants::$statusError, 'message' => Constants::$errorGenericMessage]);
        }
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'name' => 'required',
            ]);

            $category = Category::create($validated);

            return response()->json(['status' => Constants::$statusSuccess, 'message' => Constants::$messageCategoryCreated, 'category' => $category]);

        } catch (\Throwable $e) {

            return response()->json(['status' => Constants::$statusError, 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {

        $category = Category::find($id);

        if($category == null){
            return response()->json(['status' => Constants::$statusError, 'message' => Constants::$errorCategoryNotFound]);
        }

        return response()->json(['status' => Constants::$statusSuccess, 'category' => $category]);
    }

    public function update(Request $request, $id)
    {
        try {

            $validated = $request->validate([
                'name' => 'required',
            ]);

            $category = Category::find($id);

            if($category == null){
                return response()->json(['status' => Constants::$statusError, 'message' => Constants::$errorCategoryNotFound]);
            }

            $category->update($validated);

            return response()->json(['status' => Constants::$statusSuccess, 'message' => Constants::$messageCategoryUpdated, 'category' => $category]);

        } catch (\Throwable $e) {

            return response()->json(['status' => Constants::$statusError, 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {

            $category = Category::find($id);

            if($category == null){
                return response()->json(['status' => Constants::$statusError, 'message' => Constants::$errorCategoryNotFound]);
            }

            $category->delete();

            return response()->json(['status' => Constants::$statusSuccess, 'message' => Constants::$messageCategoryDeleted]);

        } catch (\Throwable $e) {

            return response()->json(['status' => Constants::$statusError, 'message' => $e->getMessage()]);
        }
    }

}
