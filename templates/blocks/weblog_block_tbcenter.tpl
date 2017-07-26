°Ê²¼¤Î¥¨¥ó¥È¥ê¤Î¥È¥é¥Ã¥¯¥Ð¥Ã¥¯¤òÊç½¸¤·¤Þ¤¹<br>
<{foreach from=$block.entries item=tb_entry}>
    <{$tb_entry.title}>
    <br>
    <{$tb_entry.contents}>
    <br>
    <div>¥È¥é¥Ã¥¯¥Ð¥Ã¥¯URL</div>
    <div><{$tb_entry.tb_url}></div>
<{/foreach}>

