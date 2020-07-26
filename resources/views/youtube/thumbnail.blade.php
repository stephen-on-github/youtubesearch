<img
    class="search-thumbnail"
    src="{!! $thumbnail->url !!}"
    alt=""

    @if (isset($thumbnail->width))
        width="{!! $thumbnail->width !!}"
    @endif

    @if (isset($thumbnail->height))
        height="{!! $thumbnail->height !!}"
    @endif
/>