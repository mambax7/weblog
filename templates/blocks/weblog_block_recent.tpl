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
            <th><{$block.lang_title}></th>
            <th><{$block.lang_author}></th>
            <th><{$block.lang_reads}></th>
            <th><{$block.lang_comments}></th>
            <th><{$block.lang_trackbacks}></th>
            <th><{$block.lang_posted}></th>
        </tr>
        <{foreach item=entry from=$block.entries}>
            <tr class="<{cycle values="odd,even"}>" valign="middle">
                <td><a href="<{$entry.entry_url}>"><{$entry.title}></a><{$entry.permission}>
                    <{if $block.show_contents}><br><{$entry.contents}><{/if}>
                </td>
                <td align="center">
                    <{if $entry.use_avatar eq 1}>
                        <img src="<{$entry.avatar_img}>" width="32">
                        <br>
                    <{/if}>
                    <a href="<{$entry.profile_uri}>"><{$entry.uname}></a>
                </td>
                <td align="center"><{$entry.reads}></td>
                <td align="center"><{$entry.comments}></td>
                <td align="center"><{$entry.trackbacks}></td>
                <td align="right"><{$entry.date}></td>
            </tr>
        <{/foreach}>
    </table>
<{else}>
    <div style="padding: 2px 5px 2px 8px;">
        <{foreach item=entry from=$block.entries}>
            <a href="<{$entry.entry_url}>"><{$entry.title}></a><{$entry.permission}>
            <{if $block.type eq 2 && ! $block.lang_whose}>
                <div style="padding: 2px 15px 12px 8px;">
                    <a href="<{$entry.profile_uri}>"><{$entry.uname}></a>
                </div>
            <{/if}>
            <div align="right">(<{$entry.date}>)</div>
            <{if $block.show_contents}>
                <div style="padding:0px 2px 2px 12px;"><{$entry.contents}></div><{/if}>
        <{/foreach}>
    </div>
<{/if}>

<div style="text-align:right; padding: 5px;">
    <a href="<{$block.weblogs_url}>"><{$block.lang_moreweblogs}></a>
</div>
