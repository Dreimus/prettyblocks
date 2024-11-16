<div class="header__banner">
  <div class="container pre_header">
    <div class="row ">
      <div class="position-absolute d-none d-md-block banner-store-select">
        <div class="row dropdown">
            <span class="dropdown-toggle dropdownMenuButton1" type="button" id="dropdownMenuButton1"
                  data-bs-toggle="dropdown" aria-expanded="false">
              {if isset($block['fields']['shop_menu']['button_label'])}
                {$block['fields']['shop_menu']['button_label']}
              {/if}
            </span>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            {foreach from=$block['fields']['shop_menu']['shops'] item=item}
            <li>
              <a class="dropdown-item d-flex gap-3" href="{$item['link']['href']}" target="_blank">
                <div class="logo col-6">
                  {logo name=$item['icon']}
                </div>
                <div class="col-6 text-wrap">{$item['link']['label']}</div>
              </a>
            <li>
            {/foreach}
          </ul>
        </div>
      </div>
      <div class="wrapper-itemes d-flex justify-content-center align-items-center header-banner pre_header__reassurance">
        {foreach from=$block['fields']['reassurances'] item=item}
        <div class="item d-flex justify-content-center align-items-center gap-2 pre_header__reassurance__item">
          <div class="icon pre_header__reassurance__item__icon">
            {icon name=$item['icon']}
          </div>
          <div class="pre_header__reassurance__item__text">{$item['text']|unescape:'html' nofilter}</div>
        </div>
        {/foreach}

    </div>
  </div>
</div>
