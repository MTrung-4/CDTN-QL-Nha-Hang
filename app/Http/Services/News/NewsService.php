<?php

namespace App\Http\Services\News;


use App\Models\News;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NewsService
{

    public function insert($request)
    {
        try {
            $request->except('_token');
            News::create($request->input());
            Session::flash('success', 'Thêm tin mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm tin lỗi');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function get()
    {
        return News::orderByDesc('id')->paginate(15);
    }

    public function update($request, $news)
    {
        try {
            $news->fill($request->input());
            $news->save();
            Session::flash('success', 'Cập nhật tin thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật tin lỗi');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request)
    {
        $news = News::where('id', $request->input('id'))->first();
        if ($news) {
            $path = str_replace('storage', 'public', $news->thumb);
            Storage::delete($path);
            $news->delete();
            return true;
        }

        return false;
    }
}
