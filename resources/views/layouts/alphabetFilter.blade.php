<section id="alphabet-filter-container">
    <div id="alphabet-sticky-block" class="{{$type}}">
        @foreach(range(chr(0xC0),chr(0xDF)) as $letter)
            <div class="letter-filter">{{ iconv('CP1251','UTF-8',$letter) }}</div>
        @endforeach
    </div>
</section>