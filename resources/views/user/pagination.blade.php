

<div class="pagination">
    @if (ceil($elements->total() / $elements->count()) <= 3)
    <div class="wrapped-elements">
        @for ($i = 1; $i <= ceil($elements->total() / $elements->count()); $i++)
            <div class="item-pag first">
                <a href="?page={{ $i }}">{{ $i }}</a>
            </div>
        @endfor
    </div>
    @else

    @endif
</div>
