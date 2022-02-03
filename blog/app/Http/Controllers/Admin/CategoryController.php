<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //pagina di categoria
    public function show($id)
    {
        return view('admin.categories.show');
    }
}
