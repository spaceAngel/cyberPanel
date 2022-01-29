<?php
use CyberPanel\System\Executer;

$eclipseIsActiveWindowChecker = function() {
	$win = Executer::execAndGetResponse('xdotool getactivewindow getwindowname');
	$titleSeachString = 'Eclipse IDE';
	return substr($win, -strlen($titleSeachString)) == $titleSeachString;
};

return [
	'development.db.mysql-workbench' => [
		'command' => 'mysql-workbench'
	],

	'development.eclipse' => [
		'icon' => '/snap/eclipse/48/icon.xpm',
	],

	'development.eclipse.shortcuts.formatCode' => [
		'command' => 'xdotool getactivewindow key Ctrl+Shift+f',
		'icon' => 'fa-indent',
		'subIcon' => '/snap/eclipse/48/icon.xpm',
		'checkEnabledFunction' => $eclipseIsActiveWindowChecker,
	],
	'development.eclipse.shortcuts.rename' => [
		'command' => 'xdotool getactivewindow key Shift+Alt+r',
		'icon' => 'fa-edit',
		'subIcon' => '/snap/eclipse/48/icon.xpm',
		'checkEnabledFunction' => $eclipseIsActiveWindowChecker,
	],
	'development.eclipse.shortcuts.toggleCommentCode' => [
		'command' => 'xdotool getactivewindow key Ctrl+Shift+c',
		'icon' => 'fa-hashtag',
		'subIcon' => '/snap/eclipse/48/icon.xpm',
		'checkEnabledFunction' => $eclipseIsActiveWindowChecker,
	],

	'development.eclipse.shortcuts.typeSearch' => [
		'command' => 'xdotool getactivewindow key Ctrl+Shift+t',
		'icon' => 'fa-text-height',
		'subIcon' => '/snap/eclipse/48/icon.xpm',
		'checkEnabledFunction' => $eclipseIsActiveWindowChecker,
	],


	'development.network.wireshark' => [
		'command' => '/usr/lib/x86_64-linux-gnu/libexec/kf5/kdesu wireshark',
		'icon' => '/usr/share/icons/hicolor/48x48/apps/wireshark.png',
	],

];
