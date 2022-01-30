/* global socket */
function openBrowser(link) {
	event.stopPropagation();
	socket.send('openbrowser', [link.href]);
	return false;
}
