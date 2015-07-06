<!-- RetailRocket -->

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

{if $product.product_id && $runtime.controller == 'products' && $runtime.mode == 'view'}
    <!-- Products -->
    <script type="text/javascript">
    rrApiOnReady.push(function() {
    try{ rrApi.view({$product.product_id}); } catch(e) {}
    })
    </script>
{/if}

{if $runtime.controller == 'categories' && $runtime.mode == 'view'}

    <!-- Categories -->
    <script type="text/javascript">
    rrApiOnReady.push(function() {
    try { rrApi.categoryView({$category_data.category_id}); } catch(e) {}
    })
    </script>
{/if}

{if $order_info && $runtime.controller == 'checkout' && $runtime.mode == 'complete'}
<!-- RetailRocket order confirmation -->
<script type="text/javascript">
    rrApiOnReady.push(function() {
        try {
            rrApi.order({
                transaction: {$order_info.order_id},
                    items: [
                    {foreach from=$order_info.products item=products}
                        { 
                            id: {$products.product_id},
                            qnt: {$products.amount}, 
                            price: {$products.price}
                        },
                    {/foreach}
                    ]
            });
        } catch(e) {}
    })
</script>

{/if}

<!-- /RetailRocket -->