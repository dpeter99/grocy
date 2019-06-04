@extends('layout.default')

@section('title', $__t('Stock overview'))
@section('activeNav', 'stockoverview')
@section('viewJsName', 'stockoverview')


@push('pageScripts')
<script src="{{ $U('/node_modules/jquery-ui-dist/jquery-ui.min.js?v=', true) }}{{ $version }}"></script>
@endpush


@section('content')



<ul class="mdc-list mdc-list--two-line" data-mdc-auto-init="MDCList">
	@foreach($currentStock as $currentStockEntry)
	<li class="mdc-list-item" tabindex="-1" id="product-{{ $currentStockEntry->product_id }}-row" class="
		@if($currentStockEntry->best_before_date < date('Y-m-d 23:59:59', strtotime		('-1 days')) && $currentStockEntry->amount > 0) table-danger 
		@elseif($currentStockEntry->best_before_date < date('Y-m-d 23:59:59', strtotime('+$nextXDays days')) && $currentStockEntry->amount > 0) table-warning 
		@elseif (FindObjectInArrayByPropertyValue($missingProducts, 'id', $currentStockEntry->product_id) !== null) table-info @endif">
		<span class="mdc-list-item__text">
			<span class="mdc-list-item__primary-text" data-product-id="{{ $currentStockEntry->product_id }}">
				{{ FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name }}
			</span>
			<span class="mdc-list-item__secondary-text">
				<span id="product-{{ $currentStockEntry->product_id }}-amount">
					{{ $currentStockEntry->amount }}
				</span>
				{{ $__n($currentStockEntry->amount, FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name, FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name_plural) }}
				<span id="product-{{ $currentStockEntry->product_id }}-opened-amount" class="font-italic">
					@if($currentStockEntry->amount_opened > 0){{ $__t('%s opened', $currentStockEntry->amount_opened) }}
					@endif
				</span>

				<span id="product-{{ $currentStockEntry->product_id }}-next-best-before-date">
					{{ $currentStockEntry->best_before_date }}
				</span>
				<time id="product-{{ $currentStockEntry->product_id }}-next-best-before-date-timeago" class="timeago timeago-contextual" datetime="{{ $currentStockEntry->best_before_date }} 23:59:59"></time>
			</span>
		</span>
		<span class="mdc-list-item__meta">

			<div class="stock-list-buttons__collapse">
				<button class="mdc-button mdc-button--raised safe product-consume-button"
				href="#" data-toggle="tooltip" data-placement="left" 
				title="{{ $__t('Consume %1$s of %2$s', '1 ' . FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name, FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name) }}" 
				data-product-id="{{ $currentStockEntry->product_id }}"
				data-product-name="{{ FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name }}"
				data-product-qu-name="{{ FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name }}" data-consume-amount="1" 
				@if($currentStockEntry->amount == 0) disabled @endif >
					<i class="material-icons mdc-button__icon" aria-hidden="true">
						local_dining
					</i>
					1
				</button>

				<button class="mdc-button mdc-button--outlined danger product-consume-button"
				href="#" data-toggle="tooltip" data-placement="right"
				title="{{ $__t('Consume all %s which are currently in stock', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name) }}"
				data-product-id="{{ $currentStockEntry->product_id }}"
				data-product-name="{{ FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name }}"
				data-product-qu-name="{{ FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name }}" 
				data-consume-amount="{{ $currentStockEntry->amount }}" 
				@if($currentStockEntry->amount == 0) disabled @endif>
					<i class="material-icons mdc-button__icon" aria-hidden="true">
						local_dining
					</i>
					{{ $__t('All') }}
				</button>

				<button class="mdc-button mdc-button--raised safe product-open-button"
				href="#" data-toggle="tooltip" data-placement="left"
				title="{{ $__t('Mark %1$s of %2$s as open', '1 ' . FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name, FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name) }}"
				data-product-id="{{ $currentStockEntry->product_id }}"
				data-product-name="{{ FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name }}" 
				data-product-qu-name="{{ FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name }}"
				@if($currentStockEntry->amount < 1 || $currentStockEntry->amount == $currentStockEntry->amount_opened) disabled @endif>
						<i class="material-icons mdc-button__icon" aria-hidden="true">
							drafts
						</i>
						1
				</button>
			</div>

			<span class="stock-list-buttons__menu">

				<button class="mdc-icon-button material-icons" id="product-{{ $currentStockEntry->product_id }}-actions-open">more</button>

				<div class="mdc-menu-surface--anchor">
					<div class="mdc-menu mdc-menu-surface" id="product-{{ $currentStockEntry->product_id }}-actions" data-mdc-auto-init="MDCMenu">
						<ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical" tabindex="-1">

							<li class="mdc-list-item product-consume-button @if($currentStockEntry->amount == 0) mdc-list-item--disabled @endif" role="menuitem"								
								href="#" data-toggle="tooltip" data-placement="left" 
								title="{{ $__t('Consume %1$s of %2$s', '1 ' . FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name, FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name) }}" 
								data-product-id="{{ $currentStockEntry->product_id }}"
								data-product-name="{{ FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name }}"
								data-product-qu-name="{{ FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name }}" data-consume-amount="1" >
									<span class="mdc-list-item__graphic material-icons" aria-hidden="true">local_dining</span>
									<span class="mdc-list-item__text" style="align-self:auto">{{ $__t('Consume') }} 1</span>
							</li>
							
							<li class="mdc-list-item danger product-consume-button @if($currentStockEntry->amount == 0) mdc-list-item--disabled @endif" role="menuitem"
								href="#" data-toggle="tooltip" data-placement="right"
								title="{{ $__t('Consume all %s which are currently in stock', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name) }}"
								data-product-id="{{ $currentStockEntry->product_id }}"
								data-product-name="{{ FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name }}"
								data-product-qu-name="{{ FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name }}" 
								data-consume-amount="{{ $currentStockEntry->amount }}" >
									<span class="mdc-list-item__graphic material-icons" aria-hidden="true">local_dining</span>
									<span class="mdc-list-item__text" style="align-self:auto;">{{ $__t('Consume') }} All</span>
							</li>

							<li class="mdc-list-item product-open-button @if($currentStockEntry->amount < 1 || $currentStockEntry->amount == $currentStockEntry->amount_opened) mdc-list-item--disabled @endif" role="menuitem"
								href="#" data-toggle="tooltip" data-placement="left"
								title="{{ $__t('Mark %1$s of %2$s as open', '1 ' . FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name, FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name) }}"
								data-product-id="{{ $currentStockEntry->product_id }}"
								data-product-name="{{ FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->name }}" 
								data-product-qu-name="{{ FindObjectInArrayByPropertyValue($quantityunits, 'id', FindObjectInArrayByPropertyValue($products, 'id', $currentStockEntry->product_id)->qu_id_stock)->name }}">
									<span class="mdc-list-item__graphic material-icons" aria-hidden="true">drafts</span>
									<span class="mdc-list-item__text" style="align-self:auto;">{{ $__t('Open') }} 1</span>
							</li>
						</ul>
					</div>
				</div>

				@push('pageScripts')
					<script>

						product_{{ $currentStockEntry->product_id }}_actions_open = document.querySelector('#product-{{ $currentStockEntry->product_id }}-actions-open')

						product_{{ $currentStockEntry->product_id }}_actions = document.querySelector('#product-{{ $currentStockEntry->product_id }}-actions').MDCMenu;

						product_{{ $currentStockEntry->product_id }}_actions_open.onclick = () => {
							product_{{ $currentStockEntry->product_id }}_actions.open = !product_{{ $currentStockEntry->product_id }}_actions.open;
						};

						product_{{ $currentStockEntry->product_id }}_actions.setFixedPosition(true);
					</script>
				@endpush

			</span>

		</span>
	</li>

	@endforeach
