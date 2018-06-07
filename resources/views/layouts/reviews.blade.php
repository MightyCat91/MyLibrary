@if($reviews->isNotEmpty())
    @push('styles')
        <link href="{{ asset('/css/Custom/reviews.css') }}" rel='stylesheet' type='text/css' media="all"/>
    @endpush
    @push('scripts')
        <script type="text/javascript" src="{{ asset('/js/Custom/reviews.js') }}"></script>
    @endpush
    <div id="reviews-container" data-url="{{ route('voteForReview') }}">
        @if(!isset($isForUser))
            <h2>Рецензии</h2>
            <hr>
        @endif
        <div id="reviews-wrapper">
            @foreach($reviews as $review)
                <div class="review-item-container" data-id="{{ $review->id }}">
                    <div class="review-item-header">
                        <figure class="review-user-img">
                            @if(isset($isForUser))
                                <a href="{{ route('book', $review->book_id) }}">
                                    <img src="{{ asset(getStorageFile('books', $review->book_id)) }}"
                                         alt="{{ $review->book }}">
                                </a>
                            @else
                                <a href="{{ route('userProfile', $review->author_id) }}">
                                    <img src="{{ empty(getStorageFile('users', $review->author_id)) ? asset('images/no_avatar.jpg') : asset(getStorageFile('users', $review->author_id)) }}"
                                         alt="{{ $review->author }}">
                                </a>
                            @endif
                        </figure>
                        <div class="review-info-wrapper">
                            @if(isset($isForUser))
                                <div class="review-user-name">
                                    <a href="{{ route('book', $review->book_id) }}">{{ $review->book }}</a>
                                </div>
                                <div class="review-user-all-reviews"></div>
                            @else
                                <div class="review-user-name">
                                    <a href="{{ route('userProfile', $review->author_id) }}">{{ $review->author }}</a>
                                </div>
                                <div class="review-user-all-reviews">
                                    (<a href="{{ route('getAllReviewsForUser', $review->author_id) }}">Все рецензии
                                        пользователя</a>)
                                </div>
                            @endif
                            <div class="review-rating-wrapper">
                                <div class="review-rating-icon">
                                    Полезность рецензии:
                                </div>
                                <div class="review-rating-count">
                                    <div class="review-positive-count" title="Количество положительных оценок">
                                        {{ array_has(json_decode($review->rating), 'positive') ? count(json_decode($review->rating, true)['positive']) : 0 }}
                                    </div>
                                    <span>/</span>
                                    <div class="review-negative-count" title="Количество отрицательных оценок">
                                        {{ array_has(json_decode($review->rating), 'negative') ? count(json_decode($review->rating, true)['negative']) : 0 }}
                                    </div>
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
                        <span>Оценить:</span>
                        <div class="access-wrapper positive">
                            <i class="far fa-plus-square"></i>
                        </div>
                        <span>/</span>
                        <div class="access-wrapper negative">
                            <i class="far fa-minus-square"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif