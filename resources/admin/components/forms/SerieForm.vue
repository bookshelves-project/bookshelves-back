<template>
  <base-form ref="form" v-slot="{ processing }" :method="method" :url="url">
    <div class="form-grid">
      <card-content>
        <text-input source="title" type="text" />
        <text-input source="link" type="text" />
        <reference-input
          source="language_slug"
          label-key="language"
          resource="languages"
          allow-empty
          i18n
        />
        <rich-select-input
          source="authors.fetch"
          resource="authors.fetch"
          label-key="authors"
          multiple
          taggable
          searchable
          :min-chars="0"
          option-value="name"
          :getter="(serie) => serie.authors.map((t) => t.name)"
        />
        <editor-input source="description" :height="800" full />
      </card-content>
      <card-side>
        <file-input
          source="cover"
          file-source="cover_file"
          delete-source="cover_delete"
          preview
          preview-attr="url"
          full
        />
        <text-input source="slug" type="text" full />
        <text-input source="slug_sort" type="text" full />
        <rich-select-input
          source="tags.fetch"
          resource="tags.fetch"
          label-key="tags"
          multiple
          taggable
          searchable
          :min-chars="0"
          option-value="name"
          :getter="(serie) => serie.tags.map((t) => t.name)"
          full
        />
        <form-button :processing="processing" :submit="submit" />
      </card-side>
    </div>
  </base-form>
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue'

defineProps({
  method: {
    type: String,
    required: true,
  },
  url: {
    type: String,
    required: true,
  },
})

const form: Ref<HTMLElement | null | any> = ref(null)

const submit = () => {
  if (form.value) {
    form.value.submit()
  }
}
</script>
