import { Book, Rendition } from 'epubjs'
import { functions } from 'lodash'
import {
  selectListener,
  clickListener,
  swipListener,
  wheelListener,
  keyListener,
} from './listener'
import { dark, tan, defaultStyle } from './theme'
import Alpine from 'alpinejs'

interface AlpineRefs {
  epubPath: HTMLElement
  loadingMessage: HTMLElement
  readButton: HTMLElement
  presentation: HTMLElement
  reader: HTMLElement
}

let book: Book = {}
let rendition: Rendition = {}
let toc = []
let progress
let isReady = false
let refsAlpine: AlpineRefs = null

const contentStyle = (rendition) => {
  let contents = rendition.getContents()
  return contents.forEach((content) => {
    content.addStylesheetRules({})
  })
}

const initBook = async (refs) => {
  // let navigationOptions = document.getElementById('navigation-options')
  // let disableNavTutoBtn = document.getElementById('disable-nav-tuto')
  // disableNavTutoBtn.addEventListener('click', disableNavTuto)

  // // first webreader usage
  // if (localStorage.getItem('nav-tuto') === null) {
  //   //
  //   // tuto is disable
  // } else if (localStorage.getItem('nav-tuto') === 'false') {
  //   hideNavTuto()
  // }
  hideNavTuto()

  console.log('initBook')
  refsAlpine = refs

  setupBook()
  book.ready.then((e) => {
    loadBook()
    setReady()
  })

  let prevPageBtn = document.getElementById('prevPage')
  prevPageBtn.addEventListener('click', prevPage)
  let nextPageBtn = document.getElementById('nextPage')
  nextPageBtn.addEventListener('click', nextPage)

  let prevSidePageBtn = document.getElementById('leftBtn')
  prevSidePageBtn.addEventListener('click', prevPage)
  let centerPageBtn = document.getElementById('centerBtn')
  centerPageBtn.addEventListener('click', toggleNavigationOptions)
  let nextSidePageBtn = document.getElementById('rightBtn')
  nextSidePageBtn.addEventListener('click', nextPage)

  let firstPageBtn = document.getElementById('firstPage')
  firstPageBtn.addEventListener('click', firstPage)
  let lastPageBtn = document.getElementById('lastPage')
  lastPageBtn.addEventListener('click', lastPage)
}

/**
 * Get Book from path
 * Init Book and Rendition
 */
const setupBook = () => {
  let epubPath = refsAlpine.epubPath
  const path = epubPath.textContent

  let info = {
    toc: {},
    lastOpen: null,
    path,
    highlights: [],
  }
  //   let toc = info.toc;
  info.lastOpen = new Date().getTime()
  //   let buble = $refs.bubleMenu;
  book = new Book(info.path)
  rendition = new Rendition(book, {
    width: '100%',
    height: '100%',
    // ignoreClass?: string,
    manager: 'default',
    // view?: string | Function | object,
    // flow?: string,
    // layout?: string,
    spread: 'always',
    // minSpreadWidth?: number,
    // stylesheet: '/assets/css/blade/webreader.css',
    // resizeOnOrientationChange?: boolean,
    // script?: string,
    infinite: true,
    // overflow?: string,
    // snap?: boolean | object,
    // defaultDirection?: string,
  })
}

/**
 * Load book
 */
const loadBook = async () => {
  // let flipPage = () => {
  //   if (direction === "next") nextPage();
  //   else if (direction === "prev") prevPage();
  // };
  // let toggleBuble = () => {
  //   if (event === "cleared") {
  //     // hide buble
  //     buble.hide();
  //     return;
  //   }
  //   buble.setProps(react, text, cfiRange);
  //   isBubleVisible = true;
  // };
  // rendition.on("rendered", (e, iframe) => {
  //   iframe.iframe.contentWindow.focus();
  //   clickListener(iframe.document, rendition, flipPage);
  //   selectListener(iframe.document, rendition, toggleBuble);
  //   swipListener(iframe.document, flipPage);
  //   wheelListener(iframe.document, flipPage);
  //   keyListener(iframe.document, flipPage);
  // });
  // rendition.on("relocated", (location) => {
  //   info.lastCfi = location.start.cfi;
  //   progress = book.locations.percentageFromCfi(location.start.cfi);
  //   sliderValue = Math.floor(progress * 10000) / 100;
  // });
  // let applyStyle = contentStyle(rendition);
  // await rendition.hooks.content.register(applyStyle || {});

  let meta = book.package.metadata
  let title = meta.title
  // let titleTag = document.getElementsByTagName("title");
  // titleTag.item(0).textContent = `${title} ${titleTag.item(0).textContent}`;
  book.locations.load(1)
}

