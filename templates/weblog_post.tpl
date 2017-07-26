<{if $is_preview eq 1}>
    <p class="preview">
    <div class="blogDate"><{$sample_date}></div>
    <div class="blogEntry">
        <table class="blogHeader">
            <tr>
                <{if $use_avatar == 1}>
                    <td width="<{$avatar_width}>"><img src="<{$avatar_img}>"></td>
                <{/if}>
                <td>
                    <div class="blogTitle"><{$title}></a></div>
                    <hr>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <div class="blogContents"><{$preview}></div>
                </td>
            </tr>
        </table>
    </div>
<{/if}>

<{$form}>
