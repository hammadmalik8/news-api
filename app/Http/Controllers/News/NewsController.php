<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function getFilteresNews(Request $request)
    {

        $author = $request->input('author');
        $title = $request->input('title');
        $category = $request->input('category');
        $source = $request->input('source');
        $publishDateStart = $request->input('publish_date_start'); // Assuming input name is 'publish_date_start'
        $publishDateEnd = $request->input('publish_date_end'); // Assuming input name is 'publish_date_end'

        $page = $request->input('pagesize', 1); // Default page number is 1
        $perPage = $request->input('perpage', 20); // Number of entries per page

        $query = News::orderBy('publishedAt', 'desc');

        $query->offset(($page - 1) * $perPage)
            ->limit($perPage);

        if ($author) {
            $query->where(function ($subQuery) use ($author) {
                $subQuery->where('author', 'LIKE', "%$author%");
            });
        }

        if ($title) {
            $query->where(function ($subQuery) use ($title) {
                $subQuery->where('title', 'LIKE', "%$title%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($source) {
            $query->where('source', $source);
        }

        if ($publishDateStart) {
            $carbonDateStart = Carbon::createFromFormat('Y-m-d', $publishDateStart)->startOfDay();
            $query->whereDate('publishedAt', '>=', $carbonDateStart);
        }

        if ($publishDateEnd) {
            $carbonDateEnd = Carbon::createFromFormat('Y-m-d', $publishDateEnd)->endOfDay();
            $query->whereDate('publishedAt', '<=', $carbonDateEnd);
        }

        $filteredNews = $query->get();

        return response()->json([
            'status' => 200,
            'page' => $page,
            'size' => count($filteredNews),
            'data' => $filteredNews,
        ]);
    }
}
