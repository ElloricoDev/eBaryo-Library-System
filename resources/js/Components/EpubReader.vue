<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import ePub from 'epubjs'

const props = defineProps({
  url: { type: String, required: true }
})

const viewer = ref(null)
let book = null
let rendition = null

function displayFirstContent() {
  book.ready.then(() => {
    // Find the first spine item that is NOT a cover and NOT marked as linear="no"
    const firstSpine = book.spine.spineItems.find(
      item =>
        !item.properties.includes('cover-image') &&
        !item.idref.toLowerCase().includes('cover') &&
        item.linear !== 'no'
    );
    if (firstSpine) {
      rendition.display(firstSpine.href);
    } else {
      // fallback: show the first readable item
      const fallback = book.spine.spineItems.find(item => item.linear !== 'no');
      if (fallback) {
        rendition.display(fallback.href);
      } else {
        rendition.display();
      }
    }
  });
}

function nextPage() {
  if (rendition) rendition.next();
}
function prevPage() {
  if (rendition) rendition.prev();
}

onMounted(() => {
  book = ePub(props.url)
  rendition = book.renderTo(viewer.value, {
    width: '100%',
    height: 600
  })
  displayFirstContent();
})

onBeforeUnmount(() => {
  if (rendition) rendition.destroy()
  if (book) book.destroy()
})

watch(() => props.url, (newUrl) => {
  if (book && newUrl) {
    book.destroy()
    book = ePub(newUrl)
    rendition = book.renderTo(viewer.value, {
      width: '100%',
      height: 600
    })
    displayFirstContent();
  }
})
</script>

<template>
  <div>
    <div class="d-flex justify-content-between mb-2">
      <button class="btn btn-outline-secondary btn-sm" @click="prevPage">
        &laquo; Previous
      </button>
      <button class="btn btn-outline-secondary btn-sm" @click="nextPage">
        Next &raquo;
      </button>
    </div>
    <div ref="viewer" style="border:1px solid #ccc; border-radius:8px; overflow:hidden;"></div>
  </div>
</template>
