@php
  $isTwoColumn = $module->columns === '2_columns';
  $isLeftAligned = $module->columns === '1_column_left_aligned';
  $isCentered = $module->columns === '1_column_centered';
  $titleSizeClass = $module->title_size === 'larger' ? 'sage-h1' : '';
@endphp

<div {!! $module->ID ? 'id="'.$module->ID.'"' : '' !!} class="container-fluid module text-module {{ $module->custom_classes ? $module->custom_classes : 'sage-py-md-100 sage-py-50' }}" {!! $module->custom_styles ? 'style="'.$module->custom_styles.'"' : '' !!}>
  <div class="container">
    <div class="row">
      @if($isLeftAligned)
        <div class="col-24 col-md-20 offset-md-2 col-lg-19 offset-lg-3">
          @if($module->eyebrow)
            <p class="sage-h3 text-uppercase mid-blue-color sage-mb-5">{!! $module->eyebrow !!}</p>
          @endif

          @if($module->title)
            <h2 class="dark-blue-color {{ $titleSizeClass }}">{!! $module->title !!}</h2>
          @endif

          @if($module->copy)
            <div class="text-content black-color">
              {!! $module->copy !!}
            </div>
          @endif
        </div>
      @else
        @if($module->title)
          <div class="col-24 {{ $isTwoColumn ? 'col-md-7 offset-md-2 col-lg-6 offset-lg-3' : 'col-md-18 offset-md-3 col-lg-16 offset-lg-4' }}">
            <h2 class="dark-blue-color {{ $titleSizeClass }} {{ $isCentered ? 'text-center' : '' }}">{!! $module->title !!}</h2>
          </div>
        @endif

        @if($module->copy)
          <div class="col-24 {{ $isTwoColumn ? 'col-md-10 offset-md-1 col-lg-9 offset-lg-2' : 'col-md-18 offset-md-3 col-lg-16 offset-lg-4' }}">
            <div class="text-content black-color {{ $isCentered ? 'text-center' : '' }}">
              {!! $module->copy !!}
            </div>
          </div>
        @endif
      @endif
    </div>
  </div>
</div>
