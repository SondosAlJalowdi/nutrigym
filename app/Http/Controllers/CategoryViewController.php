<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryViewController extends Controller
{
    public function showByCategory($name)
    {

        $category = Category::where('name', ucfirst($name))->firstOrFail();
        $services = $category->services()->with('ServiceProvider.user')->get();

        return view('user.categories', compact('category', 'services'));
    }
}
