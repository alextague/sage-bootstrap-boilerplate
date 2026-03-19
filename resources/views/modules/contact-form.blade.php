<div {!! $module->ID ? 'id="'.$module->ID.'"' : '' !!} class="container-fluid module contact-form bg-color-bp-foxtrot {{ $module->custom_classes ? $module->custom_classes : 'sage-pt-100 sage-pb-md-55' }}" {!! $module->custom_styles ? 'style="'.$module->custom_styles.'"' : '' !!}>
  <div class="container">
    <div class="row">
      <div class="offset-md-1 offset-lg-2 col-md-10 col-lg-9 bg-color-white sage-p-45">
        {!! $module->form !!}
      </div>
      <div class="offset-md-1 col-md-11 sage-mt-md-0 sage-mt-75">
        <div class="row sage-g-md-30">
          @foreach($module->companies as $company)
          <div class="col-sm-12 sage-pb-75">
            <h3>{!! $company['company_name'] !!}</h3>
            <a href="{{ $company['website']['url'] }}" class="white-color text-decoration-none fw-bold sage-font-md" target="{!! $company['website']['target'] !!}">{!! $company['website']['title'] !!}@if($company['website']['target']) <img src="@asset('images/external-link.svg')" class="sage-ml-10 align-baseline" alt="External Link">@endif</a>
            <p class="white-color sage-mt-30 sage-mb-0 fw-bold">Email</p>
            <p class="white-color sage-mb-30">{!! $company['email'] !!}</p>
            <p class="white-color sage-mt-30 sage-mb-0 fw-bold">Phone Number</p>
            <p class="white-color sage-mb-0">{!! $company['phone_number'] !!}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
