<div {!! $module->ID ? 'id="'.$module->ID.'"' : '' !!} class="container-fluid module logo-grid {{ $module->custom_classes ? $module->custom_classes : 'sage-mb-md-100 sage-mb-50' }}" {!! $module->custom_styles ? 'style="'.$module->custom_styles.'"' : '' !!}>
  <div class="container">
    <div class="row text-center">
        <h2 class="offset-md-6 col-md-12 sage-mb-20">{!! $module->title !!}</h2>
        <p class="offset-md-2 col-md-20 sage-mb-90">{!! $module->copy !!}</p>
        <div class="row offset-md-2 col-md-20">
          @foreach($module->logos as $logo)
          <div class="logo col-12 position-relative">
            <a href="{{ $logo['url'] }}" class="stretched-link">
              <x-acf-image :image-id="$logo['logo']"/>
            </a>
          </div>
          @endforeach
        </div>
      </div>
  </div>
</div>
