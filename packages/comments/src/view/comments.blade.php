@push('styles')
    <link href="{{ asset('/css/Custom/comments.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/comments.js') }}"></script>
@endpush
<section id="comments-block-container" data-url="{{ $urlAddComment }}" data-id="{{ auth()->id() }}"
         data-comTable="{{ $com_table }}" data-comId="{{ $com_id }}" data-dispComCount="{{ $displayedCommentsCount }}">
    <div id="comments-header-wrapper">
        <h2>Комментарии</h2> <span class="badge badge-secondary">{{ !empty($comments) ? count($comments) : '' }}</span>
        <hr>
    </div>
    <div id="comments-sort-wrapper">
        <div>Сортировать:</div>
        <div class="dropdown">
            <a href="#" id="comments-sort-menu" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">Cначала лучшие</a>

            <div class="dropdown-menu" aria-labelledby="comments-sort-menu">
                <a href="#" class="dropdown-item">Cначала лучшие</a>
                <a href="#" class="dropdown-item">Сначала новые</a>
                <a href="#" class="dropdown-item">Сначала старые</a>
            </div>
        </div>
    </div>
    @auth
        <div class="comments-editor-container">
            <div class="comments-text-editor-wrapper"></div>
            <div class="add-comment-btn-wrapper">
                <button class="btn submit-btn add-comment">
                    <span class="dflt-text">Добавить</span>
                </button>
            </div>
        </div>
    @endauth
    <div id="comments-content-container">
        @if(!empty($comments))
            @foreach ($comments as $comment)
                <div class="comment-wrapper depth-{{ $comment['depth'] }} {{ ($loop->iteration < $displayedCommentsCount) ?: 'hidden' }}"
                     data-id="{{ $comment['id'] }}">
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
                            <div class="comment-text">{!! $comment['text'] !!}</div>
                        </div>
                        <div class="comment-btn-wrapper">
                            <div class="comment-reply-btn-wrapper">
                                <a href="#" class="comment-reply-btn">Ответить</a>
                            </div>
                            <div class="comment-rating-wrapper">
                                <div class="comment-rating {{ $comment['rating'] > 0 ? 'positive' : 'negative'}}">
                                    {{ $comment['rating'] ?? 0}}
                                </div>
                            </div>
                            <div class="comment-add-vote-wrapper" data-url="{{ $urlAddVote }}">
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
            @endforeach
            @if(count($comments) > $displayedCommentsCount)
                <div id="show-all-comments-btn-wrapper">
                    <button type="button" class="btn submit-btn">Показать все комментарии</button>
                </div>
            @endif
        @else
            <div id="empty-comments"><h5>Комментариев нет</h5></div>
        @endif
    </div>
</section>