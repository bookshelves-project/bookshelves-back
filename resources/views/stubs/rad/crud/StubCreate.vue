<script lang="ts" setup>
import route from 'ziggy-js'

const method = 'post'
const url = route('admin.stubsKebab.store')
</script>

<template>
  <create-context v-slot="{ title }" resource="stubsKebab">
    <app-layout title="Create new stubPascal">
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
          </template>
        </page-header>
      </template>

      <stubKebab-form :method="method" :url="url" />
    </app-layout>
  </create-context>
</template>
