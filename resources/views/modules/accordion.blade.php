@if ($module->accordion_items)
<div {!! $module->ID ? 'id="'.$module->ID.'"' : '' !!} class="container-fluid module accordion-module {{ $module->background_style === 'light-gray' ? 'bg-color-light-gray' : '' }} {{ $module->custom_classes }}" {!! $module->custom_styles ? 'style="'.$module->custom_styles.'"' : '' !!}>
  <div class="container">
    <div class="row sage-py-70">
      <div class="col-md-20 offset-md-2">

        <div class="accordion" id="accordion_{{ $module->uid }}">

          @foreach ($module->accordion_items as $index => $item)

            <div class="accordion-item rounded-0">
              <div class="accordion-header rounded-0" id="heading_{{ $module->uid }}_{{ $index }}">
                <button
                  class="accordion-button rounded-0 sage-h2 mb-0 color-mid-blue {{ $module->expand_first_panel && $index === 0 ? '' : 'collapsed' }}"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapse_{{ $module->uid }}_{{ $index }}"
                  aria-expanded="{{ $module->expand_first_panel && $index === 0 ? 'true' : 'false' }}"
                  aria-controls="collapse_{{ $module->uid }}_{{ $index }}">
                  <span class="accordion-title">{!! $item['title'] !!}</span>
                  <span class="accordion-icon">
                    <svg width="38" height="19" viewBox="0 0 38 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2 2L19 17L36 2" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                </button>
              </div>

              <div
                id="collapse_{{ $module->uid }}_{{ $index }}"
                class="accordion-collapse collapse {{ $module->expand_first_panel && $index === 0 ? 'show' : '' }}"
                aria-labelledby="heading_{{ $module->uid }}_{{ $index }}"
                @if (!$module->allow_multiple_open) data-bs-parent="#accordion_{{ $module->uid }}" @endif>
                <div class="accordion-body">
                  {!! $item['content'] !!}
                </div>
              </div>
            </div>

          @endforeach

        </div>

      </div>
    </div>
  </div>
</div>
@endif
