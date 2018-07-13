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
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use MyLibrary\Comments\Models\Comments as CommentsModel;

class Comments
{
    // имя таблицы пользователей - автором комментариев
    protected $table;
    // максиманая вложенность комментариев
    protected $maxDepth;
    // упорядоченный структурированный массив комментариев
    protected $commentsTree;
    // необходимость модерации
    protected $needModerate;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->table = config('comments.users');
        $this->needModerate = config('comments.moderate');
        $this->maxDepth = 3;
        $this->commentsTree = [];
        Carbon::setLocale('ru');
    }

    /**
     * Добавление комментария
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request)
    {
        // если комментарий является ответом на другой комментарий, то определяем
        if (!empty($request->parent_id)) {
            // идентификатор родительского комментария
            $parent_id = $request->parent_id;
            // коллекцию автора и уровень вложенности род. комментария
            $parent_comment = CommentsModel::where('id', '=', $parent_id)->first(['user_id', 'depth']);
            // уровень вложенности род. комментария
            $parent_depth = $parent_comment->depth;
            // уровень вложенности добавляемого комментария
            $depth = $parent_depth < $this->maxDepth ? $parent_depth + 1 : $this->maxDepth;
            // имя автора родительского комментария
            $parent_name = $this->getUserName($parent_comment->user_id);
        }
        // формируем и добавляем новый комментарий в БД
        $newComment = new CommentsModel();
        $newComment->text = $request->text;
        $newComment->user_id = $request->user_id;
        $newComment->com_id = $request->com_id;
        $newComment->com_table = $request->com_table;
        $newComment->parent_id = $parent_id ?? null;
        $newComment->depth = $depth ?? 0;
        $newComment->date = Carbon::now();
        $newComment->approved = !$this->needModerate;
        $newComment->save();
        // если комментарии нуждаются в модерации, то формируем соответсвующий ответ
        if ($this->needModerate) {
            $response = response()->json([
                'type' => 'success',
                'message' => config('comments.message.addWithModerate')
            ]);
        } else {
            // иначе формируем ответ содержащий новый комментарий, для дальнейшего его отображения
            $response = response()->json([
                'type' => 'success',
                'message' => config('comments.message.addWithoutModerate'),
                'comment' => view('comments::comment', [
                    'comment' => [
                        'id' => $newComment->id,
                        'user_id' => $request->user_id,
                        'parent_id' => $parent_id ?? null,
                        'depth' => $depth ?? 0,
                        'text' => $request->text,
                        'rating' => 0,
                        'date' => Carbon::now()->diffForHumans(Carbon::now()),
                        'user_name' => $this->getUserName($request->user_id),
                        'parent_name' => $parent_name ?? null
                    ]
                ])->render()
            ]);
        }
        return $response;
    }

    /**
     * Отображение комментариев
     *
     * @param $com_id int идентификатор комментируемой сущности в соответсвуюшей таблице
     * @param $com_table string имя таблицы комментируемой сущности
     * @return HtmlString
     */
    public function showCommentsView($com_id, $com_table)
    {
        // получение всех комментариев соответсвующих имени таблицы сущности и идентификтору в ней
        $comments = CommentsModel::where([
            ['com_id', '=', $com_id],
            ['com_table', '=', $com_table],
            ['approved', '=', true]
        ])->orderBy('date', 'desc')->get();
        // формирование упорядоченного структурированного массива
        $this->makeCommentsTree($comments);
        // рендер шаблона комментариев
        return $this->renderView($com_id, $com_table);
    }

    /**
     * Изменение оценки комментария
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addVoteToComment(Request $request)
    {
        // новая оценка комментария
        $newRating = $request->type === 'positive' ? $request->rating + 1 : $request->rating - 1;
        // обновление оценки в базе
        DB::table('comments')
            ->where('id', $request->id)
            ->update(['rating' => $newRating]);
        // возврат нового значения
        return response()->json([
            'type' => 'success',
            'message' => config('comments.message.addVote'),
            'rating' => $newRating
        ]);
    }

    /**
     * Фильтрация комментариев
     *
     * @param Request $request
     * @return HtmlString
     */
    public function filterComments(Request $request)
    {
        // параметр, по которому происходит фильтрация
        $type = $request->filterType;
        // направление фильтрации
        $direction = $request->direction;
        // массив идентификаторов комментариев
        $commentsId = $request->ids;
        // получение коллекции комментариев соответсвующих идентификаторам из массива и отсортиртированных по
        // заданному параметру
        $comments = CommentsModel::whereIn('id', $commentsId)->orderBy($type, $direction)->get();
        // формирование упорядоченного структурированного массива
        $this->makeCommentsTree($comments);
        // рендер
        return $this->renderView($request->com_id, $request->com_table);
    }

    public function approveComment()
    {

    }

    /**
     * Удаление комментария(-ев)
     *
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComments(Request $request)
    {
        // помечаем комментарий как удаленный
        CommentsModel::where('id', $request->id)->update(['deleted' => true]);
        return response()->json([
            'type' => 'success',
            'message' => config('comments.message.deleteComment')
        ]);
    }

    /**
     * Отображение всех комментариев для пользователя
     *
     * @param $id int идентификатор пользователя
     * @return HtmlString
     */
    public function showAllCommentsForUser($id)
    {
        $this->commentsTree = CommentsModel::where([
            ['user_id', '=', $id],
            ['approved', '=', true]
        ])->orderBy('date', 'desc')->get()->toArray();

        // подготавливаем все комментарии в результируеющем массиве к рендеру
        array_walk($this->commentsTree, function ($value, $key) {
            $this->prepareComment($key);
        });
        return new HtmlString(
            view('comments::allUserComments', [
                'profile_id' => $id,
                'depthForUser' => 0,
                'comments' => $this->commentsTree,
                'urlAddVote' => route(config('comments.addVoteToCommentRoute')),
                'displayedCommentsCount' => config('comments.displayedCommentsCount'),
                'deleteCommentUrl' => route(config('comments.deleteCommentRoute'))
            ])->render());
    }


    /**
     * Формирование упорядоченного структурированного массива комментариев
     *
     * @param $comments Collection коллекция комментариев
     */
    protected function makeCommentsTree($comments)
    {
        // в результирующий массив добавляем все комментарии с уровнем вложенности 0, т.е. не являющиеся ответами на
        // другой комментарий
        $this->commentsTree = $comments->where('depth', 0)->values()->toArray();
        // формируем массив комментариев, являющихся ответом на какой-либо другой комментарий, упорядоченный по
        // идентификатору родительского комметария
        $childComments = $comments->where('depth', "<>", 0)->groupBy('parent_id')->values()->toArray();
        // для каждой группы комментариев
        foreach ($childComments as $groupComments) {
            // определяем идентификатор родительского комментария
            $parent_id = $groupComments[0]['parent_id'];
            // в результирующем массиве находим родительский комментарий и добавляем текущую группу дочерних
            // комментариев после него
            array_walk($this->commentsTree, function ($value, $key) use ($parent_id, $groupComments) {
                if ($value['id'] === $parent_id) {
                    array_splice($this->commentsTree, $key + 1, 0, $groupComments);
                }
            });
        }
        // подготавливаем все комментарии в результируеющем массиве к рендеру
        array_walk($this->commentsTree, function ($value, $key) {
            $this->prepareComment($key);
        });
    }

    /**
     * Подготовка комментария к рендеру
     *
     * @param $key int ключ подговтавливаемого комментария из результирующего массива
     */
    protected function prepareComment($key)
    {
        // комментарий
        $comment = $this->commentsTree[$key];
        // идентификатор родительского комментария
        $parentCommentId = $comment['parent_id'];
        // если он не пустой, то добавляем данному комментарию поле с именем автора род. комментария
        if ($parentCommentId) {
            $parentUserId = array_first($this->commentsTree, function ($value, $key) use ($parentCommentId) {
                return $value['id'] == $parentCommentId;
            })['user_id'];
            $this->commentsTree[$key]['parent_name'] = User::where('id', $parentUserId)->first(['name'])->name;
        }
        // добавляем отформатированную дату создания комментария
        $this->commentsTree[$key]['date'] = Carbon::parse($comment['date'])->diffForHumans(Carbon::now());
        // добавляем имя автора комментария
        $this->commentsTree[$key]['user_name'] = $this->getUserName($comment['user_id']);
        // удаляем неиспользуемые поля
        array_forget($this->commentsTree[$key], ['com_id', 'com_table', 'created_at', 'updated_at', 'approved']);
    }

    /**
     * Получение имени пользователя по его идентификатору
     *
     * @param $id int идентификатор пользователя
     * @return mixed
     */
    protected function getUserName($id)
    {
        return User::where('id', $id)->first(['name'])->name;
    }

    /**
     * Рендер шаблона в html-строку
     *
     * @param $com_id int идентификатор в таблице комментируемой сущности
     * @param $com_table string имя таблицы комментируемой сущности
     * @return HtmlString
     */
    protected function renderView($com_id, $com_table)
    {
        return new HtmlString(
            view('comments::comments', [
                'comments' => $this->commentsTree,
                'urlAddComment' => route(config('comments.addCommentRoute')),
                'urlAddVote' => route(config('comments.addVoteToCommentRoute')),
                'displayedCommentsCount' => config('comments.displayedCommentsCount'),
                'filterUrl' => route(config('comments.filterCommentRoute')),
                'com_id' => $com_id,
                'com_table' => $com_table
            ])->render());
    }
}