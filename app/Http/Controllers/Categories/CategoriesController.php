<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index(){
        try {
            $users = Category::select('id','name',)->get();
            return response()->json([
                'data'=>$users,
                'message'=> 'Categories Retrieved Successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message'=> 'Error fetching categories'.$e->getMessage()], 500);
        }
    }
}
