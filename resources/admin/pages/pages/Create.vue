<template>
  <create-context v-slot="{ title }" resource="pages">
    <app-layout title="Create new Page">
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
          </template>
        </page-header>
      </template>

      <page-form :method="method" :url="url" />
    </app-layout>
  </create-context>
</template>

<script lang="ts" setup>
import route from 'ziggy-js'

const method = 'post'
const url = route('admin.pages.store')
</script>
