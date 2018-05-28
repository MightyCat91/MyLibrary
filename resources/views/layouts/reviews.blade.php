{{ \Debugbar::info($reviews->isNotEmpty(), $reviews) }}
@if($reviews->isNotEmpty())
    @push('styles')
        <link href="{{ asset('/css/Custom/reviews.css') }}" rel='stylesheet' type='text/css' media="all"/>
    @endpush
    @push('scripts')
        <script type="text/javascript" src="{{ asset('/js/Custom/reviews.js') }}"></script>
    @endpush
    <div id="reviews-container" data-url="{{ route('voteForReview') }}">
        <h2>Рецензии</h2>
        <hr>
        <div id="reviews-wrapper">
            @foreach($reviews as $review)
                <div class="review-item-container" data-id="{{ $review->id }}">
                    <div class="review-item-header">
                        <figure class="review-user-img">
                            <img src="{{ empty(getStorageFile('users', Auth::id())) ? asset('images/no_avatar.jpg') : asset($review->author_id) }}"
                                 alt="{{ $review->author }}">
                        </figure>
                        <div class="review-info-wrapper">
                            <div class="review-user-name">
                                <a href="{{ route('userProfile', $review->author_id) }}">{{ $review->author }}</a>
                            </div>
                            <div class="review-user-all-reviews">
                                (<a href="{{ route('getAllReviewsForUser', $review->author_id) }}">Все рецензии
                                    пользователя</a>)
                            </div>
                            <div class="review-rating-wrapper">
                                <div class="review-rating-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="review-rating-count">
                                    <div class="review-positive-count">+{{ $review->positive }}</div>
                                    <span>/</span>
                                    <div class="review-negative-count">-{{ $review->negative }}</div>
                                </div>
                            </div>
                            <div class="review-date">{{ explode(' ', $review->date)[0] }}</div>
                            <div class="review-user-book-status">{{ $review->status }}</div>
                        </div>
                    </div>
                    <div class="review-item-body">
                        {!! $review->text !!}
                    </div>
                    <div class="review-show-full">
                        <a href="#" class="">
                            <span class="show">Развернуть</span>
                            <span class="hide hidden">Свернуть</span>
                        </a>
                    </div>
                    <div class="review-action-wrapper">
                        <span>Вам была полезна данная рецензия:</span>
                        <div class="access-wrapper positive">
                            <i class="fas fa-thumbs-up"></i> Да
                        </div>
                        <span>/</span>
                        <div class="access-wrapper negative">
                            <i class="fas fa-thumbs-down"></i> Нет
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif