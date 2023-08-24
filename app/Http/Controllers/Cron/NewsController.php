<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\News;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function newsApi()
    {
        $apiKey = getenv('newsApi');
        $endpoint = getenv('newsApi_url');

        $page = 1;
        $pageSize = 100;

        $this->NYT();
        
        $this->technology($apiKey, $endpoint, $page, $pageSize);
        $this->business($apiKey, $endpoint, $page, $pageSize);
        $this->health($apiKey, $endpoint, $page, $pageSize);
        $this->science($apiKey, $endpoint, $page, $pageSize);
        $this->sports($apiKey, $endpoint, $page, $pageSize);
        $this->entertainment($apiKey, $endpoint, $page, $pageSize);
        $this->general($apiKey, $endpoint, $page, $pageSize);

        return;
    }

    /**
     * technology
     */

    public function technology($apiKey, $endpoint, $page, $pageSize)
    {
        $category = 'technology';

        $response = Http::get($endpoint, [
            'q' => $category,  // Example keyword
            'apiKey' => $apiKey,
            'page' => $page,
            'pageSize' => $pageSize,
        ]);

        $data = $response->json();

        if ($response->successful() && $data['status'] == 'ok') {
            $articles = $data['articles'];
            $this->store($articles, $category);
        } else {
            $errorMessage = $data['message'] ?? 'Unknown error';
            return;
        }
        return;
    }

    /**
     * Business
     */

    public function business($apiKey, $endpoint, $page, $pageSize)
    {
        $category = 'business';

        $response = Http::get($endpoint, [
            'q' => $category,  // Example keyword
            'apiKey' => $apiKey,
            'page' => $page,
            'pageSize' => $pageSize,
        ]);

        $data = $response->json();

        if ($response->successful() && $data['status'] == 'ok') {
            $articles = $data['articles'];
            $this->store($articles, $category);
        } else {
            $errorMessage = $data['message'] ?? 'Unknown error';
            error_log($errorMessage);
            return;
        }
        return;
    }

    /**
     * Business
     */

    public function health($apiKey, $endpoint, $page, $pageSize)
    {
        $category = 'health';

        $response = Http::get($endpoint, [
            'q' => $category,  // Example keyword
            'apiKey' => $apiKey,
            'page' => $page,
            'pageSize' => $pageSize,
        ]);

        $data = $response->json();

        if ($response->successful() && $data['status'] == 'ok') {
            $articles = $data['articles'];
            $this->store($articles, $category);
        } else {
            $errorMessage = $data['message'] ?? 'Unknown error';
            error_log($errorMessage);
            return;
        }
        return;
    }

    /**
     * science
     */

    public function science($apiKey, $endpoint, $page, $pageSize)
    {
        $category = 'science';

        $response = Http::get($endpoint, [
            'q' => $category,  // Example keyword
            'apiKey' => $apiKey,
            'page' => $page,
            'pageSize' => $pageSize,
        ]);

        $data = $response->json();

        if ($response->successful() && $data['status'] == 'ok') {
            $articles = $data['articles'];
            $this->store($articles, $category);
        } else {
            $errorMessage = $data['message'] ?? 'Unknown error';
            error_log($errorMessage);
            return;
        }
        return;
    }

    /**
     * sports
     */

    public function sports($apiKey, $endpoint, $page, $pageSize)
    {
        $category = 'sports';

        $response = Http::get($endpoint, [
            'q' => $category,  // Example keyword
            'apiKey' => $apiKey,
            'page' => $page,
            'pageSize' => $pageSize,
        ]);

        $data = $response->json();

        if ($response->successful() && $data['status'] == 'ok') {
            $articles = $data['articles'];
            $this->store($articles, $category);
        } else {
            $errorMessage = $data['message'] ?? 'Unknown error';
            error_log($errorMessage);
            return;
        }
        return;
    }

    /**
     * entertainment
     */

    public function entertainment($apiKey, $endpoint, $page, $pageSize)
    {
        $category = 'entertainment';

        $response = Http::get($endpoint, [
            'q' => $category,  // Example keyword
            'apiKey' => $apiKey,
            'page' => $page,
            'pageSize' => $pageSize,
        ]);

        $data = $response->json();

        if ($response->successful() && $data['status'] == 'ok') {
            $articles = $data['articles'];
            $this->store($articles, $category);
        } else {
            $errorMessage = $data['message'] ?? 'Unknown error';
            error_log($errorMessage);
            return;
        }
        return;
    }

    /**
     * general
     */

    public function general($apiKey, $endpoint, $page, $pageSize)
    {
        $category = 'general';

        $response = Http::get($endpoint, [
            'q' => $category,  // Example keyword
            'apiKey' => $apiKey,
            'page' => $page,
            'pageSize' => $pageSize,
        ]);

        $data = $response->json();

        if ($response->successful() && $data['status'] == 'ok') {
            $articles = $data['articles'];
            $this->store($articles, $category);
        } else {
            $errorMessage = $data['message'] ?? 'Unknown error';
            error_log($errorMessage);
            return;
        }
        return;
    }

    /**
     * Store news in Database
     */

    public function store($articles, $category)
    {
        
        foreach ($articles as $article) {

            try {
                
                if ($article['author'] !== null && $article['urlToImage'] !== null) {
                    $news = new News;
                    $news->author = $article['author'];
                    $news->title = $article['title'];
                    $news->content = $article['description'];
                    $news->category = $category;
                    $news->source = 'News Api';
                    $news->urlToImage = $article['urlToImage'];
                    $news->url = $article['url'];
                    $news->publishedAt = $article['publishedAt'];
                    $news->save();
                }
                // $articles = array_merge($articles, $data['articles']);
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
        return;
    }

    /**
     * New York Time(NYT)
     */

    public function NYT()
    {
        $apiKey = getenv('nytime');
        $endpoint = getenv('nytime_url');
        
        $this->NYKtechnology($apiKey, $endpoint);
        $this->NYKbusiness($apiKey, $endpoint);
        $this->NYKhealth($apiKey, $endpoint);
        $this->NYKscience($apiKey, $endpoint);
        $this->NYKsports($apiKey, $endpoint);
        $this->NYKentertainment($apiKey, $endpoint);
        $this->NYKgeneral($apiKey, $endpoint);

        return;
    }

    /**
     * NYKtechnology
     */
    public function NYKtechnology($apiKey, $endpoint)
    {
        $category = 'technology';
        $response = Http::get($endpoint, [
            'q' => $category,
            'api-key' => $apiKey,
        ]);
        $data = $response->json();
        if (isset($data['response']['docs']) && !empty($data['response']['docs'])) {
            $articles = $data['response']['docs'];
            $this->NYKStore($articles, $category);
        }
        return;
    }

    /**
     * NYKhealth
     */
    public function NYKhealth($apiKey, $endpoint)
    {
        $category = 'health';
        $response = Http::get($endpoint, [
            'q' => $category,
            'api-key' => $apiKey,
        ]);
        $data = $response->json();
        if (isset($data['response']['docs']) && !empty($data['response']['docs'])) {
            $articles = $data['response']['docs'];
            $this->NYKStore($articles, $category);
        }
        return;
    }

    /**
     * NYKscience
     */
    public function NYKscience($apiKey, $endpoint)
    {
        $category = 'science';
        $response = Http::get($endpoint, [
            'q' => $category,
            'api-key' => $apiKey,
        ]);
        $data = $response->json();
        if (isset($data['response']['docs']) && !empty($data['response']['docs'])) {
            $articles = $data['response']['docs'];
            $this->NYKStore($articles, $category);
        }
        return;
    }

    /**
     * NYKsports
     */
    public function NYKsports($apiKey, $endpoint)
    {
        $category = 'sports';
        $response = Http::get($endpoint, [
            'q' => $category,
            'api-key' => $apiKey,
        ]);
        $data = $response->json();
        if (isset($data['response']['docs']) && !empty($data['response']['docs'])) {
            $articles = $data['response']['docs'];
            $this->NYKStore($articles, $category);
        }
        return;
    }

    /**
     * NYKentertainment
     */
    public function NYKentertainment($apiKey, $endpoint)
    {
        $category = 'entertainment';
        $response = Http::get($endpoint, [
            'q' => $category,
            'api-key' => $apiKey,
        ]);
        $data = $response->json();
        if (isset($data['response']['docs']) && !empty($data['response']['docs'])) {
            $articles = $data['response']['docs'];
            $this->NYKStore($articles, $category);
        }

        return;
    }

    /**
     * NYKgeneral
     */
    public function NYKgeneral($apiKey, $endpoint)
    {
        $category = 'general';
        $response = Http::get($endpoint, [
            'q' => $category,
            'api-key' => $apiKey,
        ]);
        $data = $response->json();
        if (isset($data['response']['docs']) && !empty($data['response']['docs'])) {
            $articles = $data['response']['docs'];
            $this->NYKStore($articles, $category);
        }
        return;
    }

    /**
     * NYKbusiness
     */
    public function NYKbusiness($apiKey, $endpoint)
    {
        $category = 'business';
        $response = Http::get($endpoint, [
            'q' => $category,
            'api-key' => $apiKey,
        ]);
        $data = $response->json();
        if (isset($data['response']['docs']) && !empty($data['response']['docs'])) {
            $articles = $data['response']['docs'];
            $this->NYKStore($articles, $category);
        }
        return;
    }

    /**
     * New York Time(NYK) 
     * Store
     * DataBase
     */
    public function NYKStore($articles, $category)
    {

        foreach ($articles as $article) {
            if (isset($article['multimedia']) && !empty($article['multimedia'])) {
                $image = $this->findImageURL($article['multimedia']);
            }

            try {
                if (isset($article['byline']['original']) && $image !== null) {
                    $news = new News;
                    $news->author = $article['byline']['original'];
                    $news->title = $article['headline']['main'];
                    $news->content = $article['snippet'];
                    $news->category = $category;
                    $news->source = 'New York Times';
                    $news->urlToImage = getenv('img_base_url') . $image;
                    $news->url = $article['web_url'];
                    $news->publishedAt = $article['pub_date'];
                    $news->save();
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
        return;
    }

    private function findImageURL($multimedia)
    {
        foreach ($multimedia as $item) {
            if ($item['type'] === 'image' && $item['subtype'] === 'xlarge') {
                return $item['url'];
            }
        }
        return null;
    }
}
