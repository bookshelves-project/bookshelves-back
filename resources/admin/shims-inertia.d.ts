import { Profile, EnumTypes } from '@admin/types'
import { Page, PageProps, ErrorBag, Errors } from '@inertiajs/inertia'

declare module '@inertiajs/inertia' {
  interface PageProps {
    appName: string
    env: string
    locale: string
    query: string
    auth: Profile
    flash: { [key: string]: string }
    errors: Errors & ErrorBag
    enums: EnumTypes
    repositoryUrl: string
    documentationUrl: string
  }
}

declare module '@vue/runtime-core' {
  export interface ComponentCustomProperties {
    $page: Page<PageProps>
  }
}
