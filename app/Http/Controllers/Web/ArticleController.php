<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\DataTables\ArticleDatatable;
use App\Models\Tag;
use Datatables;
use Html;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use URL;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function index(ArticleDatatable $datatable)
    {
        return $datatable->render('article.index');
    }

    public function show($id) {
        /**
         * @var Article $article
         */
        $article = Article::findOrFail($id);
        $category = $article->category;
        $recents = $category->articles()->getQuery()
            ->where('id', '<>', $article->id)
            ->latest()
            ->take(4)
            ->get();
        return view('article.show', compact('article', 'category', 'recents'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('article.create', compact('categories'));
    }

    public function store(CreateArticleRequest $request)
    {
        $article = Article::create($request->only(['title', 'short_description', 'category_id', 'body', 'image_url']));
        if ($request->has('tags')) {
            $tags = [];
            foreach ($request->get('tags') as $tag_name) {
                /**
                 * @var Tag $tag
                 */
                $tag = Tag::firstOrCreate(['name' => $tag_name]);
                $tags[] = $tag->id;
            }
            $article->syncTags($tags);
        }

        \Toastr::append([
            'title' => 'Tạo mới Tin tức - Hoạt động',
            'message' => 'Đã tạo "' . $request->get('title') . '"',
        ]);
        return redirect()->route('articles.show', $article->id);
    }

    public function edit($id)
    {
        /**
         * @var Article $article
         */
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('article.edit', compact('article', 'categories'));
    }

    public function update($id, CreateArticleRequest $request)
    {
        /**
         * @var Article $article
         */
        $article = Article::findOrFail($id);
        $article->update($request->only(['title', 'short_description', 'category_id', 'body', 'image_url']));
        $tags = [];
        foreach ($request->get('tags', []) as $tag_name) {
            /**
             * @var Tag $tag
             */
            $tag = Tag::firstOrCreate(['name' => $tag_name]);
            $tags[] = $tag->id;
        }
        $article->syncTags($tags);

        \Toastr::append([
            'title' => 'Sửa Tin tức - Hoạt động',
            'message' => 'Đã cập nhật "' . $request->get('title') . '"',
        ]);
        return redirect()->route('articles.show', $article->id);
    }

    public function destroy($id)
    {
        /**
         * @var Article $article
         */
        $article = Article::findOrFail($id);
        $article->delete();

        \Toastr::append([
            'title' => 'Xoá Tin tức - Hoạt động',
            'message' => 'Đã xoá "' . $article->title . '"',
        ]);
        return redirect()->route('manage.article');
    }
}
