<template>
  <a
    href="https://creativecommons.org/"
    target="_blank"
    rel="noopener noreferrer"
    class="flex items-center space-x-1 hover:text-black"
  >
    <by class="w-5 h-5" />
    <cc class="w-5 h-5" />
    <nc class="w-5 h-5" />
    <span class="ml-2">{{ year }}</span>
  </a>
</template>

<script setup lang="ts">
import By from '@admin/svg/by.svg'
import Cc from '@admin/svg/cc.svg'
import Nc from '@admin/svg/nc.svg'
import { computed } from 'vue'

const year = computed(() => {
  let begin = 2020
  let current = new Date().getFullYear()
  return begin !== current ? `${begin} - ${current}` : current
})
</script>
