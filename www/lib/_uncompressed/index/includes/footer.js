

	addEvent(window, 'load', Wirah.init, false);

 	if (window.addEventListener) { 
		window.addEventListener('load', Wirah.init, false);
	} else if (window.attachEvent) { 
		window.attachEvent('onload', Wirah.init); 
	} else {
		elm['onload'] = Wirah.init;
	}

})(a);


//alert(Wirah.config.general.assetReleaseId);