@push('styles')
    <link href="{{ asset('/css/Custom/comments.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/comments.js') }}"></script>
@endpush
<section id="comments-block-container" data-url="{{ $urlAddComment }}" data-id="{{ auth()->id() }}"
         data-comTable="{{ $com_table }}" data-comId="{{ $com_id }}" data-dispComCount="{{ $displayedCommentsCount }}"
         data-url-addVote="{{ $urlAddVote }}">
    <div id="comments-header-wrapper">
        <h2>Комментарии</h2> <span class="badge badge-secondary">{{ !empty($comments) ? count($comments) : '' }}</span>
        <hr>
    </div>
    <div id="comments-sort-wrapper">
        <div>Сортировать:</div>
        <div class="dropdown">
            <a href="#" id="comments-sort-menu" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">Сначала новые</a>

            <div class="dropdown-menu" aria-labelledby="comments-sort-menu" data-filterUrl="{{ $filterUrl }}">
                <div class="dropdown-item" data-type="ndate">Сначала новые</div>
                <div class="dropdown-item" data-type="rating">Cначала лучшие</div>
                <div class="dropdown-item" data-type="odate">Сначала старые</div>
            </div>
        </div>
    </div>
    <div class="comments-editor-container">
        <div class="comments-text-editor-wrapper"></div>
        <div class="add-comment-btn-wrapper">
            <button class="btn submit-btn add-comment">
                <span class="dflt-text">Добавить</span>
            </button>
        </div>
    </div>
    <div id="comments-content-container">
        @if(!empty($comments))
            @foreach ($comments as $comment)
                @include('comments::comment', $comment)
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
    <script>
        window.Laravel = {
            user: '{{auth()->check()}}'
        }
    </script>
</section>