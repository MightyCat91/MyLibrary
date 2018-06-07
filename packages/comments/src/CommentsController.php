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
use Illuminate\Support\HtmlString;
use Schema;
use MyLibrary\Comments\Models\Comments;

class CommentsController
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
        $this->commentsTree = collect();
    }

    public function addComment(\Request $request)
    {
        if (isset($request->parent_id)) {
            $parent_id = $request->parent_id;
            $parent_depth = Comments::where('id', '=', $parent_id)->get(['depth'])->values();
            $depth = $parent_depth < $this->maxDepth ? $parent_depth + 1 : $this->maxDepth;
        }

        $newComment = new Comments();
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
        $comments = Comments::where([
            ['com_id', '=', $com_id],
            ['com_table', '=', $com_table],
        ])->get()->sortByDesc('date');
        $this->makeCommentsTree($comments);

        \Debugbar::info($this->commentsTree);
        return new HtmlString(
            view('comments::comments')->with('comments', $this->commentsTree)->render()
        );
    }



    protected function makeCommentsTree($comments)
    {
        $parentComments = $comments->where('depth', 0);
        $parentComments->each(function ($item, $key) use ($comments) {
            $item->put('user_name', User::where('id',$item->user_id)->get(['name']));
            $this->commentsTree->push($item);
            $this->makeChildTree($item->where('parent_id', $item->parent_id));
        });
    }

    protected function makeChildTree($comments)
    {
        if ($comments->count() == 0) {
            return;
        }
        if ($comments->count() == 1) {
            $item->put('user_name', User::where('id',$item->user_id)->get(['name']));
            $this->commentsTree->push($comments);
        }
        $comments->each(function ($item, $key) {
            if ($parent_id = $item->parent_id) {
                $this->makeChildTree($item->where('parent_id', $parent_id));
            }
        });
    }

    protected function usersTableIsExist()
    {
        return Schema::hasTable($this->table);
    }
}