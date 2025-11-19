    <a href="{{ route('items.show', ['item_id' => $item->id]) }}" class="item-unit-link">
        <div class="item-unit">
            @if ($item->img_url)
                @if (Str::startsWith($item->img_url, 'http'))
                    <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="item-image">
                @else
                    <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}" class="item-image">
                @endif
            @else
                <img src="{{ asset('images/no-image.png') }}" alt="画像なし" class="item-image">
            @endif
            <p class="item-name">{{ $item->name }}</p>
        </div>
    </a>
