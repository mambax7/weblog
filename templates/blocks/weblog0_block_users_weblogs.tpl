<{if $block.lang_denote}>
    <div style="padding:2px 5px 4px 5px;"><{$block.lang_denote}></div>
<{/if}>
<{if $block.type eq 2 || $block.type eq 3}>
<table cellspacing="1" class="outer">
    <tr>
        <th><{$block.lang_author}></th>
        <th><{$block.lang_entries}></th>
        <{if $block.type eq 3}>
            <th><{$block.lang_reads}></th>
            <th><{$block.lang_comments}></th>
            <th><{$block.lang_trackbacks}></th>
        <{/if}>
        <th><{$block.lang_posted}></th>
        <{foreach item=user from=$block.users}>
    <tr class="<{cycle values="odd,even"}>" valign="middle">
        <td rowspan="<{$user.entry_num_plus1}>" align="center" valign="middle">
            <a href="<{$user.user_blog_uri}>">
                <{if $block.use_avatars eq 1}>
                    <img src="<{$user.avatar_img}>" width="32">
                    <br>
                <{/if}>
                <{$user.uname}><br>
            </a>
            <{$block.lang_user_sort_value}><br>(<{$user.sort_value}>)
        </td>
    </tr>
    <{foreach item=entry from=$user.entries}>
        <tr class="<{cycle values="odd,even"}>">
            <td><a href="<{$entry.entry_url}>"><{$entry.title}></a><{$entry.permission}>
                <{if $block.show_contents}><br><{$entry.contents}><{/if}>
            </td>
            <{if $block.type eq 3}>
                <td align="center"><{$entry.reads}></td>
                <td align="center"><{$entry.comments}></td>
                <td align="center"><{$entry.trackbacks}></td>
            <{/if}>
            <td align="right"><{$entry.created}></td>
        </tr>
    <{/foreach}>
    <{/foreach}>
</table>
<{else}>
<ul>
    <{foreach item=user from=$block.users}>
        <div style="padding: 8px 5px 1px 2px;">
            <a href="<{$user.user_blog_uri}>"><b>[<{$user.uname}>]</b></a>
            <div style="padding: 1px 2px 2px 8px;" align="right"><{$block.lang_user_sort_value}>(<{$user.sort_value}>)
            </div>
            <{foreach item=entry from=$user.entries}>
                <div style="padding: 2px 10px 2px 4px;"><a
                            href="<{$entry.entry_url}>"><{$entry.title}></a><{$entry.permission}>
                    &nbsp;(<{$entry.created}>)
                </div>
                <{if $block.show_contents}>
                    <div style="padding:0px 2px 6px 12px;"><{$entry.contents}></div><{/if}>
            <{/foreach}>
        </div>
    <{/foreach}>
    </ol>
    <{/if}>
    <div style="text-align:right; padding: 5px;">
        <a href="<{$block.weblogs_url}>"><{$block.lang_moreweblogs}></a>
    </div>
