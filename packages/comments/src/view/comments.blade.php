@push('styles')
    <link href="{{ asset('/css/Custom/comments.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/comments.js') }}"></script>
@endpush
<section id="comments-container" data-url="{{ $url }}" data-id="{{ auth()->id() }}" data-comId="{{ $com_id }}"
         data-comTable="{{ $com_table }}">
    <h2>Комментарии</h2>
    <hr>
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
        <div id="comments-text-editor-wrapper">
            <textarea name="add-comment" class="commetns-text-editor"></textarea>
        </div>
    @endauth
    {{\Debugbar::info(!empty($comments))}}
    @if(!empty($comments))
        @foreach ($comments as $comment)
            {{\Debugbar::info($comment['id'])}}
            <div class="comment-wrapper">
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
                    </div>
                    {{--<div class="divider dot">--}}
                    {{--<i class="fas fa-circle fa-xs"></i>--}}
                    {{--</div>--}}
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
                        <div class="dot">
                            <i class="fas fa-circle fa-xs"></i>
                        </div>
                        @isset($comment['rating'])
                            <div class="comment-rating-wrapper">
                                <div class="comment-rating">{{ $comment['rating'] }}</div>
                            </div>
                            <div class="dot">
                                <i class="fas fa-circle fa-xs"></i>
                            </div>
                        @endisset
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
                </div>
            </div>
        @endforeach
    @else
        <div id="empty-comments"><h5>Комментариев нет</h5></div>
    @endif
</section>