<template>
  <list-context v-slot="{ title }" resource="publishers">
    <app-layout :title="title">
      <template #header-actions>
        <create-button />
      </template>

      <data-table
        :source="publishers"
        :columns="columns"
        :sort="sort"
        :filter="filter"
        row-click="edit"
      >
        <template #actions>
          <export-button />
        </template>
        <template #bulk-actions="{ selected }">
          <delete-bulk-button :selected="selected" />
        </template>
        <template #field:row-action>
          <div class="flex gap-2 mx-auto">
            <edit-button hide-label />
            <delete-button hide-label />
          </div>
        </template>
      </data-table>
    </app-layout>
  </list-context>
</template>

<script lang="ts" setup>
import { Publisher, PaginatedData } from '@admin/types'
import { Column } from '@admin/types/data-table'
import { PropType } from 'vue'

defineProps({
  publishers: {
    type: Object as PropType<PaginatedData<Publisher>>,
    required: true,
  },
  sort: String,
  filter: Object,
})

const columns: (string | Column)[] = [
  'row-action',
  {
    field: 'id',
    width: 40,
    centered: true,
    numeric: true,
    sortable: true,
    main: true,
  },
  {
    field: 'name',
    sortable: true,
    searchable: true,
    main: true,
  },
  {
    field: 'books_count',
    centered: true,
    sortable: true,
  },
]
</script>
