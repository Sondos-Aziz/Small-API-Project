<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use GeneralTrait;
    
    public function index(){
        // $categories = Category::get();
        // return response()-> json($categories);

        $categories = Category::select('id','name_'.app()->getLocale().' as name')->get();
        // return response()-> json($categories);
        return $this-> returnData('categories',$categories);

    }

     public function getCategoryById(Request $request){
        $category = Category::find($request->id);
            if(! $category)
            return  $this->returnError('001','the category is not exists');
            
        return $this-> returnData('category',$category);
    }


     public function changeStatus(Request $request){
        Category::where('id',$request->id)->update(['active' => $request->active]);
        return  $this->returnSuccessMessage('the status of category has been updated');
            
        }
}
