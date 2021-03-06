<{if $block.lang_denote}>
    <div style="padding:2px 5px 4px 5px;"><{$block.lang_denote}></div>
<{/if}>
<{if $block.lang_whose}>
    <{$block.lang_whose}>
    <br>
<{/if}>
<{if $block.type eq 3}>
    <table cellspacing="1" class="outer">
        <tr>
            <th><{$block.lang_tbtitle}></th>
            <th><{$block.lang_entrytitle}></th>
            <th><{$block.lang_blogname}></th>
            <th><{$block.lang_posted}></th>
            <{foreach item=trackback from=$block.trackbacks}>
        <tr class="<{cycle values="odd,even"}>" valign="middle">
            <td><a href="<{$trackback.entry_url}>#trackback"><{$trackback.tb_title}></a></td>
            <td align="center"><a
                        href="<{$trackback.entry_url}>"><{$trackback.entry_title}></a><{$trackback.permission}></td>
            <td><a href="<{$trackback.link}>" target="_blank"><{$trackback.blog_name}></a></td>
            <td align="right"><{$trackback.date}></td>
        </tr>
        <{/foreach}>
    </table>
<{else}>
    <{foreach item=trackback from=$block.trackbacks}>
        <div style="padding: 2px 5px 2px 8px;">
            <a href="<{$trackback.entry_url}>#trackback"><{$trackback.tb_title}></a><{$trackback.permission}>
            <div style="padding: 2px 15px 2px 8px;">
                <{if $block.type eq 2}>
                    --
                    <a href="<{$trackback.link}>"><{$trackback.blog_name}></a>
                <{/if}>
                <div align="right">(<{$trackback.date}>)</div>
            </div>
        </div>
    <{/foreach}>
<{/if}>
