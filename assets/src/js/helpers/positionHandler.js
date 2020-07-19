const positionHandler = e => {
  const coords = {};
  if ((e.clientX) && (e.clientY)) {
    coords.posX = e.clientX;
    coords.posY = e.clientY;
  } else if (e.targetTouches && e.targetTouches.length) {
    coords.posX = e.targetTouches[0].clientX;
    coords.posY = e.targetTouches[0].clientY;
  } else if (e.changedTouches && e.changedTouches.length) {
    coords.posX = e.changedTouches[0].clientX;
    coords.posY = e.changedTouches[0].clientY;
  }
  return coords;
};

export default positionHandler;
