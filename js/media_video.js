//self invoking function qui s'execute dès qu'elle est crée donc on ne peut pas l'appeler
(function()
{
	 var video = document.getElementById("video");
	 var url = window.URL || window.webkitURL;

	 navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
	 navigator.oGetUserMedia || navigator.msGetUserMedia || navigator.mozGetUserMedia;
	 
	 if( !! navigator.getUserMedia)
	 {
	 	// Attention, 2 navigateurs n peuvent pas utiliser la cam en même temps !
	 	// ou video_error sera appellé a la place de handle_video !
	 	navigator.getUserMedia({video:true}, handle_video, video_error);
	 }
	 else
	 {
	 	alert("vidéo : getMedia not supported on this browser");
	 }

 	function handle_video(stream) 
 	{
 		if (navigator.mozGetUserMedia)
 		{
        	video.srcObject = stream;
 		}
        else
        {
 			video.src = url.createObjectURL(stream);
        }
 		video.play(); 
 	}

	function video_error(error)
	{
 		alert("vidéo : " + error);
 	}
}
)()