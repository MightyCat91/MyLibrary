<div class="comment-wrapper depth-{{ $depthForUser ?? $comment['depth'] }}
{{ !isset($loop) ?: ($loop->iteration < $displayedCommentsCount) ? '' : 'hidden' }}"
     data-id="{{ $comment['id'] }}" data-authorID="{{ $comment['user_id'] }}">
    <figure class="comment-author-img-wrapper">
        <a href="{{ route('userProfile', $comment['user_id']) }}">
            <img src="{{ empty(getStorageFile('users', $comment['user_id'])) ? asset('images/no_avatar.jpg') :
                    asset(getStorageFile('users', $comment['user_id'])) }}"
                 class="comment-author-img" alt="{{ $comment['user_name'] }}">
        </a>
    </figure>
    <div class="comment-content-wrapper">
        <div class="comment-author-name-wrapper">
            <a href="{{ route('userProfile', $comment['user_id']) }}">
                <div class="comment-author-name">{{ $comment['user_name'] }}</div>
            </a>
            @isset($comment['parent_name'])
                <i class="fas fa-reply fa-xs reply"></i>
                <div class="parent-name-wrapper reply">{{ $comment['parent_name'] }}</div>
            @endisset
        </div>
        <div class="comment-date-wrapper">
            <div class="comment-date">{{ $comment['date'] }}</div>
        </div>
        <div class="comment-text-wrapper">
            @if($comment['deleted'])
                <div class="deleted-comment-text h6">Комментарий удален</div>
            @else
                <div class="comment-text">{!! $comment['text'] !!}</div>
            @endif
        </div>
        <div class="comment-btn-wrapper">
            @if(isset($depthForUser))
                @if(auth()->id() == $profile_id)
                    <div class="comments-delete-btn-wrapper">
                        <a href="#" class="comment-delete-btn">Удалить</a>
                    </div>
                @endif
            @endif
            @if(!isset($depthForUser))
                <div class="comment-reply-btn-wrapper">
                    <a href="#" class="comment-reply-btn">Ответить</a>
                </div>
            @endif
            <div class="comment-rating-wrapper">
                <div class="comment-rating {{ $comment['rating'] > 0 ? 'positive' : 'negative'}}">
                    {{ $comment['rating'] ?? 0}}
                </div>
            </div>
            <div class="comment-add-vote-wrapper">
                <div class="comment-add-vote positive">
                    <i class="far fa-plus-square"></i>
                </div>
                <span>/</span>
                <div class="comment-add-vote negative">
                    <i class="far fa-minus-square"></i>
                </div>
            </div>
        </div>
        <div class="comments-editor-container">
            <div class="inner comments-text-editor-wrapper"></div>
            <div class="inner add-comment-btn-wrapper hidden">
                <button class="btn submit-btn add-comment">
                    <span class="dflt-text">Добавить</span>
                </button>
            </div>
        </div>
    </div>
</div>