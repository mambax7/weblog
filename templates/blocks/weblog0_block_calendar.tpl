<{assign var=cal value=$block.calendar}>
<{assign var=month value=$block.calendar.days}>
<{assign var=remark value=$block.calendar.remarks}>
<{assign var=detail value=$block.calendar.details}>
<{assign var=archive value=$block.calendar.archives}>
<style type="text/css">
    <{include file=$block.calendar.calblockcss}>
</style>
<table id="weblog-calendar" cellspacing="1" cellpadding="0" border="0">
    <div align="center">
        <a id="to-prevY" href="<{$xoops_url}>/modules/<{$cal.moduledir}>/index.php?date=<{$cal.yearPrev}>"
           title="<{$cal.lang_ShowPrevYear}>"><{$cal.lang_yearPrev}></a>&nbsp;
        <a id="to-prevM" href="<{$xoops_url}>/modules/<{$cal.moduledir}>/index.php?date=<{$cal.monthPrev}>"
           title="<{$cal.lang_ShowPrevMonth}>"><{$cal.lang_monthPrev}></a>&nbsp;
        <a id="to-this" href="<{$xoops_url}>/modules/<{$cal.moduledir}>/index.php?date=<{$cal.monthThis}>"
           title="<{$cal.lang_ShowThisMonth}>"><{$cal.year}>&nbsp;<{$cal.lang_month}></a>&nbsp;
        <a id="to-nextM" href="<{$xoops_url}>/modules/<{$cal.moduledir}>/index.php?date=<{$cal.monthNext}>"
           title="<{$cal.lang_ShowNextMonth}>"><{$cal.lang_monthNext}></a>&nbsp;
        <a id="to-nextY" href="<{$xoops_url}>/modules/<{$cal.moduledir}>/index.php?date=<{$cal.yearNext}>"
           title="<{$cal.lang_ShowNextYear}>"><{$cal.lang_yearNext}></a>
    </div>
    <thead>
    <tr class="weblog-header" align="center" valign="middle">
        <{foreach item=weekname name=dayofweekloop from=$cal.dayofweek}>
            <th id="weblog-calendar" title="<{$weekname}>"
                scope="col" <{if $smarty.foreach.dayofweekloop.first}> class="sunday"<{elseif $smarty.foreach.dayofweekloop.last}> class="saturday"<{/if}>><{$weekname}></th>
        <{/foreach}>
    </tr>
    </thead>

    <tbody>
    <{section name=week loop=$month}>
        <tr class="weblog-week" align="center" valign="middle">
            <{section name=day loop=$month[week]}><{strip}>
            <td<{if $remark[week][day] != ""}> class="<{$remark[week][day]}>"<{/if}>>
                <{if $detail[week][day]}>
                    <a href="<{$xoops_url}>/modules/<{$cal.moduledir}>/index.php?date=<{$detail[week][day]}>"><{$month[week][day]}></a>
                <{else}>
                    <{$month[week][day]}><{/if}></td><{/strip}>
            <{/section}>
        </tr>
    <{/section}>
    </tbody>
</table>
