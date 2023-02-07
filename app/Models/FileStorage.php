<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;

class FileStorage extends Model
{
    private $storage_dir = '2Phtt93Ag66Q8f';
    public  $allowed_ext_types = ["ccxml","davmount","dbk","docbook","xdssc","pfr","woff","gml","gpx","gz","ai","ink","inkml","lostxml","mads","mrcx","mathml","mml","mscml","mets","mods","tnef","tnf","xls","xlc","xll","xlm","xlw","xla","xlt","xld","ppz","ppt","pps","pot","doc","dot","dot","opf","omdoc","onetoc","onetoc2","onetmp","onepkg","owx","pdf","psd","pls","ppz","ppt","pps","pot","pskcxml","rdf","rdfs","owl","rif","rl","rld","rs","rsd","rss","sbml","shf","smi","smil","sml","kino","srx","grxml","sru","ssdl","ssml","tei","teicorpus","tfi","swf","spl","ai","xdp","appimage","m3u8","m3u","cdxml","clkw","wbs","rdz","uvt","uvvt","es3","et3","xdw","xbd","hal","zmm","ivp","ivu","irp","kwd","kwt","lasxml","lbe","lwp","xul","mdb","cil","asf","cab","xls","xlm","xla","xlc","xlt","xlw","xll","xld","xlam","xlsb","xlsm","xltm","eot","ims","lrm","thmx","cat","stl","ppt","pps","pot","ppz","ppam","pptm","sldm","ppsm","potm","mpp","mpt","pub","tnef","tnf","vsdm","vsdx","vssm","vssx","vstm","vstx","doc","docm","dotm","wps","wks","wcm","wdb","xlr","wpl","xps","oxps","dbk","docbook","odc","otc","odb","odf","odft","otf","odg","fodg","otg","odi","oti","odp","fodp","otp","ods","fods","ots","odt","fodt","odm","ott","oth","dd2","pptx","sldx","ppsx","potx","xlsx","xltx","docx","dotx","efif","wg","link66","sdkm","sdkd","sdc","sds","sda","sdd","sdp","smd","smf","sdw","vor","sgl","sgl","sdw","vor","odb","sxc","stc","sxd","std","sxi","sti","sxm","sxw","sxg","stw","xsm","bdm","xdm","uoml","vsd","vst","vss","vsw","vis","wbxml","wpd","wp","wp4","wp5","wp6","wpp","yt","zaz","vxml","wgt","wp","wp4","wp5","wp6","wpd","wpp","wsdl","wspolicy","7z","abw","abw.CRASHED","abw.gz","zabw","ace","pdb","pdc","as","aw","tar.bz2","tar.bz","tbz2","tbz","tb2","pdf.bz2","iso","iso9660","cfs","tar.gz","tgz","cpio.gz","dgc","dbk","docbook","ncx","dtb","res","fb2","flv","afm","bdf","psf","otf","pcf","pcf.Z","pcf.gz","snf","spd","ttf","ttx","pfa","pfb","pfm","afm","gsf","woff","iso","gca","po","gmo","mo","gpx","gramps","psf.gz","pdf.gz","hfe","appimage","iso","iso9660","kil","kpm","kwd","kwt","tar.lrz","tlrz","tar.lz4","lzh","lha","tar.lz","tar.lzma","tlz","pdf.lz","application","asx","wax","wvx","wmx","exe","lnk","wim","swm","wmd","wmz","xbap","xls","xlc","xll","xlm","xlw","xla","xlt","xld","ppz","ppt","pps","pot","doc","pdf","psd","psw","rar","sms","t3","obj","sap","iso","themepack","wp","wp4","wp5","wp6","wpd","wpp","xlf","xspf","tar.xz","txz","pdf.xz","zip","fb2.zip","xaml","xdf","xenc","xlf","xliff","xml","xsl","xbl","xsd","rng","dtd","xop","xpl","xslt","xsl","xspf","mxml","xhvml","xvml","xvm","yin","zip","cdx","cif","cmdf","cml","csml","xyz","ttc","otf","ttf","woff","woff2","woff2","bmp","dib","cdr","cgm","emf","g3","fits","g3","gif","heic","heif","heic","heif","heic","heif","heic","heif","ico","ico","ief","jp2","jpg2","jpeg","jpg","jpe","jp2","jpg2","jp2","jpg2","jpm","jpgm","jpf","jpx","ktx","ora","pdf","psd","jpeg","jpg","jpe","png","btif","psd","rle","sgi","svg","svg","svgz","svgz","tiff","tif","psd","uvi","uvvi","uvg","uvvg","djvu","djv","djvu","djv","sub","dwg","dxf","fbs","fpx","fst","mmr","rlc","ico","mdi","wdp","rp","wbmp","xif","pcx","webp","wmf","3ds","dng","ag","bmp","dib","eps.bz2","epsi.bz2","epsf.bz2","cr2","crw","cdr","ras","cmx","xcf.gz","xcf.bz2","dds","djvu","djv","emf","eps","epsi","epsf","exr","fits","fh","fhc","fh4","fh5","fh7","raf","gbr","gih","pat","eps.gz","epsi.gz","epsf.gz","tga","icb","tpic","vda","vst","icns","ico","ico","iff","ilbm","lbm","iff","ilbm","lbm","jng","jp2","jpg2","dcr","k25","kdc","lwo","lwob","lws","pntg","mrw","sid","bmp","dib","msod","nef","orf","pcx","pef","pcd","psd","pic","pct","pict","pict1","pict2","pnm","pbm","pgm","ppm","psd","qtif","qif","rgb","sgi","x3f","sk","sk1","sun","tga","icb","tpic","vda","vst","cur","wmf","xbm","xcf","fig","xpm","xpm","xwd","djvu","djv","igs","iges","msh","mesh","silo","stl","dae","dwf","gdl","gtw","mts","vtu","wrl","vrml","vrm","stl","stl","ics","ifb","vcs","css","csv","csvs","vcard","vcf","vct","gcrd","ged","gedcom","ico","mml","n3","txt","text","conf","def","list","log","in","asc","dsc","rdf","rdfs","owl","rtx","rss","rtf","rs","sgml","sgm","sylk","slk","tsv","t","tr","roff","man","me","ms","ttl","uri","uris","urls","vcard","vcf","vct","gcrd","sub","fly","flx","gv","dot","3dml","spot","ts","rt","ts","vtt","adb","ads","s","asm","bib","c","cc","cxx","cpp","h","hh","dic","h","cmake","csv","c","csv","dcl","diff","patch","dsl","d","di","dtd","e","eif","el","gs","po","pot","feature","go","idl","imy","ime","iptables","ldif","ly","log","lua","lyx","mk","mak","m","sub","moc","mo","mof","sub","mrml","mrl","reg","mup","not","nfo","m","ml","mli","ocl","m","ooc","cl","opml","opml","diff","patch","po","pot","qml","qmltypes","qmlproject","spec","sass","scm","ss","scss","etx","sfv","sub","svh","sv","automount","device","mount","path","scope","service","slice","socket","swap","target","timer","tcl","tk","tex","ltx","sty","cls","dtx","ins","latex","texi","texinfo","tr","roff","t","me","mm","ms","twig","t2t","uil","uu","uue","vala","vapi","vcs","ics","vcf","vcard","vct","gcrd","v","vhd","vhdl","xmi","fo","xslfo","xml","xbl","xsd","rng","3gp","3gpp","3ga","3gp","3gpp","3ga","3gp","3gpp","3ga","3g2","3gp2","3gpp2","axv","avi","avf","divx","avi","avf","divx","dv","fli","flc","flv","h261","h263","h264","jpgv","jpm","jpgm","mj2","mjp2","m2t","m2ts","ts","mts","cpi","clpi","mpl","mpls","bdm","bdmv","mp4","mp4v","mpg4","m4v","f4v","lrv","mp4","m4v","f4v","lrv","mpeg","mpg","mpe","m1v","m2v","mp2","vob","mpeg","mpg","mp2","mpe","vob","avi","avf","divx","ogv","ogg","qt","mov","moov","qtvr","viv","vivo","uvh","uvvh","uvm","uvvm","uvp","uvvp","uvs","uvvs","uvv","uvvv","avi","avf","divx","dvb","fvt","mxu","m4u","m1u","pyv","rv","rvx","uvu","uvvu","viv","vivo","webm","axv","avi","avf","divx","f4v","fli","flc","fli","flc","flv","m4v","mp4","f4v","lrv","mkv","mk3d","mks","mk3d","mjpeg","mjpg","mng","mpeg","mpg","mp2","mpe","vob","mpeg","mpg","mp2","mpe","vob","mpeg","mpg","mp2","mpe","vob","m1u","m4u","mxu","asf","asx","asf","vob","asx","wax","wvx","wmx","wm","asf","wmv","wmx","asx","wax","wvx","wvx","asx","wax","wmx","avi","avf","divx","nsv","ogv","ogg","ogm","ogm","rv","rvx","movie","smv","ogg","ogg","doc"];
    public $allowed_mime_types = ["application/ccxml+xml","application/davmount+xml","application/docbook+xml","application/dssc+xml","application/font-tdpfr","application/font-woff","application/gml+xml","application/gpx+xml","application/gzip","application/illustrator","application/inkml+xml","application/lost+xml","application/mads+xml","application/marcxml+xml","application/mathml+xml","application/mediaservercontrol+xml","application/mets+xml","application/mods+xml","application/ms-tnef","application/msexcel","application/mspowerpoint","application/msword","application/msword-template","application/oebps-package+xml","application/omdoc+xml","application/onenote","application/owl+xml","application/pdf","application/photoshop","application/pls+xml","application/powerpoint","application/pskc+xml","application/rdf+xml","application/reginfo+xml","application/resource-lists+xml","application/resource-lists-diff+xml","application/rls-services+xml","application/rsd+xml","application/rss+xml","application/sbml+xml","application/shf+xml","application/smil+xml","application/sparql-results+xml","application/srgs+xml","application/sru+xml","application/ssdl+xml","application/ssml+xml","application/tei+xml","application/thraud+xml","application/vnd.adobe.flash.movie","application/vnd.adobe.illustrator","application/vnd.adobe.xdp+xml","application/vnd.appimage","application/vnd.apple.mpegurl","application/vnd.chemdraw+xml","application/vnd.crick.clicker.wordbank","application/vnd.criticaltools.wbs+xml","application/vnd.data-vision.rdz","application/vnd.dece.ttml+xml","application/vnd.eszigno3+xml","application/vnd.fujixerox.docuworks","application/vnd.fujixerox.docuworks.binder","application/vnd.hal+xml","application/vnd.handheld-entertainment+xml","application/vnd.immervision-ivp","application/vnd.immervision-ivu","application/vnd.irepository.package+xml","application/vnd.kde.kword","application/vnd.las.las+xml","application/vnd.llamagraphics.life-balance.exchange+xml","application/vnd.lotus-wordpro","application/vnd.mozilla.xul+xml","application/vnd.ms-access","application/vnd.ms-artgalry","application/vnd.ms-asf","application/vnd.ms-cab-compressed","application/vnd.ms-excel","application/vnd.ms-excel.addin.macroenabled.12","application/vnd.ms-excel.sheet.binary.macroenabled.12","application/vnd.ms-excel.sheet.macroenabled.12","application/vnd.ms-excel.template.macroenabled.12","application/vnd.ms-fontobject","application/vnd.ms-ims","application/vnd.ms-lrm","application/vnd.ms-officetheme","application/vnd.ms-pki.seccat","application/vnd.ms-pki.stl","application/vnd.ms-powerpoint","application/vnd.ms-powerpoint.addin.macroenabled.12","application/vnd.ms-powerpoint.presentation.macroenabled.12","application/vnd.ms-powerpoint.slide.macroenabled.12","application/vnd.ms-powerpoint.slideshow.macroenabled.12","application/vnd.ms-powerpoint.template.macroenabled.12","application/vnd.ms-project","application/vnd.ms-publisher","application/vnd.ms-tnef","application/vnd.ms-visio.drawing.macroenabled.main+xml","application/vnd.ms-visio.drawing.main+xml","application/vnd.ms-visio.stencil.macroenabled.main+xml","application/vnd.ms-visio.stencil.main+xml","application/vnd.ms-visio.template.macroenabled.main+xml","application/vnd.ms-visio.template.main+xml","application/vnd.ms-word","application/vnd.ms-word.document.macroenabled.12","application/vnd.ms-word.template.macroenabled.12","application/vnd.ms-works","application/vnd.ms-wpl","application/vnd.ms-xpsdocument","application/vnd.oasis.docbook+xml","application/vnd.oasis.opendocument.chart","application/vnd.oasis.opendocument.chart-template","application/vnd.oasis.opendocument.database","application/vnd.oasis.opendocument.formula","application/vnd.oasis.opendocument.formula-template","application/vnd.oasis.opendocument.graphics","application/vnd.oasis.opendocument.graphics-flat-xml","application/vnd.oasis.opendocument.graphics-template","application/vnd.oasis.opendocument.image","application/vnd.oasis.opendocument.image-template","application/vnd.oasis.opendocument.presentation","application/vnd.oasis.opendocument.presentation-flat-xml","application/vnd.oasis.opendocument.presentation-template","application/vnd.oasis.opendocument.spreadsheet","application/vnd.oasis.opendocument.spreadsheet-flat-xml","application/vnd.oasis.opendocument.spreadsheet-template","application/vnd.oasis.opendocument.text","application/vnd.oasis.opendocument.text-flat-xml","application/vnd.oasis.opendocument.text-master","application/vnd.oasis.opendocument.text-template","application/vnd.oasis.opendocument.text-web","application/vnd.oma.dd2+xml","application/vnd.openxmlformats-officedocument.presentationml.presentation","application/vnd.openxmlformats-officedocument.presentationml.slide","application/vnd.openxmlformats-officedocument.presentationml.slideshow","application/vnd.openxmlformats-officedocument.presentationml.template","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/vnd.openxmlformats-officedocument.spreadsheetml.template","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/vnd.openxmlformats-officedocument.wordprocessingml.template","application/vnd.picsel","application/vnd.pmi.widget","application/vnd.route66.link66+xml","application/vnd.solent.sdkm+xml","application/vnd.stardivision.calc","application/vnd.stardivision.chart","application/vnd.stardivision.draw","application/vnd.stardivision.impress","application/vnd.stardivision.mail","application/vnd.stardivision.math","application/vnd.stardivision.writer","application/vnd.stardivision.writer-global","application/vnd.sun.xml.base","application/vnd.sun.xml.calc","application/vnd.sun.xml.calc.template","application/vnd.sun.xml.draw","application/vnd.sun.xml.draw.template","application/vnd.sun.xml.impress","application/vnd.sun.xml.impress.template","application/vnd.sun.xml.math","application/vnd.sun.xml.writer","application/vnd.sun.xml.writer.global","application/vnd.sun.xml.writer.template","application/vnd.syncml+xml","application/vnd.syncml.dm+wbxml","application/vnd.syncml.dm+xml","application/vnd.uoml+xml","application/vnd.visio","application/vnd.visionary","application/vnd.wap.wbxml","application/vnd.wordperfect","application/vnd.youtube.yt","application/vnd.zzazz.deck+xml","application/voicexml+xml","application/widget","application/wordperfect","application/wsdl+xml","application/wspolicy+xml","application/x-7z-compressed","application/x-abiword","application/x-ace-compressed","application/x-aportisdoc","application/x-applix-spreadsheet","application/x-applix-word","application/x-bzip-compressed-tar","application/x-bzpdf","application/x-cd-image","application/x-cfs-compressed","application/x-compressed-tar","application/x-cpio-compressed","application/x-dgc-compressed","application/x-docbook+xml","application/x-dtbncx+xml","application/x-dtbook+xml","application/x-dtbresource+xml","application/x-fictionbook+xml","application/x-flash-video","application/x-font-afm","application/x-font-bdf","application/x-font-linux-psf","application/x-font-otf","application/x-font-pcf","application/x-font-snf","application/x-font-speedo","application/x-font-ttf","application/x-font-ttx","application/x-font-type1","application/x-font-woff","application/x-gamecube-iso-image","application/x-gca-compressed","application/x-gettext","application/x-gettext-translation","application/x-gpx+xml","application/x-gramps-xml","application/x-gz-font-linux-psf","application/x-gzpdf","application/x-hfe-floppy-image","application/x-iso9660-appimage","application/x-iso9660-image","application/x-killustrator","application/x-kpovmodeler","application/x-kword","application/x-lrzip-compressed-tar","application/x-lz4-compressed-tar","application/x-lzh-compressed","application/x-lzip-compressed-tar","application/x-lzma-compressed-tar","application/x-lzpdf","application/x-ms-application","application/x-ms-asx","application/x-ms-dos-executable","application/x-ms-shortcut","application/x-ms-wim","application/x-ms-wmd","application/x-ms-wmz","application/x-ms-xbap","application/x-msexcel","application/x-mspowerpoint","application/x-msword","application/x-pdf","application/x-photoshop","application/x-pocket-word","application/x-rar-compressed","application/x-sms-rom","application/x-t3vm-image","application/x-tgif","application/x-thomson-sap-image","application/x-wii-iso-image","application/x-windows-themepack","application/x-wordperfect","application/x-xliff+xml","application/x-xspf+xml","application/x-xz-compressed-tar","application/x-xzpdf","application/x-zip-compressed","application/x-zip-compressed-fb2","application/xaml+xml","application/xcap-diff+xml","application/xenc+xml","application/xliff+xml","application/xml","application/xml-dtd","application/xop+xml","application/xproc+xml","application/xslt+xml","application/xspf+xml","application/xv+xml","application/yin+xml","application/zip","chemical/x-cdx","chemical/x-cif","chemical/x-cmdf","chemical/x-cml","chemical/x-csml","chemical/x-xyz","font/collection","font/otf","font/ttf","font/woff","font/woff2","image/bmp","image/cdr","image/cgm","image/emf","image/fax-g3","image/fits","image/g3fax","image/gif","image/heic","image/heic-sequence","image/heif","image/heif-sequence","image/ico","image/icon","image/ief","image/jp2","image/jpeg","image/jpeg2000","image/jpeg2000-image","image/jpm","image/jpx","image/ktx","image/openraster","image/pdf","image/photoshop","image/pjpeg","image/png","image/prs.btif","image/psd","image/rle","image/sgi","image/svg","image/svg+xml","image/svg+xml-compressed","image/tiff","image/vnd.adobe.photoshop","image/vnd.dece.graphic","image/vnd.djvu","image/vnd.djvu+multipage","image/vnd.dvb.subtitle","image/vnd.dwg","image/vnd.dxf","image/vnd.fastbidsheet","image/vnd.fpx","image/vnd.fst","image/vnd.fujixerox.edmics-mmr","image/vnd.fujixerox.edmics-rlc","image/vnd.microsoft.icon","image/vnd.ms-modi","image/vnd.ms-photo","image/vnd.rn-realpix","image/vnd.wap.wbmp","image/vnd.xiff","image/vnd.zbrush.pcx","image/webp","image/wmf","image/x-3ds","image/x-adobe-dng","image/x-applix-graphics","image/x-bmp","image/x-bzeps","image/x-canon-cr2","image/x-canon-crw","image/x-cdr","image/x-cmu-raster","image/x-cmx","image/x-compressed-xcf","image/x-dds","image/x-djvu","image/x-emf","image/x-eps","image/x-exr","image/x-fits","image/x-freehand","image/x-fuji-raf","image/x-gimp-gbr","image/x-gimp-gih","image/x-gimp-pat","image/x-gzeps","image/x-icb","image/x-icns","image/x-ico","image/x-icon","image/x-iff","image/x-ilbm","image/x-jng","image/x-jpeg2000-image","image/x-kodak-dcr","image/x-kodak-k25","image/x-kodak-kdc","image/x-lwo","image/x-lws","image/x-macpaint","image/x-minolta-mrw","image/x-mrsid-image","image/x-ms-bmp","image/x-msod","image/x-nikon-nef","image/x-olympus-orf","image/x-pcx","image/x-pentax-pef","image/x-photo-cd","image/x-photoshop","image/x-pict","image/x-portable-anymap","image/x-portable-bitmap","image/x-portable-graymap","image/x-portable-pixmap","image/x-psd","image/x-quicktime","image/x-rgb","image/x-sgi","image/x-sigma-x3f","image/x-skencil","image/x-sun-raster","image/x-tga","image/x-win-bitmap","image/x-wmf","image/x-xbitmap","image/x-xcf","image/x-xfig","image/x-xpixmap","image/x-xpm","image/x-xwindowdump","image/x.djvu","model/iges","model/mesh","model/stl","model/vnd.collada+xml","model/vnd.dwf","model/vnd.gdl","model/vnd.gtw","model/vnd.mts","model/vnd.vtu","model/vrml","model/x.stl-ascii","model/x.stl-binary","text/calendar","text/css","text/csv","text/csv-schema","text/directory","text/gedcom","text/ico","text/mathml","text/n3","text/plain","text/prs.lines.tag","text/rdf","text/richtext","text/rss","text/rtf","text/rust","text/sgml","text/spreadsheet","text/tab-separated-values","text/troff","text/turtle","text/uri-list","text/vcard","text/vnd.dvb.subtitle","text/vnd.fly","text/vnd.fmi.flexstor","text/vnd.graphviz","text/vnd.in3d.3dml","text/vnd.in3d.spot","text/vnd.qt.linguist","text/vnd.rn-realtext","text/vnd.trolltech.linguist","text/vtt","text/x-adasrc","text/x-asm","text/x-bibtex","text/x-c","text/x-chdr","text/x-cmake","text/x-comma-separated-values","text/x-csrc","text/x-csv","text/x-dcl","text/x-diff","text/x-dsl","text/x-dsrc","text/x-dtd","text/x-eiffel","text/x-emacs-lisp","text/x-genie","text/x-gettext-translation","text/x-gettext-translation-template","text/x-gherkin","text/x-go","text/x-idl","text/x-imelody","text/x-iptables","text/x-ldif","text/x-lilypond","text/x-log","text/x-lua","text/x-lyx","text/x-makefile","text/x-matlab","text/x-microdvd","text/x-moc","text/x-modelica","text/x-mof","text/x-mpsub","text/x-mrml","text/x-ms-regedit","text/x-mup","text/x-nfo","text/x-objcsrc","text/x-ocaml","text/x-ocl","text/x-octave","text/x-ooc","text/x-opencl-src","text/x-opml","text/x-opml+xml","text/x-patch","text/x-po","text/x-pot","text/x-qml","text/x-rpm-spec","text/x-sass","text/x-scheme","text/x-scss","text/x-setext","text/x-sfv","text/x-subviewer","text/x-svhdr","text/x-svsrc","text/x-systemd-unit","text/x-tcl","text/x-tex","text/x-texinfo","text/x-troff","text/x-troff-me","text/x-troff-mm","text/x-troff-ms","text/x-twig","text/x-txt2tags","text/x-uil","text/x-uuencode","text/x-vala","text/x-vcalendar","text/x-vcard","text/x-verilog","text/x-vhdl","text/x-xmi","text/x-xslfo","text/xml","video/3gp","video/3gpp","video/3gpp-encrypted","video/3gpp2","video/annodex","video/avi","video/divx","video/dv","video/fli","video/flv","video/h261","video/h263","video/h264","video/jpeg","video/jpm","video/mj2","video/mp2t","video/mp4","video/mp4v-es","video/mpeg","video/mpeg-system","video/msvideo","video/ogg","video/quicktime","video/vivo","video/vnd.dece.hd","video/vnd.dece.mobile","video/vnd.dece.pd","video/vnd.dece.sd","video/vnd.dece.video","video/vnd.divx","video/vnd.dvb.file","video/vnd.fvt","video/vnd.mpegurl","video/vnd.ms-playready.media.pyv","video/vnd.rn-realvideo","video/vnd.uvvu.mp4","video/vnd.vivo","video/webm","video/x-annodex","video/x-avi","video/x-f4v","video/x-fli","video/x-flic","video/x-flv","video/x-m4v","video/x-matroska","video/x-matroska-3d","video/x-mjpeg","video/x-mng","video/x-mpeg","video/x-mpeg-system","video/x-mpeg2","video/x-mpegurl","video/x-ms-asf","video/x-ms-asf-plugin","video/x-ms-vob","video/x-ms-wax","video/x-ms-wm","video/x-ms-wmv","video/x-ms-wmx","video/x-ms-wvx","video/x-msvideo","video/x-nsv","video/x-ogg","video/x-ogm","video/x-ogm+ogg","video/x-real-video","video/x-sgi-movie","video/x-smv","video/x-theora","video/x-theora+ogg","zz-application/zz-winassoc-doc"];
    protected $storage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'customer_link' ,  'file_key', 'permanent_file', 'company_link', 'uploaded_timestamp', 'project_link'
    ];

    public function __constructor(){
        $this->storage =  '/' . $this->storage_dir . '/companyRegister' . session('company_link') . '_storage';
    }

    final protected function getCompanyStorage(){
        $storage = '/' . $this->storage_dir . '/companyRegister' . session('company_link') . '_storage';
        return $storage;
    }

    final protected function availableCompanyStorage(){
        $company = new Company();
        $companyObject = $company->getCompanyCacheObject();

        $company_storage_amount = $companyObject["storage_amount"];

        if($companyObject["active_subscription"] === 0){
            $available_storage = 5000000000 - $company_storage_amount; //5GB limit for trial period
        }else{
            $available_storage = 200000000000000 - $company_storage_amount;
        }

        return $available_storage;
    }

    final protected function determineCompanyStorageSize(){
        //foldersize();
        //SELECT ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024),2) FROM  information_schema.TABLES WHERE TABLE_SCHEMA = "portfolioDemo" AND TABLE_NAME = "users";
    }

    final protected function fileSizeLimitCheck($file_size, $file_purpose){
        $purpose_limit = 20000000000;

        switch($file_purpose){
            case 'transaction_attachment':
                $purpose_limit = 250000000;
                break;
            default: $purpose_limit = 20000000000;break;
        }

        if($file_size > $purpose_limit){return false;}

        $available_storage = $this->availableCompanyStorage();

        if($file_size > $available_storage){
            return false;
        }

        return true;
    }

    final protected function createFileKey($file){
        $org_file_name = $file->getClientOriginalName();
        $file_extension = $file->guessExtension();
        $ext_key = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6/strlen($x)) )),1,6);
        $file_key = $org_file_name . '_' . time() . '_' . session('id') . '_' .  $ext_key . '.' . $file_extension;
        return $file_key;
    }

    final protected function isValidFile($file){
        $file_extension = $file->guessExtension();
        $file_mime = $file->getMimeType();

        if($file->isValid() && in_array($file_extension, $this->allowed_ext_types) && in_array($file_mime, $this->allowed_mime_types)
        ){
            return true;
        }else{
            return false;
        }
    }

    final protected static function fetchFileDetails($file_key){

        $result = DB::table('file_storage')
            ->where('file_key' , '=' , $file_key)
            ->where('company_link' , '=' , session('company_link'))
            ->first();

        return $result;
    }

    final protected static function toggleFilePrivacy($file_key){
        $privacy = DB::table('file_storage')
            ->where('company_link', session('company_link'))
            ->where('file_key' , '=' , $file_key)
            ->value('file_privacy');

        $updatedPrivacy = ($privacy == true) ? false : true ;

        $result = DB::table('file_storage')
            ->where('company_link', session('company_link'))
            ->where('file_key' , '=' , $file_key)
            ->update(['file_privacy' => $updatedPrivacy ]);

        return $result;
    }

    final public static function temporaryStoreAttachment($file_name, $file_privacy , $file_key)
    {
        $id = session('id');

        $privacy = ($file_privacy === "true") ? true : false;

        $result = DB::table('file_storage')
            ->insert(['user_id' => $id, 'file_key' => $file_key , 'file_name' => $file_name , 'file_privacy' => $privacy , 'permanent_file' => false , 'company_link' => session('company_link') , 'uploaded_timestamp' => time()]);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    final public function fileBelongsToUser($file_key)
    {
        $result = DB::table('file_storage')
            ->where('user_id' , '=' , session('id'))
            ->where('file_key' , '=' , $file_key)
            ->value('user_id');

        return ($result === session('id')) ? true : false ;
    }

    final public function deleteTemporaryStoredFile($file_key){

        $result = DB::table('file_storage')
            ->where('company_link', '=', session('company_link'))
            ->where('file_key', '=' , $file_key)
            ->where('user_id' , '=' , session('id'))
            ->delete();

        return $result;
    }

    final public static function convertTempCustomerFilesToPermanent($files , $customer_id){

        foreach($files as $file){

            $file_key = $file["attachmentFileKey"];
            $file_name = $file["fileName"];

            $update_array = ['customer_link' => $customer_id , 'permanent_file'  => true];

            if($file_name && $file_name !== ""){
                $update_array["file_name"] = $file_name;
            }

            if($file_name && $file_name !== ""){
                $update_array["project_link"] = $file_name;
            }

            $result = DB::table('file_storage')
                ->where('user_id' , '=' , session('id'))
                ->where('company_link', session('company_link'))
                ->where('file_key' , '=' , $file_key)
                ->update($update_array);

        }

        return true;
    }

    final public function storeTransactionFileAttachment($file, $customer_id = "", $project_id = ""){

        $file_size = $file->getSize();

        if($this->isValidFile($file) && $this->fileSizeLimitCheck(10 ,"transaction_attachment")){

            $id = session('id');
            $file_key = $this->createFileKey($file);
            $file_name = $file->getClientOriginalName();

            $stored = $file->storeAs($this->storage , $file_key  , ["visibility" => "private"]);

            if($stored){
                $result = DB::table('file_storage')
                    ->insert(['user_id' => $id, 'file_key' => $file_key , 'file_name' => $file_name , 'file_privacy' => false , 'permanent_file' => true , 'company_link' => session('company_link'), 'customer_link' => $customer_id , 'project_link' => $project_id ,'uploaded_timestamp' => time()]);
            }
        }else{
            return false;
        }

        if($result){
            return $file_key;
        }else{
            return false;
        }
    }
}
