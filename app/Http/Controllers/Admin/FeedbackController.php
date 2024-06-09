<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendThankYouEmail;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin, staff');
    }

    public function store(Request $request)
    {
        try {
            // Validate form data
            $request->validate([
                'email' => 'required|email',
                'message' => 'required',
            ]);

            // Lưu phản hồi vào cơ sở dữ liệu
            $feedback = Feedback::create([
                'email' => $request->input('email'),
                'message' => $request->input('message'),
            ]);

            // Gửi email cảm ơn cho khách hàng thông qua job
            SendThankYouEmail::dispatch($feedback)->delay(now()->addSeconds(2));

            return redirect()->back()->with('success', 'Phản hồi của bạn đã được gửi đi. Cảm ơn bạn đã liên hệ!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tạo phản hồi. Vui lòng thử lại sau.');
        }
    }

    //admin
    public function show()
    {
        $this->authorize('view', Feedback::class);
        $feedbacks = Feedback::orderByDesc('id')->paginate(15);

        return view(
            'admin.feedback.list',
            [
                'title' => 'Trang Phản Hồi',
                'feedbacks' => $feedbacks,
            ]
        );
    }

    public function destroy(Request $request)
    {
        $feedbacks = Feedback::where('id', $request->input('id'))->first();

        if ($feedbacks) {
            $path = str_replace('storage', 'public', $feedbacks->thumb);
            Storage::delete($path);
            $feedbacks->delete();

            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công tin'
            ]);
        }

        return response()->json(['error' => true]);
    }
}
