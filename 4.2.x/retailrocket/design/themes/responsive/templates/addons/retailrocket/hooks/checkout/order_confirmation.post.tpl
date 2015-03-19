<!-- RetailRocket order confirmation -->

{if $order_info}
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
