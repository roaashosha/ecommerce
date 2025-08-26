<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use ApiResponseTrait;

    public function faq(){
        $page = Page::find(2);
        if (!$page){
            return $this->ApiResponse(null,"page is not found!",404);
        }
        return $this->ApiResponse(["title"=>$page->title,"content"=>$page->content],"Page is found!",200)->header('Content-Type', 'text/html');
    }
    public function aboutUs(){
        $page = Page::find(1);
        if (!$page){
            return $this->ApiResponse(null,"page is not found!",404);
        }
        return $this->ApiResponse(["title"=>$page->title,"content"=>$page->content],"Page is found!",200)->header('Content-Type', 'text/html');
    }

    public function legal(){
        $page = Page::find(3);
        if (!$page){
            return $this->ApiResponse(null,"page is not found!",404);
        }
        return $this->ApiResponse(["title"=>$page->title,"content"=>$page->content],"Page is found!",200)->header('Content-Type', 'text/html');
    }

    public function contacts(){
        $page = Page::find(4);
        if (!$page){
            return $this->ApiResponse(null,"page is not found!",404);
        }
        return $this->ApiResponse(["title"=>$page->title,"content"=>$page->content],"Page is found!",200)->header('Content-Type', 'text/html');
    }
}
