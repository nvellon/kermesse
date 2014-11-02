<?php

function rectangle($ps, $x, $y, $w, $h) {
    ps_moveto($ps, $x, $y);
    ps_lineto($ps, $x, $y + $h);
    ps_lineto($ps, $x + $w, $y + $h);
    ps_lineto($ps, $x + $w, $y);
    ps_lineto($ps, $x, $y);
    ps_stroke($ps);
}

unlink("test.ps");
$ps = ps_new();
if (!ps_open_file($ps, "test.ps")) {
  print "Cannot open PostScript file\n";
  exit;
}

ps_set_info($ps, "Creator", "testps.php");
ps_set_info($ps, "Author", "Nicolas Vellon");
ps_set_info($ps, "Title", "Ticket");
//ps_set_info($ps, "BoundingBox", "0 0 203 84");

$fonts_dir = '/usr/lib/libreoffice/share/psprint/fontmetric';
ps_set_parameter($ps, 'SearchPath', $fonts_dir);


$psfont = ps_findfont($ps, "Helvetica", "", 0);

ps_begin_page($ps, 203, 84);
//ps_setfont($ps, $psfont, 14.0);
//ps_show_xy($ps, "CHORIPAN", 10, 10);
//rectangle($ps, 0, 0, 203, 84);
ps_end_page($ps);

ps_delete($ps);

// 1mm = 2,83px
exec('lp -d EPSON-TM-T20 -o media=Custom.72x30mm -o source=DocFeedCut test.ps');
// -o page-bottom=0 -o page-left=0 -o page-right=0 -o page-top=0

?>