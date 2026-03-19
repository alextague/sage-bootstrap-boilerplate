<div {!! $module->ID ? 'id="'.$module->ID.'"' : '' !!} class="container-fluid module freeform-content {{ $module->custom_classes ? $module->custom_classes : 'sage-my-50' }} {{ $module->text_size === 'small' ? 'text-small' : '' }}" {!! $module->custom_styles ? 'style="'.$module->custom_styles.'"' : '' !!}>
  <div class="container">
    <div class="row">
      <div class="col-24 col-lg-18 offset-lg-3">
        {!! $module->content !!}
      </div>
    </div>
  </div>
</div>
