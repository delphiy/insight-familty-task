<?php
namespace App\Services;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService {

    const FILE_PATH = '/app/json/articles.json';
    const IMAGE_PLACE_HOLDER = 'https://via.placeholder.com/150';

    /**
     * @param int $perPage
     * @return array
     */
    public function fetchArticles($perPage = 15) {
        $jsonData = json_decode(
            file_get_contents(storage_path() . self::FILE_PATH)
        );

        $articles = [];
        $data = $this->paginate($jsonData, $perPage);

        foreach ($data as $tempData) {
            if(!property_exists($tempData, 'attachments')) {
                continue;
            }

            $timestamp = substr($tempData->ts, 0, strpos($tempData->ts, '.'));

            $article = new \Stdclass();
            $article->title = $tempData->attachments[0]->title;
            $article->date= date('m/d/Y H:i:s', $timestamp); ;
            $article->image_url = $tempData->attachments[0]->image_url
                ?? self::IMAGE_PLACE_HOLDER;
            $article->original_url = $tempData->attachments[0]->original_url;
            $articles[] = $article;
        }

        return [
            'articles' => $articles,
            'links' => $data->links()
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     *
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage , $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
