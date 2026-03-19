<div {!! $module->ID ? 'id="'.$module->ID.'"' : '' !!} class="container-fluid module cta-banner position-relative {{ $module->custom_classes ? $module->custom_classes : 'sage-p-0' }}" {!! $module->custom_styles ? 'style="'.$module->custom_styles.'"' : '' !!}>
  <x-acf-image :image-id="$module->background_image" class="background-image sage-banner-image position-absolute"/>
  <div class="container sage-pt-150 sage-pb-120 white-color text-center">
    <h2 class="sage-mb-25">{!! $module->title !!}</h2>
    <p class="sage-mb-70">{!! $module->copy !!}</p>
    <a href="{{ $module->button['url'] }}" class="btn btn-primary">{!! $module->button['title'] !!}</a>
  </div>
</div>
