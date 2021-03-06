<{if $block.lang_denote}>
    <div style="padding:2px 5px 4px 5px;"><{$block.lang_denote}></div>
<{/if}>
<{if $block.lang_whose}>
    <div style="padding: 5px 5px 5px 8px;">
        <{$block.lang_whose}>
    </div>
<{/if}>
<{foreach item=image from=$block.images}>
    <div style="padding: 2px 5px 12px 8px;">
        <a href="<{$image.entry_url}>"><{$image.title}></a><{$image.permission}>
        <div align="right" style="padding: 2px 4px 6px 2px;">
            <{if ! $block.lang_whose}><a href="<{$image.blog_uri}>"><{$image.uname}></a>&nbsp;<{/if}>(<{$image.date}>)
        </div>
        <{foreach item=image_src from=$image.image_uri }>
            <div style="padding: 2px 8px 2px 8px;" align="center">
                <a href="<{$image.entry_url}>"><img src="<{$image_src}>" border="0"></a>
            </div>
        <{/foreach}>
        <{$image.contents}>
    </div>
<{/foreach}>
<br>