/**
 * Attach iframe to HTML
 * Display iframe
 */
const displayBook = async () => {
  rendition.attachTo(refsAlpine.reader)
  let cfi = book.locations.cfiFromPercentage(
    10 / book.locations.spine.items.length
  )
  let params =
    URLSearchParams &&
    new URLSearchParams(document.location.search.substring(1))
  let url = params && params.get('url') && decodeURIComponent(params.get('url'))
  let currentSectionIndex =
    params && params.get('loc') ? params.get('loc') : undefined
  rendition.display(currentSectionIndex)
  // rendition.themes.registerRules("dark", dark);
  // rendition.themes.registerRules("tan", tan);
  rendition.themes.registerRules('default', defaultStyle)
  rendition.ready = true
  // let theme = theme
  // rendition.themes.select(theme)
  rendition.start()
}

/**
 * Set TOC
 */
const setOptions = async () => {
  // info.highlights.forEach((cfiRange) => {
  //   rendition.annotations.highlight(cfiRange);
  // });
  toc = book.navigation.toc
  // let _flattenedToc = (function flatten(items) {
  //   return [].concat(
  //     ...items.map((item) => [item].concat(...flatten(item.children)))
  //   );
  // })(toc);

  // _flattenedToc.sort((a, b) => {
  //   return a.percentage - b.percentage;
  // });
  setToc()
}

/**
 * Set isReady when Book is loaded
 */
const setReady = async () => {
  isReady = true

  refsAlpine.loadingMessage.remove()

  refsAlpine.readButton.classList.remove('hidden')
  refsAlpine.readButton.addEventListener('click', read)
}

function setToc() {
  let tocBlock = document.getElementById('toc')
  toc.forEach((el, key) => {
    tocBlock.innerHTML += `<li id="${el.id} chapter-${key}" data-chapter="${el.href}" class="toc-item cursor-pointer text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white group flex links-center px-2 py-2 text-sm font-medium rounded-md my-1 justify-between">${el.label}</li>`
  })

  let tocItem = document.getElementsByClassName('toc-item')
  for (let index in tocItem) {
    if (index <= tocItem.length) {
      tocItem[index].addEventListener('click', setChapter)
    }
  }
}

const setChapter = () => {
  let chapter = this.dataset.chapter
  rendition.display(chapter)
}

const read = () => {
  refsAlpine.presentation.classList.add('hidden')
  refsAlpine.reader.classList.remove('hidden')

  let bookNav = document.getElementById('book-nav')
  bookNav.classList.remove('hidden')

  book.ready
    .then(() => {
      displayBook()
    })
    .then(() => {
      setOptions()
    })
}

const prevPage = () => {
  try {
    rendition.prev()
    console.clear()
  } catch (error) {}
}
const nextPage = () => {
  try {
    rendition.next()
    console.clear()
  } catch (error) {}
}

const firstPage = () => {
  try {
    rendition.display(0)
    console.clear()
  } catch (error) {}
}
const lastPage = () => {
  try {
    rendition.display(book.spine.length - 1)
    console.clear()
  } catch (error) {}
}

const hideNavTuto = () => {
  let tutoEl = document.getElementsByClassName('book-nav-tuto')
  while (tutoEl.length > 0) {
    tutoEl[0].parentNode.removeChild(tutoEl[0])
  }

  let navBook = document.getElementsByClassName('nav-tuto')
  Object.keys(navBook).forEach(function (key) {
    navBook[key].classList.add('side-button')
    navBook[key].classList.remove('nav-tuto-color')
  })
}

const disableNavTuto = () => {
  localStorage.setItem('nav-tuto', false)
  hideNavTuto()
}

const toggleNavigationOptions = () => {
  navigationOptions.classList.toggle('hidden')
}

export {
  contentStyle,
  initBook,
  setupBook,
  path,
  loadBook,
  displayBook,
  setOptions,
  setReady,
  setChapter,
  read,
  prevPage,
  nextPage,
  firstPage,
  lastPage,
  hideNavTuto,
  disableNavTuto,
  toggleNavigationOptions,
}
