<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin, staff');
    }

    public function index()
    {
        $this->authorize('view', Review::class);
        $reviews = Review::where('status', 2)
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.review.list', [
            'title' => 'Danh Sách Bình Luận',
            'reviews' => $reviews
        ]);
    }

    public function destroy(Request $request)
    {
        $this->authorize('delete', Review::class);
        $review = Review::find($request->input('id'));

        if ($review) {
            $review->delete();

            if ($request->ajax()) {
                return response()->json([
                    'error' => false,
                    'message' => 'Xóa thành công bình luận'
                ]);
            }

            return redirect()->back()->with('success', 'Xóa thành công bình luận');
        }

        if ($request->ajax()) {
            return response()->json(['error' => true]);
        }

        return redirect()->back()->with('error', 'Không tìm thấy bình luận cần xóa');
    }


    //web
    public function store(Request $request)
    {
        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'rating' => $request->rating
        ]);

        if ($review) {
            Session::flash('success', 'Đánh giá đã được thêm thành công.');
        } else {
            Session::flash('error', 'Đã xảy ra lỗi khi thêm đánh giá.');
        }

        return redirect()->back();
    }

    //duyet
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 1;

    public function updateStatus(Request $request)
    {
        $this->authorize('update', Review::class);
        $reviewId = $request->input('review_id');
        $status = $request->input('status');

        if ($status === 'approved') {
            $status = self::STATUS_APPROVED;
        } elseif ($status === 'rejected') {
            $status = self::STATUS_REJECTED;
        }

        $review = Review::find($reviewId);

        if ($review) {
            $review->status = $status;
            $review->save();

            return response()->json(['success' => true, 'message' => 'Trạng thái của đánh giá đã được cập nhật thành công']);
        }

        return response()->json(['success' => false, 'message' => 'Không thể cập nhật trạng thái đánh giá']);
    }


    public function waiting()
    {
        $this->authorize('view', Review::class);
        $reviews = Review::whereNull('status')
            ->orderByDesc('id')->paginate(15);

        return view('admin.review.waiting', [
            'title' => 'Danh Sách Bình Luận Chờ Duyệt',
            'reviews' => $reviews,
        ]);
    }

    public function cancel()
    {
        $this->authorize('view', Review::class);
        $reviews = Review::where('status', 1)
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.review.list', [
            'title' => 'Danh Sách Bình Luận',
            'reviews' => $reviews
        ]);
    }
}
