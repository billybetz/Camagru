//self invoking function qui s'execute dès qu'elle est crée donc on ne peut pas l'appeler
(function()
{
	 var video = document.getElementById("video");
	 var url = window.URL || window.webkitURL;

	 navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
	 	navigator.mozGetUserMedia || navigator.msGetUserMedia;
	 
	 navigator.getMedia(
	 	{
	 		video:true, audio:false
	 	}, 
	 	function(stream) 
	 	{
	 		video.src = url.createObjectURL(stream); 
	 		video.play;
	 	},
	 	function(error)
	 	{

	 	});
}
)();