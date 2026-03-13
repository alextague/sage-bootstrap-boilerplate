@if (isset($page_builder))
    @foreach ($page_builder as $module)
        @include(str_replace('_', '-', 'modules.'.$module->acf_fc_layout))
    @endforeach
@elseif (get_the_content() != '' && !is_single())
    @include('partials.content-page')
@else
    @if (!is_single())
        @include('partials.content-empty')
    @endif
@endif
