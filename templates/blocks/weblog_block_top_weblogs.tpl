<table cellspacing="1" class="outer">
    <{foreach item=entry from=$block.entries}>
        <tr class="<{cycle values="odd,even"}>" valign="middle">
            <td><{$entry.rank}></td>
            <td align="center">
                <{if $entry.use_avatar eq 1}>
                    <img src="<{$entry.avatar_img}>" width="32">
                    <br>
                <{/if}>
                <a href="<{$entry.profile_uri}>"><{$entry.uname}></a>
            </td>
            <td align="center"><{$entry.count}></td>
        </tr>
    <{/foreach}>
</table>
