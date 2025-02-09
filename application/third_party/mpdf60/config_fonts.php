<?php

// Optionally define a folder which contains TTF fonts
// mPDF will look here before looking in the usual _MPDF_TTFONTPATH
// Useful if you already have a folder for your fonts
// e.g. on Windows: define("_MPDF_SYSTEM_TTFONTS", 'C:/Windows/Fonts/');

//if (!defined("_MPDF_SYSTEM_TTFONTS")) { define("_MPDF_SYSTEM_TTFONTS", 'C:/xampp/htdocs/common/ttffonts/'); }

// Optionally set font(s) (names as defined below in $this->fontdata) to use for missing characters
// when using useSubstitutions. Use a font with wide coverage - dejavusanscondensed is a good start
// only works using subsets (otherwise would add very large file)
// More than 1 font can be specified but each will add to the processing time of the script

$this->backupSubsFont = array('dejavusanscondensed', 'simsun');

// Optionally set a font (name as defined below in $this->fontdata) to use for CJK characters
// in Plane 2 Unicode (> U+20000) when using useSubstitutions.
// Use a font like hannomb or sun-extb if available
// only works using subsets (otherwise would add very large file)

$this->backupSIPFont = '';

/*
  This array defines translations from font-family in CSS or HTML
  to the internal font-family name used in mPDF.
  Can include as many as want, regardless of which fonts are installed.
  By default mPDF will take a CSS/HTML font-family and remove spaces
  and change to lowercase e.g. "Arial Unicode MS" will be recognised as
  "arialunicodems"
  You only need to define additional translations.
  You can also use it to define specific substitutions e.g.
  'helvetica' => 'arial'
  Generic substitutions (i.e. to a sans-serif or serif font) are set
  by including the font-family in e.g. $this->sans_fonts below
 */
$this->fonttrans = array(
	'times' => 'timesnewroman',
	'courier' => 'couriernew',
	'trebuchet' => 'trebuchetms',
	'comic' => 'comicsansms',
	'franklin' => 'franklingothicbook',
	'ocr-b' => 'ocrb',
	'ocr-b10bt' => 'ocrb',
	'damase' => 'mph2bdamase',
);

/*
  This array lists the file names of the TrueType .ttf or .otf font files
  for each variant of the (internal mPDF) font-family name.
  ['R'] = Regular (Normal), others are Bold, Italic, and Bold-Italic
  Each entry must contain an ['R'] entry, but others are optional.
  Only the font (files) entered here will be available to use in mPDF.
  Put preferred default first in order
  This will be used if a named font cannot be found in any of
  $this->sans_fonts, $this->serif_fonts or $this->mono_fonts

  ['sip-ext'] = 'sun-extb'; name a related font file containing SIP characters
  ['useOTL'] => 0xFF,	Enable use of OTL features.
  ['useKashida'] => 75,	Enable use of kashida for text justification in Arabic text

  If a .ttc TrueType collection file is referenced, the number of the font
  within the collection is required. Fonts in the collection are numbered
  starting at 1, as they appear in the .ttc file e.g.
  "cambria" => array(
  'R' => "cambria.ttc",
  'B' => "cambriab.ttf",
  'I' => "cambriai.ttf",
  'BI' => "cambriaz.ttf",
  'TTCfontID' => array(
  'R' => 1,
  ),
  ),
  "cambriamath" => array(
  'R' => "cambria.ttc",
  'TTCfontID' => array(
  'R' => 2,
  ),
  ),
 */

$this->fontdata = array(
	"dejavusanscondensed" => array(
		'R' => "DejaVuSansCondensed.ttf",
		'B' => "DejaVuSansCondensed-Bold.ttf",
		'I' => "DejaVuSansCondensed-Oblique.ttf",
		'useOTL' => 0xFF,
		'useKashida' => 75,
	),
	"garuda" => array(/* Thai */
		'R' => "Garuda.ttf",
		'B' => "Garuda-Bold.ttf",
		'I' => "Garuda-Oblique.ttf",
		'useOTL' => 0xFF,
	),
	/* Arabic fonts */
	"xbriyaz" => array(
		'R' => "XB Riyaz.ttf",
		'B' => "XB RiyazBd.ttf",
		'I' => "XB RiyazIt.ttf",
		'useOTL' => 0xFF,
		'useKashida' => 75,
	),
	/* CJK fonts */
	"simsun" => array(
		'R' => "SimSun.ttf",
	),
	"unbatang" => array(/* Korean */
		'R' => "UnBatang_0613.ttf",
	),
	"devanagari" => array(/* Korean */
		'R' => "Devanagari.ttf",
	),
);


// Add fonts to this array if they contain characters in the SIP or SMP Unicode planes
// but you do not require them. This allows a more efficient form of subsetting to be used.
$this->BMPonly = array(
	"dejavusanscondensed"
);

// These next 3 arrays do two things:
// 1. If a font referred to in HTML/CSS is not available to mPDF, these arrays will determine whether
//    a serif/sans-serif or monospace font is substituted
// 2. The first font in each array will be the font which is substituted in circumstances as above
//     (Otherwise the order is irrelevant)
// Use the mPDF font-family names i.e. lowercase and no spaces (after any translations in $fonttrans)
// Always include "sans-serif", "serif" and "monospace" etc.
$this->sans_fonts = array('dejavusanscondensed', 'sans', 'sans-serif', 'cursive', 'fantasy', 'dejavusans', 'freesans', 'liberationsans',
	'arial', 'helvetica', 'verdana', 'geneva', 'lucida', 'arialnarrow', 'arialblack', 'arialunicodems',
	'franklin', 'franklingothicbook', 'tahoma', 'garuda', 'calibri', 'trebuchet', 'lucidagrande', 'microsoftsansserif',
	'trebuchetms', 'lucidasansunicode', 'franklingothicmedium', 'albertusmedium', 'xbriyaz', 'albasuper', 'quillscript',
	'humanist777', 'humanist777black', 'humanist777light', 'futura', 'hobo', 'segoeprint',
);

$this->serif_fonts = array('dejavuserifcondensed', 'serif', 'dejavuserif', 'freeserif', 'liberationserif',
	'timesnewroman', 'times', 'centuryschoolbookl', 'palatinolinotype', 'centurygothic',
	'bookmanoldstyle', 'bookantiqua', 'cyberbit', 'cambria',
	'norasi', 'charis', 'palatino', 'constantia', 'georgia', 'albertus', 'xbzar', 'algerian', 'garamond'
);

$this->mono_fonts = array('dejavusansmono', 'mono', 'monospace', 'freemono', 'liberationmono', 'courier', 'ocrb', 'ocr-b', 'lucidaconsole',
	'couriernew', 'monotypecorsiva',
);
