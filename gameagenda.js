function countdown(then) 
{
	// Constructor logic
	this.then = then;
	diff_ch	= new Date(this.then - (new Date()) );
	
	if ( diff_ch > 0 ) {
		start(then);	
	}

	function setElement(id, value) 
	{
		if (value.length < 2) value = "0" + value;
		var element = document.getElementById(id);
		if (element) element.innerHTML = value;
	}
	
	function loop() 
	{
		dateDiff = new Date(this.then - new Date());
		secondsDiff = Math.floor(dateDiff.valueOf() / 1000);
		seconds     = Math.floor(secondsDiff / 1) % 60;
		minutes     = Math.floor(secondsDiff / 60) % 60;
		hours       = Math.floor(secondsDiff / 3600) % 24;
		days        = Math.floor(secondsDiff / 86400) % 86400;
		setElement("countdown", "Nog " + days + " dagen, " + hours + " uur, " + minutes + " minuten en " + seconds + " seconden...")
	}
	
	function start()
	{
		this.timer = setInterval(loop, 1000);
		loop();
	}
	
	function stop()
	{
		if (this.timer) clearInterval(this.timer);
	}
}


  

