@if ($nav_menu)
  @if ($navClass || $ariaLabel)
    <nav @if ($navClass) class="{{ $navClass }}" @endif @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif>
      {!! $nav_menu !!}
    </nav>
  @else
    {!! $nav_menu !!}
  @endif
@endif
