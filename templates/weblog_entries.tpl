<table cellspacing="0" width="100%">
    <tr>
        <td><b><{$page_title}> - <{$page_subtitle}></b>
            <hr>
        </td>
    </tr>
    <{if $rss_show eq 1}>
        <tr>
            <td valign="middle" align="right">
                <a href="<{$rss_feeder}>"><img src="assets/images/rss.gif" border="0"></a>
                <a href="<{$rdf_feeder}>"><img src="assets/images/rdf.gif" border="0"></a>
                &nbsp;<{$lang_rss}></td>
        </tr>
    <{/if}>
</table><br>

<{if $show_category_list}>
    <b><{$lang_categories}></b>
    <div class="blogCategory"><{$cat_url}></div>
    <hr>
    <{if count($category_navi) > 0}>
        <table border='0' cellspacing='5' cellpadding='0' align="center">
            <tr>
                <td valign="top">
                    <!-- Start category loop -->
                    <{foreach item=cat from=$category_navi}>
                    <{if $cat.prefix_num == 1 && $cat.cat_root_num != 0}>
                </td>
                <{if $cat.cat_root_num is div by $category_col}>
            </tr>
            <tr>
                <td valign="top">
                    <{else}>
                <td valign="top">
                    <{/if}>
                    <{/if}>
                    <div style="margin:<{$cat.margin}>;"><a
                                href="<{$xoops_url}>/modules/<{$xoops_weblogdir}>/index.php?user_id=0&amp;cat_id=<{$cat.cat_id}>"><{$cat.prefix}><{$cat.cat_title}></a>(<{$cat.count}>
                        )
                    </div>
                    <{/foreach}>
                    <!-- End category loop -->
                </td>
            </tr>
        </table>
    <{/if}>
    <br>
    <br>
<{/if}>

<b><{$lang_recententries}></b>
<hr>
<!-- start loop -->
<{foreach item=entry from=$entries}>
    <{$entry.rdf_desc}>
    <div class="blogDate"><{$entry.created_date}></div>
    <div class="blogEntry">
        <table class="blogHeader">
            <tr>
                <{if $entry.use_avatar == 1}>
                    <td width="5%"><img src="<{$entry.avatar_img}>"></td>
                <{/if}>


                <div id="container">

                    <div class="date">
                        <p>25 <span>May</span></p>
                    </div>

                </div>


                <td>
                    <div class="blogTitle"><a href="details.php?blog_id=<{$entry.blog_id}>"><{$entry.title}></a></div>
                    <div class="blogCategory"><b><{$entry.lang_category}>:</b> <{$entry.category}></div>
                    <hr>
                    <div class="blogShoulder"><{$entry.lang_author}>: <a
                                href="<{$entry.profileUri}>"><{$entry.uname}></a> (<{$entry.created_time}>)
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <div class="blogContents"><{$entry.contents}></div>
                </td>
            </tr>
        </table>
        <div class="blogFooter">
            <{if $entry.is_private eq 1}>
                <b><i><{$entry.private}>:</i></b>
            <{/if}>
            <{$entry.read_users_blog}>
            <{if $entry.provide_edit_link eq 1}>
                |
                <a href="post.php?blog_id=<{$entry.blog_id}>&edit=1"><{$lang_edit}></a>
            <{/if}>
            | <a href="<{$entry.comlink}>"><{$entry.lang_comments}> (<{$entry.comments}>)</a>
            | <a href="<{$entry.tracklink}>"><{$entry.lang_trackbacks}> (<{$entry.trackbacks}>)</a>
            | <{$entry.lang_reads}> (<{$entry.reads}>)
        </div>
    </div>
<{/foreach}>
<!-- end loop -->

<p>
    <{$pagination}>
</p>

<{include file='db:system_notification_select.tpl'}>
