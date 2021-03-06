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
            <th><{$block.lang_comtitle}></th>
            <th><{$block.lang_comuname}></th>
            <th><{$block.lang_entrytitle}></th>
            <th><{$block.lang_posted}></th>
        </tr>
        <{foreach item=comment from=$block.comments}>
            <tr class="<{cycle values="odd,even"}>" valign="middle">
                <td><a href="<{$comment.entry_url}>#comment"><{$comment.com_title}></a></td>
                <td><{if $comment.profile_uri}>
                        <a href="<{$comment.profile_uri}>"><{$comment.com_uname}></a>
                    <{else}>
                        <{$comment.com_uname}>
                    <{/if}>
                </td>
                <td align="center"><a href="<{$comment.entry_url}>"><{$comment.entry_title}></a><{$comment.permission}>
                </td>
                <td align="right"><{$comment.date}></td>
            </tr>
        <{/foreach}>
    </table>
<{else}>
    <{foreach item=comment from=$block.comments}>
        <div style="padding: 2px 5px 2px 8px;">
            <a href="<{$comment.entry_url}>#comment"><{$comment.com_title}></a>
            <{if $block.type eq 2}>
                <div style="padding: 2px 15px 2px 8px;">--<a
                            href="<{$comment.entry_url}>"><{$comment.entry_title}></a><{$comment.permission}></div>
            <{/if}>
            <div align="right">
                <{if $comment.profile_uri}>
                    <a href="<{$comment.profile_uri}>"><{$comment.com_uname}></a>
                <{else}>
                    <{$comment.com_uname}>
                <{/if}>
                (<{$comment.date}>)
            </div>
        </div>
    <{/foreach}>
<{/if}>
