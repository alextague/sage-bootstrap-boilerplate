<p class="share-title fw-bold sage-mb-20 text-center text-uppercase sage-ls-100 sage-font-sm white-color">{!! $share_text !!}</p>
<ul class="share-links list-unstyled sage-m-0 sage-p-0 d-flex align-content-center align-items-center justify-content-center">
    @foreach($share_to as $item_name => $item)
      <li class="share-item"><a href="{{ $item['href'] }}" target="_blank" rel="noopener noreferrer">{!! svg('fab-' . str_replace('fa-', '', $item['fa_icon']))->toHtml() !!}</a></li>
    @endforeach
</ul>
