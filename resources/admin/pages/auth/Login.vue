<template>
  <auth-layout>
    <div v-if="status" class="mb-4 font-medium text-base text-green-600">
      {{ status }}
    </div>

    <validation-errors class="mb-4" />

    <base-form
      v-slot="{ processing }"
      method="post"
      :url="route('login')"
      :transform="
        (data) => ({
          ...data,
          remember: data.remember ? 'on' : '',
        })
      "
    >
      <div>
        <text-input
          source="email"
          type="email"
          required
          autofocus
          :model-value="isDev ? 'superadmin@example.com' : ''"
        />
      </div>

      <div class="mt-4">
        <text-input
          source="password"
          type="password"
          required
          autocomplete="current-password"
          :model-value="isDev ? 'password' : ''"
        />
        <div class="flex mt-2">
          <inertia-link
            :href="route('admin.password.request')"
            class="underline text-xs text-gray-600 hover:text-gray-900 ml-auto dark:text-white"
          >
            {{ $t('Forgot your password?') }}
          </inertia-link>
        </div>
      </div>

      <div class="mt-4">
        <checkbox-input source="remember" name="remember" :model-value="true" />
      </div>

      <div class="flex items-center justify-between mt-6">
        <a href="/" class="text-base italic underline dark:text-white"
          >Back to website</a
        >

        <div class="flex items-center justify-end">
          <!-- <inertia-link
            v-if="canRegister"
            :href="route('admin.register')"
            class="underline text-base text-gray-600 hover:text-gray-900 ml-auto"
          >
            {{ $t('Not registered yet?') }}
          </inertia-link> -->

          <base-button type="submit" class="ml-4" :loading="processing">
            {{ $t('Log in') }}
          </base-button>
        </div>
      </div>
    </base-form>
  </auth-layout>
</template>

<script lang="ts" setup>
import { useTitle } from '@admin/features/helpers'
import { usePage } from '@inertiajs/inertia-vue3'
import { computed } from 'vue'

defineProps({
  canRegister: Boolean,
  status: String,
})

useTitle('Login')

const isDev = computed((): boolean => usePage().props.value.env === 'local')
</script>
