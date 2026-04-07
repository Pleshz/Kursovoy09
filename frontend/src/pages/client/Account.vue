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
          <router-link to="/account" class="text-blue-600 hover:text-blue-700 transition duration-200 ease-in-out">
            Личный кабинет
          </router-link>
          <router-link to="/login" class="text-red-600 hover:text-red-700 transition duration-200 ease-in-out">
            Выйти
          </router-link>
        </nav>
      </div>
    </header>

    <main class="px-6 py-8 lg:py-10">
      <!-- Заголовок -->
      <section class="max-w-6xl mx-auto mb-10">
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 pb-3">Личный кабинет</h1>
        <p class="text-gray-700 text-lg leading-relaxed pb-4">
          Здесь собрана основная информация о вашем профиле, способах оплаты и истории поездок.
        </p>
      </section>

      <!-- Профиль + статистика -->
      <section class="max-w-6xl mx-auto mb-10 grid lg:grid-cols-3 gap-6">
        <section class="bg-white border border-solid border-gray-200 rounded-2xl p-5 shadow-sm lg:col-span-2">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Профиль</h2>
          <dl class="grid sm:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
              <dt class="font-semibold text-gray-900 mb-1">ФИО</dt>
              <dd>{{ profile.fullName }}</dd>
            </div>
            <div>
              <dt class="font-semibold text-gray-900 mb-1">Email</dt>
              <dd>{{ profile.email }}</dd>
            </div>
            <div>
              <dt class="font-semibold text-gray-900 mb-1">Телефон</dt>
              <dd>{{ profile.phone }}</dd>
            </div>
            <div>
              <dt class="font-semibold text-gray-900 mb-1">Статус аккаунта</dt>
              <dd>{{ profile.status }}</dd>
            </div>
            <div>
              <dt class="font-semibold text-gray-900 mb-1">Права на управление</dt>
              <dd>{{ profile.rights }}</dd>
            </div>
            <div>
              <dt class="font-semibold text-gray-900 mb-1">Город</dt>
              <dd>{{ profile.city }}</dd>
            </div>
          </dl>
        </section>

        <section class="bg-white border border-solid border-gray-200 rounded-2xl p-5 shadow-sm">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Статистика поездок</h2>
          <dl class="space-y-2 text-sm text-gray-700">
            <div class="flex justify-between">
              <dt class="font-semibold">Всего поездок</dt>
              <dd>{{ stats.totalTrips }}</dd>
            </div>
            <div class="flex justify-between">
              <dt class="font-semibold">Общий пробег</dt>
              <dd>{{ stats.totalDistance }} км</dd>
            </div>
            <div class="flex justify-between">
              <dt class="font-semibold">Время за рулём</dt>
              <dd>{{ stats.totalTime }}</dd>
            </div>
            <div class="flex justify-between">
              <dt class="font-semibold">Средняя стоимость поездки</dt>
              <dd>{{ stats.avgTripCost }} ₽</dd>
            </div>
          </dl>
        </section>
      </section>

      <!-- Платёжные данные + Документы -->
      <section class="max-w-6xl mx-auto mb-10 grid md:grid-cols-2 gap-6">
        <section class="bg-white border border-solid border-gray-200 rounded-2xl p-5 shadow-sm">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Документы</h2>
          <ul class="space-y-3 text-sm text-gray-700">
            <li class="flex justify-between">
              <span>Паспорт</span>
              <span class="text-gray-500">Подтверждён</span>
            </li>
            <li class="flex justify-between">
              <span>Водительское удостоверение</span>
              <span class="text-gray-500">Подтверждено</span>
            </li>
            <li class="flex justify-between">
              <span>Договор оферты</span>
              <span class="text-gray-500">Принят</span>
            </li>
          </ul>

          <router-link
            to="/account/documents"
            class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white font-medium text-xs leading-snug uppercase rounded shadow-sm hover:bg-blue-700 focus:bg-blue-700 focus:outline-none transition duration-150 ease-in-out"
          >
            Загрузить документы
          </router-link>
        </section>
      </section>
    </main>
  </body>
</template>

<script setup>
const profile = {
  fullName: 'Иван Иванов',
  email: 'ivan.ivanov@example.com',
  phone: '+7 (900) 000-00-00',
  status: 'Активен',
  rights: 'Разрешено управление автомобилями класса Эконом и Комфорт',
  city: 'Пермь',
}

const stats = {
  totalTrips: 42,
  totalDistance: 860,
  totalTime: '37 ч',
  avgTripCost: 420,
}

const paymentMethods = [
  { id: 1, mask: 'VISA •••• 1234', label: 'Основная карта' },
  { id: 2, mask: 'Mastercard •••• 5678', label: 'Резервная' },
]
</script>