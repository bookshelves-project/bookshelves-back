const events = () => ({
  $store: {
    webreader: {} as IWebreader,
  },
  init() {
    this.setEvents()
  },
  setEvents() {
    document.addEventListener('keydown', (event) => {
      const full = document.getElementById('fullScreen')
      if (event.key === 'ArrowUp') {
        event.preventDefault()
        full?.scrollBy({ top: -100, behavior: 'smooth' })
      }
      if (event.key === 'ArrowDown' || event.key === ' ') {
        event.preventDefault()
        full?.scrollBy({ top: 100, behavior: 'smooth' })
      }

      if (event.key === 'f') {
        this.$store.webreader.switchSize('sizeFull')
      }
      if (event.key === 'l') {
        this.$store.webreader.switchSize('sizeLarge')
      }
      if (event.key === 's') {
        this.$store.webreader.switchSize('sizeScreen')
      }
      if (event.key === 'e') {
        if (this.$store.webreader.isFullscreen) {
          this.$store.webreader.fullscreenExit()
        } else {
          this.$store.webreader.fullscreen()
        }
      }
      if (event.key === 'o') {
        this.$store.webreader.lockMenu()
      }
      if (event.key === 'i') {
        this.$store.webreader.informationEnabled =
          !this.$store.webreader.informationEnabled
      }
    })
  },
})

export default events

// gesture.on('panmove', () => {
//   if (gesture.animationFrame) {
//     return
//   }
//   gesture.animationFrame = window.requestAnimationFrame(() => {
//     if (!gesture.swipingDirection.startsWith('pre-')) {
//       target.style.backgroundColor = '#00AA00'
//     } else {
//       target.style.backgroundColor = bgColor
//     }
//     // const zDistance = -(Math.sqrt(Math.pow(gesture.touchMoveX, 2) + Math.pow(gesture.touchMoveY, 2)))+'px';
//     target.style.transition = 'background-color ease .3s'
//     target.style.transform =
//       'perspective(1000px) translate3d(' +
//       gesture.touchMoveX +
//       'px, ' +
//       gesture.touchMoveY +
//       'px, 0)'
//     window.requestAnimationFrame(() => {
//       target.style.transition = null
//     })
//     gesture.animationFrame = null
//   })
// })

// gesture.on('panend', () => {
//   window.cancelAnimationFrame(gesture.animationFrame)
//   gesture.animationFrame = null
//   target.style.transition = null
//   target.style.transform = null
//   bgColor = null
//   target.style.backgroundColor = bgColor
// })

// gesture.on('swiperight', () => {
//   target.style.transform = 'perspective(1000px) translate3d(2000px, 0, 0)'
//   setTimeout(() => (target.style.transform = null), 1000)
// })
// gesture.on('swipeleft', () => {
//   target.style.transform =
//     'perspective(1000px) translate3d(-2000px, 0, 0)'
//   setTimeout(() => (target.style.transform = null), 1000)
// })
// gesture.on('swipeup', () => {
//   target.style.transform =
//     'perspective(1000px) translate3d(0, -2000px, 0)'
//   setTimeout(() => (target.style.transform = null), 1000)
// })
// gesture.on('swipedown', () => {
//   target.style.transform = 'perspective(1000px) translate3d(0, 2000px, 0)'
//   setTimeout(() => (target.style.transform = null), 1000)
// })

// let tapTimeout
// gesture.on('tap', () => {
//   target.style.transform = 'perspective(1000px) translate3d(0, 0, 100px)'
//   tapTimeout = setTimeout(() => (target.style.transform = null), 300)
// })
// gesture.on('doubletap', () => {
//   target.style.transform = 'perspective(1000px) translate3d(0, 0, 400px)'
//   clearTimeout(tapTimeout)
//   setTimeout(() => (target.style.transform = null), 300)
// })
// gesture.on('longpress', () => {
//   bgColor = '#666688'
//   target.style.backgroundColor = bgColor
// })
