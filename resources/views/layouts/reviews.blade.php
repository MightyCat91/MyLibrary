<div id="reviews-container">
    <h2>Рецензии</h2>
    <div id="reviews-wrapper">
        @foreach($reviews as $review)
            <div class="review-item-container">
                <div class="review-item-header">
                    <div class="review-user-img">
                        <img src="" alt="">
                    </div>
                    <div class="review-info-wrapper">
                        <div class="review-user-name">{{ $review->author }}</div>
                        <div class="review-user-all-reviews">{{ route('getAllReviewsForUser', $review->authorId) }}</div>
                        <div class="review-rating-wrapper">
                            <div class="review-rating-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="review-positive-count">{{ +$review->positive }}</div>
                            <div class="review-negative-count">{{ -$review->negative }}</div>
                        </div>
                        <div class="review-date">{{ $review->date }}</div>
                        <div class="review-user-book-status">{{ $review->bookStatus }}</div>
                    </div>
                </div>
                <div class="review-item-body">
                    {{ $review->text }}
                </div>
                <div class="review-show-full">
                    <a href="#" class="">
                        <span class="active">Развернуть</span>
                        <span class="hidden">Свернуть</span>
                    </a>
                </div>
                <div class="review-action-wrapper">
                    <span>Вам была полезна данная рецензия</span>
                    <div class="access-positive-wrapper">
                        <i class="fas fa-thumbs-up"></i> Да
                    </div>
                    /
                    <div class="access-negative-wrapper">
                        <i class="fas fa-thumbs-down"></i> Нет
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>