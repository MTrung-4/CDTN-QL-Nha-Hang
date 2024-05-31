<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\News\NewsService;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $news;


    public function __construct(NewsService $news)
    {
        $this->news = $news;
    }

    public function create()
    {
        return view('admin.news.add', [
            'title' => 'Thêm tin Mới'
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:news,name',
        ], [
            'name.required' => 'Tiêu đề tin không được để trống',
            'name.unique' => 'Tiêu đề tin đã tồn tại',
        ]);
        $this->news->insert($request);

        return redirect()->back();
    }

    public function index()
    {

        return view('admin.news.list', [
            'title' => 'Danh Sách tin Mới Nhất',
            'news' => $this->news->get()
        ]);
    }

    public function edit(News $news)
    {

        return view('admin.news.edit', [
            'title' => 'Chỉnh Sửa tin',
            'news' => $news
        ]);
    }

    public function update(Request $request, News $news)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',

        ], [
            'name.required' => 'Tiêu đề tin không được để trống',
        ]);

        $result = $this->news->update($request, $news);
        if ($result) {
            return redirect('/admin/news/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {

        $result = $this->news->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công tin'
            ]);
        }

        return response()->json(['error' => true]);
    }


    public function showNews()
    {
        $news = News::where('active', 1)
            ->orderBy('id', 'desc')
            ->paginate(4);

        return view('news.news', [
            'title' => 'Trang tin tức',
            'news' => $news,
        ]);
    }


    public function showNewsDetail($id)
    {
        $news = News::findOrFail($id);

        return view('news.news_detail', [
            'title' => 'Chi Tiết Tin Tức',
            'news' => $news,
        ]);
    }
}
