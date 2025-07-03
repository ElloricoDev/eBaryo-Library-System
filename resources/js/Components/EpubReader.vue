<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import ePub from 'epubjs'

const props = defineProps({
  url: { type: String, required: true },
  startPercent: { type: Number, default: 0 }
})

const viewer = ref(null)
let book = null
let rendition = null
const emit = defineEmits(['update:percent'])
const currentPage = ref(1)
const totalPages = ref(1)

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

function handleRelocated(location) {
  if (book && book.locations && location && location.start && location.start.cfi) {
    const percent = book.locations.percentageFromCfi(location.start.cfi)
    emit('update:percent', percent)
    // Update page info
    if (book.locations.length() > 0) {
      currentPage.value = book.locations.locationFromCfi(location.start.cfi)
      totalPages.value = book.locations.length()
    }
  }
}

onMounted(() => {
  book = ePub(props.url)
  rendition = book.renderTo(viewer.value, {
    width: '100%',
    height: 600
  })
  // Generate locations for accurate percent calculation
  book.ready.then(() => book.locations.generate(1000)).then(() => {
    rendition.on('relocated', handleRelocated)
    if (props.startPercent > 0 && props.startPercent < 1) {
      // Go to the saved percent
      const cfi = book.locations.cfiFromPercentage(props.startPercent)
      rendition.display(cfi)
    } else {
      displayFirstContent();
    }
  })
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
    <div class="d-flex justify-content-between mb-2 align-items-center">
      <button class="btn btn-outline-secondary btn-sm" @click="prevPage">
        &laquo; Previous
      </button>
      <span class="text-muted small">Page {{ currentPage }} / {{ totalPages }}</span>
      <button class="btn btn-outline-secondary btn-sm" @click="nextPage">
        Next &raquo;
      </button>
    </div>
    <div ref="viewer" style="border:1px solid #ccc; border-radius:8px; overflow:hidden;"></div>
  </div>
</template>
