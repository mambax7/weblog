<table cellspacing="0" width="100%">
    <tr>
        <td><b><{$page_title}> - <{$page_subtitle}></b><br>
            <hr>
        </td>
    </tr>
</table><br>

<{if $show_archives == true}>
    <form name="catselbox" action="<{$xoops_url}>/modules/<{$xoops_weblogdir}>/archive.php" method="get">
        <div id="blogSelBox">
            <div style="float: left;">
                <{$smarty.const._BL_CATEGORY}>
                <select size="1" name="cat_id">
                    <{foreach item=cat from=$catselbox}>
                        <option value="<{$cat.cat_id}>"<{if $cat.selected}><{$cat.selected}><{/if}>><{$cat.prefix}><{$cat.cat_title}></option>
                    <{/foreach}>
                </select>&nbsp;
                <{$subcat_chkbox}>&nbsp;<{$lang_subcatshow}>
            </div>
            <div style="float: left;padding-left: 1em;">
                <{$smarty.const._BL_POSTED}>
                <{$dateselbox}>
            </div>
            <div style="float: left;padding-left: 1em;">
                <{$smarty.const._BL_AUTHOR}>
                <{$uidselbox}>
            </div>
            <div style="float: left;padding-left: 1em;">
                <input type="submit" value="<{$lang_show}>">
            </div>
        </div>
    </form>
    <br style="clear: left;">
    <{* <table class="outer" cellspacing="1">
    <{foreach item=year from=$years}>
      <tr align="left" nowrap class="head">
        <td><{$year.number}>
        <{foreach item=month from=$year.months}>
          &nbsp;<a href="./<{$xoops_url}>/modules/<{$xoops_weblogdir}>/archive.php?year=<{$year.number}>&amp;month=<{$month.number}>&amp;user_id=<{$user_id}>"><{$month.string}></a>
        <{/foreach}>
        </td>
      </tr>
    <{/foreach}>
    </table> *}>

    <{if $show_blogs == true}>
        <br>
        <table width="100%" class="outer" cellspacing="1">
            <tr aligh="center">
                <th aligh="center"><{$lang_cat_title}></th>
                <th aligh="center"><{$lang_date}></th>
                <th aligh="center"><{$lang_title}></th>
                <th aligh="center"><{$lang_contents}></th>
                <th aligh="center"><{$lang_author}></th>
                <th aligh="center"><{$lang_reads}></th>
                <th aligh="center"><{$lang_comments}></th>
                <th aligh="center"><{$lang_trackbacks}></th>
            </tr>
            <{foreach item=entry from=$entries}>
                <tr class="<{cycle values="even, odd"}>">
                    <td aligh="center"><{$entry.cat_title}></td>
                    <td aligh="center"><{$entry.date}></td>
                    <td aligh="center"><a href="details.php?blog_id=<{$entry.blog_id}>"><{$entry.title}></a></td>
                    <td><{$entry.contents}></td>
                    <td aligh="center"><a href="<{$entry.profileUrl}>"><{$entry.uname}></a></td>
                    <td align="center"><{$entry.reads}></td>
                    <td align="center"><{$entry.comments}></td>
                    <td align="center"><{$entry.trackbacks}></td>
                </tr>
            <{/foreach}>
        </table>
        <div style="float: left;">
            <{$lang_blogtotal}>
        </div>
        <div style="float: right;">
            <{$pagenavi}>
        </div>
        <br style="clear: both;">
    <{/if}>
<{else}>
    <{$lang_noarchives}>
<{/if}>
