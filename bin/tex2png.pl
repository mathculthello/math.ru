#!/usr/bin/perl

#require("tex2png.cnf");

$TMP_DIR = "/home/http/math/html/admin/tex2png/temp";

$LATEX_EXEC = "latex";
$DVIPS_EXEC = "dvips";
$GS_EXEC = "gs";
$PPMTOGIF = "pnmtopng";
$PNMCROP = "pnmcrop";
$PNMPAD = "pnmpad";
$PNMSCALE = "pnmscale";
$PNMGAMMA = "pnmgamma";
$PPMCHANGE = "ppmchange";
$rm = "rm";

$DEFAULT_BG_COLOR = "rgb:bf/bf/bf";

$latex_header = <<"MULTILINE";
\\documentclass{amsart} 
\\usepackage[cp1251]{inputenc}
\\usepackage[russian]{babel}
\\usepackage{amssymb}
\\usepackage{amsmath}
\\usepackage{graphics}
\\pagestyle{empty}  
\\thispagestyle{empty} 
\\begin{document} 
\\huge
MULTILINE

$latex_page_sep_string = "\n\n\\newpage\n\n";
$latex_eof_string = "\n\n\\end{document}\n";

$tex_input = $ARGV[0];
$png_name = $ARGV[1];

umask(022);

$png_file = $png_name;
$latex_file = $TMP_DIR."/_tex2pngtmp.tex";
$dvi_file = $latex_file;
$dvi_file =~ s/\.tex/\.dvi/;
$aux_file = $latex_file;
$aux_file =~ s/\.tex/\.aux/;
$log_file = $latex_file;
$log_file =~ s/\.tex/\.log/;
$ps_file = $latex_file;
$ps_file =~ s/\.tex/\.ps/;
$ppm_file = $latex_file;
$ppm_file =~ s/\.tex/\.ppm/;

open(TEXINPUT, "< $tex_input") || die "Can't open $tex_input \n";
open(LATEXFILE,"> $latex_file") || die "Can't open $latex_file \n";
print LATEXFILE $latex_header;
$img_num = 0;

if($ARGV[2] =~ /^-a/) {
    $img_num = 1;
    while(<TEXINPUT>) {
        print LATEXFILE;
    }
} else {
    while($str = <TEXINPUT>) {
        @formula = ($str =~ /(\$\$.+?\$\$)|(\$.+?\$)/s);
        foreach(@formula) {
            if($_ !~ /^\s*$/) {
                print LATEXFILE $_."\n" ;
                print LATEXFILE $latex_page_sep_string;
                $img_num++;
            }
        }
    }
}
print LATEXFILE $latex_eof_string;

#print "$LATEX_EXEC  -interaction=batchmode -output-directory=$TMP_DIR $latex_file";
#`$LATEX_EXEC  -interaction=batchmode -output-directory="$TMP_DIR" $latex_file`;
#`cd $TMP_DIR`;
`$LATEX_EXEC  -interaction=batchmode $latex_file`;
`mv _tex2pngtmp.* $TMP_DIR`;

foreach $i (1..$img_num) {
    $png_file = $png_name.$i.".png";

    `$DVIPS_EXEC -E -p=$i -l=$i -o $ps_file $dvi_file`;
    
    $SCALE_FACTOR = 2;
    open(FILE, "< $ps_file");
    $count = 0;
    while(<FILE>) {
            $count++;
            if (m/%%BoundingBox/) {
                    ($comment, $llx, $lly, $urx, $ury) = split();
                    last;
            } elsif ($count == 12) {
                    $llx = 0;
                    $lly = 0;
                    $urx = 8.5 * 72;
                    $ury = 11 * 72;
                    last;
            }
    }
    close(FILE);
    $width = $SCALE_FACTOR*($urx - $llx);
    $height = $SCALE_FACTOR*($ury - $lly);
    $reduction_factor = 1 / $SCALE_FACTOR;
    $resolv = sprintf("%dx%d", 72*$SCALE_FACTOR, 72*$SCALE_FACTOR);
    
#    print "echo $llx neg $lly neg translate | $GS_EXEC -sDEVICE=ppmraw -dEPScrop -sOutputFile=${ppm_file} -g${width}x${height} -r$resolv - ${ps_file}";
#    print "pnmgamma 1.0 $ppm_file | pnmcrop | pnmcrop -l | pnmpad -white -l5 -r5 -t5 -b5 | pnmscale $reduction_factor | pnmtopng -interlace -transparent rgb:bf/bf/bff > $png_file";
#    print "$rm $latex_file $dvi_file $aux_file $log_file $ps_file $ppm_file";
    
    `echo $llx neg $lly neg translate | $GS_EXEC -sDEVICE=ppmraw -dEPScrop -sOutputFile=${ppm_file} -g${width}x${height} -r$resolv - ${ps_file}`;
    `pnmgamma 1.0 $ppm_file | pnmcrop | pnmcrop -l | pnmpad -white -l5 -r5 -t5 -b5 | pnmscale $reduction_factor | pnmtopng -interlace -transparent rgb:ff/ff/fff > $png_file`;
    `$rm "$latex_file" "$dvi_file" "$aux_file" "$log_file" "$ps_file" "$ppm_file"`;
}
