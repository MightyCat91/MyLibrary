{{--@push('styles')--}}
{{--@endpush--}}
@push('scripts')
    {{--<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>--}}
    {{--<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>--}}
    <script type="text/javascript" src="{{ asset('/js/Custom/addReview.js') }}"></script>
@endpush

<!-- The modal -->
<div class="modal fade" id="review-dialog-container" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall"
     aria-hidden="true">
    <div class="modal-dialog modal-vertical-centered modal-lg">
        <div class="modal-content">
            <form id="add-review-form" method="post" enctype="multipart/form-data" data-id="{{ $id }}"
                  data-url="{{ route('addReview') }}">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times fa-1x"></i>
                    </button>
                    <textarea id="text-editor-wrapper" name="review-text-field"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn submit-btn addReview">
                        <span class="dflt-text">Добавить рецензию</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

