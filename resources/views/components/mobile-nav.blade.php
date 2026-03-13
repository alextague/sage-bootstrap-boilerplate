<ul>
  @foreach ($menu_items as $item)
    <li><a class="parent-link" href="{{ $item['url'] }}" target="{{ $item['target'] }}">{!! $item['title'] !!}</a>
      @if (!empty($item['children']))
        <ul>
          @foreach ($item['children'] as $child)
          <li><a class="child-link" href="{{ $child['url'] }}" target="{{ $child['target'] }}">{!! $child['title'] !!}</a></li>
          @endforeach
        </ul>
      @endif
    </li>
  @endforeach
</ul>
