<div {!! $module->ID ? 'id="'.$module->ID.'"' : '' !!} class="carousel carousel--{{ $module->variation ?? 'logos' }} container-fluid module position-relative overflow-hidden px-0 d-flex flex-column flex-md-row flex-md-wrap justify-content-md-between align-items-md-center {{ $module->custom_classes ? $module->custom_classes : 'sage-py-60 sage-py-md-100' }}" {!! $module->custom_styles ? 'style="'.$module->custom_styles.'"' : '' !!}>
  <div class="carousel-title-group d-flex align-items-center justify-content-center justify-content-md-start gap-3 order-1 flex-shrink-0 text-center text-md-start">
    @if ($module->title)
      <h3 class="sage-h1 carousel-title text-white mb-0 sage-px-30 sage-px-md-0">{!! $module->title !!}</h3>
    @endif
    @if ($module->variation === 'gallery' && $module->button)
      <a href="{{ $module->button['url'] }}" class="btn btn-primary d-none d-md-flex" {!! $module->button['target'] ? 'target="'.$module->button['target'].'"' : '' !!}>
        {!! $module->button['title'] ?? 'Button' !!}
      </a>
    @endif
  </div>

  @if ($module->variation === 'gallery' && $module->button)
    <div class="order-3 d-md-none w-100 text-center sage-mt-40">
      <a href="{{ $module->button['url'] }}" class="btn btn-primary" {!! $module->button['target'] ? 'target="'.$module->button['target'].'"' : '' !!}>
        {!! $module->button['title'] ?? 'Button' !!}
      </a>
    </div>
  @endif

  @if ($module->logos)
    <div class="carousel-slider position-relative order-2 w-100 {{ $module->variation === 'gallery' ? 'sage-mt-30 sage-mt-md-40' : 'sage-mt-40 sage-mt-md-60' }}">
      <div id="carousel_splide_{{ $module->uid }}" class="splide {{ $module->variation !== 'gallery' ? 'bg-color-white sage-py-60 sage-py-md-100' : '' }}">
        <div class="splide__track">
          <ul class="splide__list">
            @foreach ($module->logos as $logo)
              <li class="splide__slide carousel-slide d-flex align-items-center justify-content-center">
                @if ($module->variation === 'gallery')
                  <div class="ratio carousel-image-wrapper">
                    <x-acf-image :image-id="$logo" srcset-sizes="100vw" class="carousel-image" />
                  </div>
                @else
                  <x-acf-image :image-id="$logo" srcset-sizes="(min-width: 768px) 25vw, 50vw" class="carousel-logo" />
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif
</div>