</ul>

<div class="mdc-card">
<div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="mdc-card__media mdc-card__media--16-9 demo-card__media" style="background-image: url(&quot;https://material-components.github.io/material-components-web-catalog/static/media/photos/3x2/2.jpg&quot;);"></div>
    <div class="demo-card__primary">
      <h2 class="demo-card__title mdc-typography mdc-typography--headline6">Our Changing Planet</h2>
      <h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2">by Kurt Wagner</h3>
    </div>
    <div class="demo-card__secondary mdc-typography mdc-typography--body2">Visit ten places on our planet that are undergoing the biggest changes today.</div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <button class="mdc-button mdc-card__action mdc-card__action--button">Read</button>
      <button class="mdc-button mdc-card__action mdc-card__action--button">Bookmark</button>
    </div>
    <div class="mdc-card__action-icons">
      <button class="mdc-icon-button mdc-card__action mdc-card__action--icon--unbounded" aria-pressed="false" aria-label="Add to favorites" title="Add to favorites">
        <i class="material-icons mdc-icon-button__icon mdc-icon-button__icon--on">favorite</i>
        <i class="material-icons mdc-icon-button__icon">favorite_border</i>
      </button>
      <button class="mdc-icon-button material-icons mdc-card__action mdc-card__action--icon--unbounded" title="Share" data-mdc-ripple-is-unbounded="true">share</button>
      <button class="mdc-icon-button material-icons mdc-card__action mdc-card__action--icon--unbounded" title="More options" data-mdc-ripple-is-unbounded="true">more_vert</button>
    </div>
  </div>
</div>

@stop