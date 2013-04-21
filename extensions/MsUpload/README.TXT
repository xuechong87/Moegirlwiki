##Start --------------------------------------- MsUpload
##if necessary
#$wgEnableWriteAPI = true; //API
#$wgEnableUploads = true; // Enable uploads
#$wgFileExtensions = array('png','gif','jpg','jpeg','doc','xls','mpp','pdf','ppt','tiff','bmp','docx', 'xlsx', 'pptx','ps','odt','ods','odp','odg');

$wgMSU_ShowAutoKat = true;     #autokategorisierung
$wgMSU_CheckedAutoKat = true;  #checkbox: checked = true/false
$wgMSU_debug = false;
require_once("$IP/extensions/MsUpload/msupload.php");
##End  --------------------------------------- MsUpload