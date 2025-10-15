<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function homePage(){
        return view('admin.homePage');
    }
    public function productManagement(){
        return view('admin.productManagement');
    }
    public function accountManagement(){
        return view('admin.accountManagement');
    }
    public function categoryManagement(){
        return view('admin.categoryManagement');
    }
    public function ingredientManagement(){
        return view('admin.ingredientManagement');
    }
    public function supplierManagement(){
        return view('admin.supplierManagement');
    }
    public function pos(){
        return view('admin.pointOfSale');
    }
}
