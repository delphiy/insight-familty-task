<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;

class HomeController extends Controller
{
    //We might need it in different methods in this class
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService) {
        $this->articleService = $articleService;
    }

    public function index()
    {
        return view('home', [
            'data' => $this->articleService->fetchArticles(10)
        ]);
    }
}
