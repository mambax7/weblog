<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<{$charset}>">
    <title><{$sitename}></title>
    <meta name="AUTHOR" content="<{$author}>">
    <meta name="COPYRIGHT" content="Copyright (c) 2001 by <{$sitename}>">
    <meta name="DESCRIPTION" content="<{$description}>">
    <meta name="GENERATOR" content="<{$generator}>">
</head>
<body bgcolor="#ffffff" text="#000000" onload="window.print()">
<table border="0" style="font: 12px;">
    <tr>
        <td>
            <table border="0" width="640" cellpadding="0" cellspacing="1" bgcolor="#000000">
                <tr>
                    <td>
                        <table border="0" width="640" cellpadding="20" cellspacing="1" bgcolor="#ffffff">
                            <{if $image_url != ""}>
                                <tr>
                                    <td>
                                        <img src="<{$image_url}>" border="0" align="right" alt="<{$sitename}>">
                                    </td>
                                </tr>
                            <{/if}>
                            <tr>
                                <td>
                                    <h2><{$blog_title}></h2>
                                    <span style="font-size: small;"><span style="font-weight: bold;"><{$lang_date}></span>&nbsp;<{$datetime}><br>
                                        <span style="font-weight: bold;"><{$lang_author}></span>&nbsp;<{$author}></span>
                                </td>
                            </tr>
                            </td></tr>
                            <tr valign="top">
                                <td>
                                    <{$contents}>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br><br>
            <hr>
            <br>
            <{$lang_comesfrom}>
            <br><a href="<{$site_url}>/"><{$site_url}></a><br><br>
            <{$lang_parmalink}><br>
            <a href="<{$parmalink}>"><{$parmalink}></a>
        </td>
    </tr>
</table>
</body>
</html>
