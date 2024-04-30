import { createI18n } from 'vue-i18n'
import en from './en'
import ja from './ja'

const i18n = createI18n({
  locale: import.meta.env.VITE_DEFAULT_LOCALE, // set locale
  fallbackLocale: import.meta.env.VITE_FALLBACK_LOCALE, // set fallback locale
  legacy: false,
  globalInjection: true,
  messages: {
    en,
    ja
  }
})

export default i18n