@push('styles')
    <link href="{{ asset('/css/Custom/comments.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/userComments.js') }}"></script>
@endpush
<section id="comments-block-container" class="forUser">
    <div id="comments-header-wrapper">
        <h2>Комментарии</h2> <span class="badge badge-secondary">{{ !empty($comments) ? count($comments) : '' }}</span>
        <hr>
    </div>
    <div id="comments-content-container">
        @if(!empty($comments))
            @foreach ($comments as $comment)
                @if(!$comment['deleted'])
                    @include('comments::comment', $comment)
                @endif
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
            displayedCommentsCount: '{{ $displayedCommentsCount }}',
            addVoteUrl: '{{ $urlAddVote }}',
            deleteCommentUrl: '{{ $deleteCommentUrl }}',
            user_id: '{{ auth()->id() }}'
        }
    </script>
</section>