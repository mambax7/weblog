<{foreach item=cat from=$block.categories}>
    <div style="margin:<{$cat.margin}>;"><a
                href="<{$xoops_url}>/modules/weblog/index.php?user_id=0&amp;cat_id=<{$cat.cat_id}>">
            <{$cat.prefix}><{$cat.cat_title}></a>(<{$cat.count}>)
    </div>
<{/foreach}>
