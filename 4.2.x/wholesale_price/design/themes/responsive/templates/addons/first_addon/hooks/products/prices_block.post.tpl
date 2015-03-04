{if $product.opt_price}
<span class="ty-opt-price">
{__('wholesale_text')}{include file="common/price.tpl" value=$product.opt_price span_id="opt_price_`$obj_prefix``$obj_id`" class="ty-opt-price-num"}
</span>
{/if}