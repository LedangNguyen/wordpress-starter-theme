// Play/pause HTML5 <video> the right way, useful for autoplay with IntersectionObserver

const playVideo = async video => {
  try {
    if (video.paused) {
      await video.play();

      video.classList.remove('-paused');
      video.classList.add('-playing');
    }
  } catch (e) {
    console.error(e);
  }
};

const pauseVideo = async video => {
  try {
    if (!video.paused) {
      await video.pause();

      video.classList.remove('-playing');
      video.classList.add('-paused');
    }
  } catch (e) {
    console.error(e);
  }
};

export { playVideo, pauseVideo };
