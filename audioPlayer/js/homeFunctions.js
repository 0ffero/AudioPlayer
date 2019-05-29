function saveFileAndPos() {
	offset = 5; // this will "rewind" 5 seconds
	folderName = $("#vars").data("foldername");
	fileName   = $("#vars").data("currentlyplaying");
	
	if (folderName && fileName) {
		currentTime = Math.floor(document.getElementById('audioPlayer').currentTime);
		if (currentTime > 5) {
			currentTime -=5
		} else if (currentTime >= 0 && currentTime <= 5) {
			currentTime = 0;
		} else {
			currentTime = Math.floor(document.getElementById('audioPlayer').duration);
		}
		console.log("Saving Current Position Data");
		$.get( "source/savePosition.php?currenttime=" + currentTime.toString() + "&filename=" + fileName + "&foldername=" + folderName, function( response ) {
			console.log(response);
		})
		return true;
	} else {
		console.log("No Tracks Found");
		return false;
	}
}

function startTimer() {
	$("#loading").html("");
	isPlaying = $("#vars").data("playing");
	if (isPlaying == "no") {
		console.log("Starting new timer")
		$("#vars").data("playing", "yes");
		var playingInterval = setInterval( function() {
			audioPlayer = document.getElementById('audioPlayer');
			if (audioPlayer.paused === true) {
				$("#vars").data("playing", "no");
				console.log("Clearing playingInterval");
				clearInterval(playingInterval);
			}
			saveFileAndPos();
		}, 5000);
	} else {
		console.log("Timer is already running");
	}
}
var playingInterval = null;

function playAudioFile(fileName, filePosition = 0) {
	if (fileName.includes(".mp3") > 0) {
		fileType = "audio/mpeg";
	} else if (fileName.includes(".m4a")>0 || fileName.includes(".m4b")>0) {
		fileType = "audio/mp4";
	}

	$("audio").prop( "src", "http://192.168.0.40/AudioBooksFolder/" + fileName ).prop( "type", fileType);
	var audioPlayer = document.getElementById('audioPlayer'); // for some weird reason, calling this id using jquery fails on .play() <-- WTF? etc
	audioPlayer.currentTime = filePosition;
	audioPlayer.play();
	audioPlayer.onloadstart = function() {
		$("#loading").html("Audio File is loading");
	};
	audioPlayer.oncanplay = function() {
		console.log("oncanplay is attempting to start a timer");
		startTimer();
	};
	audioPlayer.onended = function() {
		saveFileAndPos();
		playingInterval = null;
	};
	
	// Tidy Up The UI
	found = false;
	$(".file").each( function() {
		if ($(this).hasClass("playing") && found==false) {
			$(this).removeClass("playing").next().removeClass("white").addClass("playing");
			found = true;
		}
	});
}