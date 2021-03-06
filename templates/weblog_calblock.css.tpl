<{literal}>
    #weblog-calendar {
    empty-cells: show;
    font-size: 100%;
    margin: 0 auto;
    width: 132px;   /* change if you like:  pixels = column with * 7 + cellspacing */
    /* sample 14*7+6=104 or 18*7+6=132 or 22*7+6=160 */
    /*  background-color:#fff;*/
    }

    #weblog-calendar a {
    text-decoration: underline;
    }

    #weblog-calendar a:hover {
    background: transparent;
    color: #c00;
    }

    #weblog-calendar caption {
    color: #000;
    font: 100% Tahoma, Arial, Serif;    /* Font-size critical if you change box width */
    margin: 0;
    padding: 0;
    text-align: center;
    }

    #weblog-calendar #to-this { padding: 0 5px; }
    #weblog-calendar #to-nextM a,
    #weblog-calendar #to-prevM a,
    #weblog-calendar #to-nextY a,
    #weblog-calendar #to-prevY a,
    #weblog-calendar #to-this a {
    }

    #weblog-calendar #to-nextM a:hover,
    #weblog-calendar #to-prevM a:hover,
    #weblog-calendar #to-nextY a:hover,
    #weblog-calendar #to-prevY a:hover,
    #weblog-calendar #to-this a:hover {
    color: #c00;
    }

    #weblog-calendar th {
    color: #000;
    text-transform: none;
    font-size: 90%;             /* Font-size critical if you change box width */
    font-weight: normal;
    text-align: center;
    vertical-align: middle;
    width: 18px;                /* Critical if you change box width */
    height: 18px;               /* Critical if you change box width */
    /*  background-color:#eee; */
    }

    #weblog-calendar td {
    color: #000;
    font: normal 100% Tahoma, Arial, Serif; /* Font-size critical if you change box width */
    text-align: center;
    vertical-align: middle;
    width: 18px;                /* Critical if you change box width */
    height: 18px;               /* Critical if you change box width */
    /*  background-color:#fff;*/
    }

    #weblog-calendar .today {
    border: 1px solid #000;
    }

    #weblog-calendar tr.weblog-header {
    /*  color: #xxx;
    background-color: #xxx */
    }
    #weblog-calendar tr.weblog-week {
    /*  color: #xxx;
    background-color: #xxx */
    }
    #weblog-calendar th.sunday,
    #weblog-calendar td.sunday {
    /*  color: #xxx;
    background-color: #xxx */
    }
    #weblog-calendar th.saturday,
    #weblog-calendar td.saturday {
    /*  color: #xxx;
    background-color: #xxx */
    }
    #weblog-calendar td.prevmonth,
    #weblog-calendar td.nextmonth {
    color: #fff;                /* hides if the same color used as background */
    }
<{/literal}>
