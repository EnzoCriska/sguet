<?php

namespace App\Http\Controllers\Api;

use App\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqApiController extends Controller
{
    /**
     * Ajax api tìm FAQ qua full text
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $q = $request->get('q');
        $result = Faq::search($q)->get();
        return response($result, 200);
    }

    public function destroy(Request $request)
    {
        if (!$request->has('id')) {
            abort(404);
        }

        /**
         * @var Faq $faq
         */
        $faq = Faq::findOrFail($request->get('id'));
        $faq->unsearchable();
        $faq->delete();

        $content = [
            'title' => 'Xoá Q&A',
            'message' => 'Đã xoá ' . $faq->question
        ];

        return response($content, 200);
    }
}
