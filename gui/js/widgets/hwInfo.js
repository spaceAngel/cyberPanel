/* global cyberPanel, config, sound */
var hwInfoWidget = {
	handle: function(data) {
		cyberPanel.hwInfo = data;
	},

	isStorageOverLimit: function() {
		for (var i = 0; i < cyberPanel.hwInfo.storages.length; i++) {
			var storage = cyberPanel.hwInfo.storages[i];
			if (Number(storage.available * 100 / storage.size).toFixed(1) < config.hwLimits.storage) {
				return true;
			}
		}
		return false;
	}
};