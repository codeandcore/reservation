<?php
$config = array();
$config['authentication'] = function() {
    return true; // Proper authentication should be added
};

$config['backends'][] = array(
    'name'         => 'default',
    'adapter'      => 'local',
    'baseUrl'      => '/ckfinder/userfiles/',
//  'root'         => '', // Can be used to explicitly set the CKFinder user files directory.
    'chmodFiles'   => 0755,
    'chmodFolders' => 0755,
    'filesystemEncoding' => 'UTF-8',
);

$config['defaultResourceTypes'] = '';
$config['resourceTypes'][] = array(
    'name'              => 'Files',
    'directory'         => 'files',
    'maxSize'           => 0,
    'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,html,jar,jpeg,jpg,mid,mov,mp3,mp4,mpeg,mpg,ods,odt,ogg,pdf,pcx,png,ppt,pptx,rar,rtf,tar,tgz,tiff,txt,wav,webm,wma,wmv,xls,xlsx,zip',
    'deniedExtensions'  => '',
);

$config['resourceTypes'][] = array(
    'name'              => 'Images',
    'directory'         => 'images',
    'maxSize'           => 0,
    'allowedExtensions' => 'bmp,gif,jpeg,jpg,png,webp,svg',
    'deniedExtensions'  => '',
);

$config['accessControl'][] = array(
    'role' => '*',
    'resourceType' => '*',
    'folder' => '/',
    'FOLDER_VIEW' => true,
    'FOLDER_CREATE' => true,
    'FOLDER_RENAME' => true,
    'FOLDER_DELETE' => true,
    'FILE_VIEW' => true,
    'FILE_UPLOAD' => true,
    'FILE_RENAME' => true,
    'FILE_DELETE' => true,
);

$config['overwriteOnUpload'] = false;
$config['checkDoubleExtension'] = true;
$config['disallowUnsafeCharacters'] = true;
$config['secureImageUploads'] = true;
$config['checkSizeAfterScaling'] = true;
$config['htmlExtensions'] = array('html', 'htm', 'xml', 'js');
$config['hideFolders'] = array('.*', 'CVS', '__thumbs');
$config['hideFiles'] = array('.*');
$config['forceAscii'] = false;
$config['xSendfile'] = false;

// Debug setting
$config['debug'] = true;

// Disable image resizing
$config['images'] = array(
    'maxWidth' => 0, // Disable resizing
    'maxHeight' => 0, // Disable resizing
    'quality' => 100 // Maintain original quality
);

$config['thumbnails'] = array(
    'enabled' => false, // Disable thumbnails
);

return $config;