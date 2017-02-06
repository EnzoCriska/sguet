<?php

namespace App\Http\Controllers;


use App\Faq;
use App\Tag;
use Datatables;
use Html;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use URL;

class FaqController extends Controller
{
    /**
     * ManageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $faqs = Faq::query()->select(['id', 'question', 'created_at', 'updated_at']);
            return Datatables::of($faqs)
                ->editColumn('question', function ($faq) {
                    return Html::link(URL::route('home') . '?faq=' . $faq->id, $faq->question, ['target' => '_blank']);
                })
                ->addColumn('action', function ($faq) {
                    return
                        Html::link(
                            URL::route('manage.faq.edit', ['id' => $faq->id]),
                            Html::tag('i', '', ['class' => 'fa fa-edit']) . 'Sửa',
                            ['class' => 'btn btn-sm btn-outline green'],
                            null, false
                        )
                        . Html::link(
                            URL::route('manage.faq.delete', ['id' => $faq->id]),
                            Html::tag('i', '', ['class' => 'fa fa-trash-o']) . 'Xoá',
                            ['class' => 'btn btn-sm btn-outline red'],
                            null, false
                        );
                })
                ->make(true);
        }

        return view('faq.index');
    }

    public function create()
    {
        return view('faq.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'tags' => 'array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Faq::withoutSyncingToSearch(function () use ($request) {
            $faq = Faq::create($request->only(['question', 'answer']));
            if ($request->has('tags')) {
                $tags = [];
                foreach ($request->get('tags') as $tag_name) {
                    /**
                     * @var Tag $tag
                     */
                    $tag = Tag::firstOrCreate(['name' => $tag_name]);
                    $tags[] = $tag->id;
                }
                $faq->syncTags($tags);
            }

            $faq->save();
            $faq->searchable();
        });

        \Session::flash('toastr', [
            [
                'title' => 'Tạo mới Q&A',
                'message' => 'Đã tạo "' . $request->get('question') . '"',
            ]
        ]);
        return redirect()->route('manage.faq');
    }

    public function edit($id)
    {
        /**
         * @var Faq $faq
         */
        $faq = Faq::findOrFail($id);
        return view('faq.edit', compact('faq'));
    }

    public function update($id, Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'tags' => 'array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        /**
         * @var Faq $faq
         */
        $faq = Faq::findOrFail($id);

        Faq::withoutSyncingToSearch(function () use ($request, $faq) {
            $faq->update($request->only(['question', 'answer']));

            if ($request->has('tags')) {
                $tags = [];
                foreach ($request->get('tags') as $tag_name) {
                    /**
                     * @var Tag $tag
                     */
                    $tag = Tag::firstOrCreate(['name' => $tag_name]);
                    $tags[] = $tag->id;
                }
                $faq->syncTags($tags);
            } else {
                $faq->removeTag();
            }

            $faq->save();
            $faq->searchable();
        });

        \Session::flash('toastr', [
            [
                'title' => 'Sửa Q&A',
                'message' => 'Đã cập nhật "' . $request->get('question') . '"',
            ]
        ]);
        return redirect()->route('manage.faq');
    }

    public function destroy($id)
    {
        /**
         * @var Faq $faq
         */
        $faq = Faq::findOrFail($id);
        $faq->unsearchable();
        $faq->delete();

        \Session::flash('toastr', [
            [
                'title' => 'Sửa Q&A',
                'message' => 'Đã xoá "' . $faq->question . '"',
            ]
        ]);
        return redirect()->route('manage.faq');
    }
}
