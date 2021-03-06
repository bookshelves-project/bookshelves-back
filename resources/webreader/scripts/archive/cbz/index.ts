// import readZipFileJsZip from './jszip'
// import readZipFileZipJs from './zip.js'
// import readRarFile from './rar.js'
// interface AlpineRefs {
//   fileName?: HTMLElement
//   url?: HTMLElement
//   filePath?: HTMLElement
//   fileFormat?: HTMLElement
//   current?: HTMLImageElement
//   isLoading?: HTMLElement
//   isNotReady?: HTMLElement
// }

// type Format = 'cbr' | 'cbz'
// let refsAlpine: AlpineRefs
// const allowedExtensions = ['jpg', 'jpeg']
// let currentIndex = 0
// let images: Map<string, Blob> = new Map()
// let isLoading = false
// let fileName: string
// let url: string
// let path: string
// let format: Format

// /**
//  * Packages: `jszip`, `jszip-utils`, @zip.js/zip.js, rarjs
//  */
// const setup = async (refs: AlpineRefs) => {
//   refsAlpine = refs
//   fileName = refsAlpine.fileName?.textContent as unknown as string
//   url = refsAlpine.url?.textContent as unknown as string
//   path = refsAlpine.filePath?.textContent as unknown as string
//   format = refsAlpine.fileFormat?.textContent as unknown as Format

//   if (format === 'cbz') {
//     await readZipFileZipJs(path)
//     // await readZipFileJsZip(path)
//   } else if (format === 'cbr') {
//     await readRarFile(path)
//   } else {
//     console.error('error with format')
//   }
// }

// const setImagesList = (map: Map<string, Blob>) => {
//   images = map
//   isLoading = true

//   refsAlpine.isLoading?.classList.remove('hidden')
//   refsAlpine.isNotReady?.classList.add('hidden')

//   setImage()
// }

// const setImage = () => {
//   const page = [...images][currentIndex]
//   const image = page[1] as unknown as string
//   window.scrollTo(0, 0)
//   refsAlpine.current?.setAttribute('src', image)
// }

// const previousPage = () => {
//   if (currentIndex > 0) {
//     currentIndex = currentIndex - 1
//   }
//   setImage()
// }

// const nextPage = () => {
//   if (currentIndex < images.size - 1) {
//     currentIndex = currentIndex + 1
//   }
//   setImage()
// }

// export { setup, nextPage, previousPage, allowedExtensions, setImagesList }
