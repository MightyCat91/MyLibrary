@push('styles')
    <link href="{{ asset('/css/Custom/comments.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/comments.js') }}"></script>
@endpush
<section id="comments-container" data-url="{{ $url }}">
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
    <div id="comments-text-editor-wrapper">
        <textarea name="add-comment" class="commetns-text-editor"></textarea>
    </div>
    @isset($comments)
        @foreach ($comments as $comment)
            <div class="comment-wrapper">
                <figure class="comment-author-img-wrapper">
                    <img src="{{ empty(getStorageFile('users', $comment->user_id)) ? asset('images/no_avatar.jpg') :
                    asset(getStorageFile('users', $review->user_id)) }}"
                         class="comment-author-img" alt="{{ $comment->author }}">
                </figure>
                <div class="comment-content-wrapper">
                    <div class="comment-author-name-wrapper">
                        <div class="comment-author-name"></div>
                    </div>
                    <div class="comment-date-wrapper">
                        <div class="comment-date">{{ $comment->date }}</div>
                    </div>
                    <div class="comment-text-wrapper">
                        <div class="comment-text">{{ $comment->text }}</div>
                    </div>
                    <div class="comment-btn-wrapper">
                        <div class="comment-reply-btn-wrapper">
                            <a href="#" class="comment-reply-btn">Ответить</a>
                        </div>
                        <div>
                            <i class="fas fa-circle fa-xs"></i>
                        </div>
                        <div class="comment-rating-wrapper">
                            <div class="comment-rating">{{ $comment->rating }}</div>
                        </div>
                        <div>
                            <i class="fas fa-circle fa-xs"></i>
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
                </div>
            </div>
        @endforeach
    @endisset
</section>