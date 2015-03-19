<!-- RetailRocket -->

{if $product.product_id && $runtime.controller == 'products' && $runtime.mode == 'view'}
    <script type="text/javascript">
    rrApiOnReady.push(function() {
    try{ rrApi.view({$product.product_id}); } catch(e) {}
    })
    </script>
{/if}

{if $runtime.controller == 'categories' && $runtime.mode == 'view'}
    <script type="text/javascript">
    rrApiOnReady.push(function() {
    try { rrApi.categoryView({$category_data.category_id}); } catch(e) {}
    })
    </script>
{/if}

<script>
    var rrPartnerId = "{$addons.retailrocket.partner_id}";
    var rrApi = {};
    var rrApiOnReady = rrApiOnReady || [];
    rrApi.addToBasket = rrApi.order = rrApi.categoryView = rrApi.view =
    rrApi.recomMouseDown = rrApi.recomAddToCart = function() {};
    (function(d) {
    var ref = d.getElementsByTagName('script')[0];
    var apiJs, apiJsId = 'rrApi-jssdk';
    if (d.getElementById(apiJsId)) return;
    apiJs = d.createElement('script');
    apiJs.id = apiJsId;
    apiJs.async = true;
    apiJs.src = "//cdn.retailrocket.ru/content/javascript/api.js";
    ref.parentNode.insertBefore(apiJs, ref);
    }(document));
</script>

<!-- /RetailRocket -->