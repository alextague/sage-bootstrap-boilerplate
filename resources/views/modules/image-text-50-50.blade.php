<div class="container-fluid image-text-50-50">
  <div class="container">
    <div class="row sage-py-100">
        @if ($module->image)
          <div class="image-wrapper offset-md-1 col-md-11 offset-lg-2 col-lg-9 {!! $module->image_side ? 'order-md-1' : 'order-md-2' !!}">
            <div class="ratio" style="--bs-aspect-ratio: 114.83%;">
              <x-acf-image :image-id="$module->image" class="sage-cover-image h-auto"/>
            </div>
          </div>
        @endif
        <div class="content-wrapper sage-pt-50 offset-md-1 col-md-11 offset-lg-2 col-lg-9 {!! $module->image_side ? 'order-md-2' : 'order-md-1' !!}">
          @if ($module->title)
            <h2>{!! $module->title !!}</h2>
          @endif
          @if ($module->copy)
            {!! $module->copy !!}
          @endif
          @if ($module->button)
            <a href="{{ $module->button['url'] }}" class="btn btn-tertiary sage-mt-20" target="{!! $module->button['target'] !!}">{!! $module->button['title'] !!}</a>
          @endif
        </div>
      </div>
  </div>
</div>
