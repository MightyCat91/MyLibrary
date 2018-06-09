<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 13:44
 */

namespace MyLibrary\Comments;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use MyLibrary\Comments\Models\Comments as CommentsModel;

class Comments
{
    protected $table;
    protected $maxDepth;
    protected $commentsTree;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->table = config('comments.users');
        $this->maxDepth = 3;
        $this->commentsTree = [];
        Carbon::setLocale('ru');
    }

    public function addComment(Request $request)
    {
        \Debugbar::info($request->all());
        if (isset($request->parent_id)) {
            $parent_id = $request->parent_id;
            $parent_depth = CommentsModel::where('id', '=', $parent_id)->get(['depth'])->values();
            $depth = $parent_depth < $this->maxDepth ? $parent_depth + 1 : $this->maxDepth;
        }

        $newComment = new CommentsModel();
        $newComment->text = $request->text;
        $newComment->user_id = $request->user_id;
        $newComment->com_id = $request->com_id;
        $newComment->com_table = $request->com_table;
        $newComment->parent_id = $parent_id ?? null;
        $newComment->depth = $depth ?? 0;
        $newComment->date = Carbon::now();
        $newComment->save();
        return response()->json([
            'type' => 'success',
            'message' => 'Комментарий добавлен. Он появится после одобрения модератором.'
        ]);
    }

    public function showCommentsView($com_id, $com_table)
    {
        $comments = CommentsModel::where([
            ['com_id', '=', $com_id],
            ['com_table', '=', $com_table],
            ['approved', '=', true]
        ])->orderBy('date', 'desc')->get();
        $this->makeCommentsTree($comments);
        \Debugbar::info($this->commentsTree);
        return new HtmlString(
            view('comments::comments', [
                'comments' => $this->commentsTree,
                'url' => route(config('comments.route')),
                'com_id' => $com_id,
                'com_table' => $com_table
            ])->render()
        );
    }


    protected function makeCommentsTree($comments)
    {
        $parentComments = $comments->where('depth', 0)->toArray();
        foreach ($parentComments as $comment) {
            \Debugbar::info(Carbon::now()->toDateTimeString());
            \Debugbar::info(Carbon::parse($comment['date']));
            \Debugbar::info(Carbon::parse($comment['date'])->diffForHumans(Carbon::now()));
            $comment['date'] = Carbon::now()->timestamp - $comment['date'];
            $comment['user_name'] = User::where('id', $comment['user_id'])->first(['name'])->name;
            array_forget($comment, ['com_id', 'com_table']);
            $this->commentsTree[] = $comment;
            $this->makeChildTree($comments->where('parent_id', $comment['parent_id']));
        }
    }

    protected function makeChildTree($comments)
    {
        if ($comments->count() == 0) {
            \Debugbar::info('aaa');
            return;
        }
        if ($comments->count() == 1) {
            \Debugbar::info($comments);
            $comments['user_name'] = User::where('id', $comments['user_id'])->first(['name'])->name;
            $this->commentsTree[] = $comments;
        }
        $comments->each(function ($item, $key) {
            if ($parent_id = $item->parent_id) {
                $this->makeChildTree($item->where('parent_id', $parent_id));
            }
        });
    }
}