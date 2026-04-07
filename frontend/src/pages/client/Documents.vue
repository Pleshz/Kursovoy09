<template>
  <body class="min-h-screen bg-gray-50 text-gray-800">
    <header class="border-b border-solid border-gray-200 bg-white">
      <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-4 max-w-6xl mx-auto">
        <router-link to="/" class="text-2xl font-bold text-gray-900 no-underline">
          CarShare
        </router-link>
        <nav class="flex flex-wrap items-center gap-4 text-sm font-semibold" aria-label="Навигация клиента">
          <router-link to="/app" class="text-gray-700 hover:text-blue-600 transition duration-200 ease-in-out">
            Выбор авто
          </router-link>
          <router-link to="/account" class="text-gray-700 hover:text-blue-600 transition duration-200 ease-in-out">
            Личный кабинет
          </router-link>
          <router-link to="/login" class="text-red-600 hover:text-red-700 transition duration-200 ease-in-out">
            Выйти
          </router-link>
        </nav>
      </div>
    </header>

    <main class="px-6 py-8 lg:py-10">
      <section class="max-w-6xl mx-auto mb-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
          <div>
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 pb-2">Загрузка документов</h1>
            <p class="text-gray-700 text-lg leading-relaxed">
              Добавьте фото документов для подтверждения аккаунта.
            </p>
          </div>
          <router-link
            to="/account"
            class="inline-block px-5 py-2 bg-white text-blue-600 font-medium text-xs leading-snug uppercase rounded border border-solid border-gray-300 shadow-sm hover:bg-gray-50 transition duration-150 ease-in-out"
          >
            Назад
          </router-link>
        </div>
      </section>

      <section class="max-w-6xl mx-auto grid lg:grid-cols-3 gap-6">
        <section class="lg:col-span-2 bg-white border border-solid border-gray-200 rounded-2xl shadow-sm p-5">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Файлы</h2>

          <div class="grid md:grid-cols-2 gap-4">
            <div class="border border-dashed border-gray-300 rounded-2xl p-4 bg-gray-50">
              <p class="font-semibold text-gray-900">Паспорт</p>
              <p class="text-xs text-gray-600 pt-1">Фото разворота с данными. Форматы: JPG/PNG/WebP.</p>
              <input
                type="file"
                accept="image/*"
                class="mt-3 block w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                @change="onPick($event, 'passport')"
              />
              <div v-if="previews.passport" class="mt-3">
                <img :src="previews.passport" alt="Предпросмотр паспорта" class="w-full h-40 object-cover rounded-xl border border-gray-200" />
              </div>
            </div>

            <div class="border border-dashed border-gray-300 rounded-2xl p-4 bg-gray-50">
              <p class="font-semibold text-gray-900">Водительское удостоверение</p>
              <p class="text-xs text-gray-600 pt-1">Фото лицевой стороны. Форматы: JPG/PNG/WebP.</p>
              <input
                type="file"
                accept="image/*"
                class="mt-3 block w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                @change="onPick($event, 'license')"
              />
              <div v-if="previews.license" class="mt-3">
                <img :src="previews.license" alt="Предпросмотр прав" class="w-full h-40 object-cover rounded-xl border border-gray-200" />
              </div>
            </div>

            <div class="border border-dashed border-gray-300 rounded-2xl p-4 bg-gray-50 md:col-span-2">
              <p class="font-semibold text-gray-900">Селфи с документом</p>
              <p class="text-xs text-gray-600 pt-1">Селфи, где видно лицо и документ в руках.</p>
              <input
                type="file"
                accept="image/*"
                class="mt-3 block w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                @change="onPick($event, 'selfie')"
              />
              <div v-if="previews.selfie" class="mt-3">
                <img :src="previews.selfie" alt="Предпросмотр селфи" class="w-full h-56 object-cover rounded-xl border border-gray-200" />
              </div>
            </div>
          </div>
        </section>

        <aside class="bg-white border border-solid border-gray-200 rounded-2xl shadow-sm p-5">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Проверка</h2>
          <ul class="list-disc list-inside text-sm text-gray-700 space-y-2">
            <li>Фото должно быть чётким, без бликов.</li>
            <li>Данные на документе должны читаться.</li>
            <li>Загрузите актуальные документы, чтобы избежать блокировки.</li>
          </ul>

          <button
            type="button"
            class="mt-5 w-full inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
          >
            Отправить на проверку
          </button>

        </aside>
      </section>
    </main>
  </body>
</template>

<script setup>
import { onBeforeUnmount, reactive } from 'vue'

const previews = reactive({
  passport: '',
  license: '',
  selfie: '',
})

const objectUrls = reactive({
  passport: '',
  license: '',
  selfie: '',
})

function setPreview(key, file) {
  if (objectUrls[key]) URL.revokeObjectURL(objectUrls[key])
  objectUrls[key] = file ? URL.createObjectURL(file) : ''
  previews[key] = objectUrls[key]
}

function onPick(event, key) {
  const file = event?.target?.files?.[0]
  if (!file) return
  setPreview(key, file)
}

onBeforeUnmount(() => {
  for (const key of Object.keys(objectUrls)) {
    if (objectUrls[key]) URL.revokeObjectURL(objectUrls[key])
  }
})
</script>

