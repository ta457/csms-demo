<article aria-label="File Upload Modal" class="relative h-full flex flex-col bg-white dark:bg-gray-800"
  ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" ondragleave="dragLeaveHandler(event);"
  ondragenter="dragEnterHandler(event);">
  <!-- overlay -->
  <div id="overlay"
    class="w-full h-full absolute top-0 left-0 pointer-events-none z-50 flex flex-col items-center justify-center rounded-md">
    <i>
      <svg class="fill-current w-12 h-12 mb-3 text-blue-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        viewBox="0 0 24 24">
        <path
          d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z" />
      </svg>
    </i>
    <p class="text-lg text-blue-700">Drop files to upload</p>
  </div>

  <!-- scroll area -->
  <section class="h-full mt-2 w-full h-full flex flex-col">
    <header
      class="rounded-lg bg-gray-50 dark:bg-gray-900 border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center">
      <p class="dark:text-gray-200 mb-3 font-semibold text-sm text-gray-900 flex flex-wrap justify-center">
        <span>Drag and drop your</span>&nbsp;<span>files here or</span>
      </p>

      <input id="hidden-input" type="file" name='files[]' multiple class="hidden" required />

      <button id="button" type="button"
        class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
        Upload a file
      </button>
    </header>

    {{-- <h1 class="pt-2 pb-3 font-semibold sm:text-sm text-gray-900">
      To Upload
    </h1> --}}

    <ul id="gallery" class="my-3 flex flex-1 flex-wrap -m-1">
      <li id="empty" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
        {{-- <img class="mx-auto w-32"
          src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
          alt="no data" /> --}}
        {{-- <svg class="w-14 h-14 mx-auto mt-4 mb-2 text-gray-800 dark:text-white" aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
          <path
            d="M5 9V4.13a2.96 2.96 0 0 0-1.293.749L.879 7.707A2.96 2.96 0 0 0 .13 9H5Zm11.066-9H9.829a2.98 2.98 0 0 0-2.122.879L7 1.584A.987.987 0 0 0 6.766 2h4.3A3.972 3.972 0 0 1 15 6v10h1.066A1.97 1.97 0 0 0 18 14V2a1.97 1.97 0 0 0-1.934-2Z" />
          <path
            d="M11.066 4H7v5a2 2 0 0 1-2 2H0v7a1.969 1.969 0 0 0 1.933 2h9.133A1.97 1.97 0 0 0 13 18V6a1.97 1.97 0 0 0-1.934-2Z" />
        </svg> --}}
        <span class="text-sm font-semibold text-gray-500">No files selected</span>
      </li>
    </ul>
  </section>

  <!-- sticky footer -->
  <footer class="flex">
    <button id="submit" type="submit"
      class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
      Update
    </button>
  </footer>
</article>

<template id="file-template">
  <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
    <article tabindex="0"
      class="group w-full h-full rounded-lg focus:outline-none focus:shadow-outline elative bg-gray-100 cursor-pointer relative shadow-sm">
      <img alt="upload preview" class="img-preview hidden w-full h-full sticky object-cover rounded-lg bg-fixed" />

      <section class="flex flex-col rounded-lg text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
        <h1 class="flex-1 group-hover:text-blue-800"></h1>
        <div class="flex">
          <span class="p-1 text-blue-800">
            <i>
              <svg class="fill-current w-4 h-4 ml-auto pt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24">
                <path d="M15 2v5h5v15h-16v-20h11zm1-2h-14v24h20v-18l-6-6z" />
              </svg>
            </i>
          </span>
          <p class="p-1 size text-xs text-gray-700"></p>
          <button class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-lg text-gray-800">
            <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24"
              height="24" viewBox="0 0 24 24">
              <path class="pointer-events-none"
                d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
            </svg>
          </button>
        </div>
      </section>
    </article>
  </li>
</template>
<template id="image-template">
  <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
    <article tabindex="0"
      class="group hasImage w-full h-full rounded-lg focus:outline-none focus:shadow-outline bg-gray-100 cursor-pointer relative text-transparent hover:text-white shadow-sm">
      <img alt="upload preview" class="img-preview w-full h-full sticky object-cover rounded-lg bg-fixed" />

      <section class="flex flex-col rounded-lg text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
        <h1 class="flex-1"></h1>
        <div class="flex">
          <span class="p-1">
            <i>
              <svg class="fill-current w-4 h-4 ml-auto pt-" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24">
                <path
                  d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z" />
              </svg>
            </i>
          </span>

          <p class="p-1 size text-xs"></p>
          <button class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-lg">
            <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24"
              height="24" viewBox="0 0 24 24">
              <path class="pointer-events-none"
                d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
            </svg>
          </button>
        </div>
      </section>
    </article>
  </li>
</template>