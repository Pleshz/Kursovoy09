<template>
  <body class="min-h-screen bg-gray-50 text-gray-800">
    <header class="border-b border-solid border-gray-200 bg-white">
      <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-4 max-w-6xl mx-auto">
        <router-link to="/" class="text-2xl font-bold text-gray-900 no-underline">
          CarShare
        </router-link>
        <nav class="flex flex-wrap items-center gap-4 text-sm font-semibold" aria-label="Навигация клиента">
          <router-link to="/app" class="text-blue-600 hover:text-blue-700 transition duration-200 ease-in-out">
            Выбор авто
          </router-link>
          <router-link to="/account" class="text-gray-600 hover:text-blue-600 transition duration-200 ease-in-out">
            Личный кабинет
          </router-link>
          <router-link to="/login" class="text-red-600 hover:text-red-700 transition duration-200 ease-in-out">
            Выйти
          </router-link>
        </nav>
      </div>
    </header>

    <main class="px-6 py-8 lg:py-10">
      <section class="max-w-6xl mx-auto mb-10">
        <div class="flex flex-wrap items-start gap-8">
          <div class="flex-1 min-w-[260px]">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 pb-3">
              Выберите автомобиль для аренды
            </h1>
            <p class="text-gray-700 text-lg leading-relaxed pb-4">
              Отфильтруйте парк по классу, трансмиссии и ценовому диапазону. Тарифы отображаются за минуту, час и сутки.
            </p>
          </div>
          <aside class="w-full md:w-auto md:min-w-[260px] bg-white border border-solid border-gray-200 rounded-2xl shadow-sm p-4">
            <h2 class="text-sm font-semibold text-gray-900 mb-3 uppercase tracking-wide">Быстрый фильтр</h2>
            <div class="space-y-3 text-sm">
              <div>
                <label class="block mb-1 text-gray-700" for="segment">Класс авто</label>
                <select
                  id="segment"
                  class="block w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-blue-600"
                >
                  <option selected>Любой</option>
                  <option>Эконом</option>
                  <option>Комфорт</option>
                  <option>Бизнес</option>
                  <option>Электро</option>
                </select>
              </div>
              <div>
                <label class="block mb-1 text-gray-700" for="transmission">Трансмиссия</label>
                <select
                  id="transmission"
                  class="block w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-blue-600"
                >
                  <option selected>Любая</option>
                  <option>Автомат</option>
                  <option>Механика</option>
                </select>
              </div>
              <div>
                <label class="block mb-1 text-gray-700" for="price">Максимальная цена / мин</label>
                <input
                  id="price"
                  type="number"
                  min="5"
                  step="1"
                  class="block w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-blue-600"
                  placeholder="15"
                />
              </div>
            </div>
          </aside>
        </div>
      </section>

      <section class="max-w-6xl mx-auto mb-10" aria-label="Список доступных автомобилей">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-2xl font-bold text-gray-900">Доступные автомобили рядом</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <article
            v-for="car in cars"
            :key="car.name"
            class="bg-white border border-solid border-gray-200 rounded-2xl shadow-sm overflow-hidden flex flex-col"
          >
            <div class="h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
              Изображение автомобиля
            </div>
            <div class="p-4 flex-1 flex flex-col">
              <h3 class="text-lg font-bold text-gray-900 mb-1">{{ car.name }}</h3>
              <p class="text-sm text-gray-600 mb-2">{{ car.segment }} · {{ car.transmission }} · {{ car.fuel }}</p>
              <p class="text-sm text-gray-700 mb-3">{{ car.description }}</p>
              <dl class="grid grid-cols-3 gap-2 text-xs text-gray-700 mb-4">
                <div>
                  <dt class="font-semibold">Минутный</dt>
                  <dd>{{ car.rateMinute }} ₽/мин</dd>
                </div>
                <div>
                  <dt class="font-semibold">Часовой</dt>
                  <dd>{{ car.rateHour }} ₽/ч</dd>
                </div>
                <div>
                  <dt class="font-semibold">Суточный</dt>
                  <dd>{{ car.rateDay }} ₽/сут</dd>
                </div>
              </dl>
              <div class="mt-auto flex items-center justify-between">
                <p class="text-xs text-gray-500">Запас хода: {{ car.range }} км</p>
                <router-link
                  :to="`/order/${car.id}`"
                  class="inline-block px-4 py-2 bg-blue-600 text-white font-medium text-xs leading-snug uppercase rounded shadow-sm hover:bg-blue-700 focus:bg-blue-700 focus:outline-none transition duration-150 ease-in-out"
                >
                  Выбрать
                </router-link>
              </div>
            </div>
          </article>
        </div>
      </section>

      <section class="max-w-6xl mx-auto mb-10 grid md:grid-cols-2 gap-6">
        <section aria-label="Текущее бронирование" class="bg-white border border-solid border-gray-200 rounded-2xl p-5 shadow-sm">
          <h2 class="text-xl font-bold text-gray-900 mb-3">Текущая поездка</h2>
          <p class="text-sm text-gray-700 mb-2">На данный момент активных бронирований нет.</p>
          <p class="text-sm text-gray-600">
            Как только вы выберете автомобиль и начнёте аренду, здесь появится краткое резюме поездки: модель авто, зона завершения и примерная стоимость.
          </p>
        </section>

        <section aria-label="Последние поездки" class="bg-white border border-solid border-gray-200 rounded-2xl p-5 shadow-sm">
          <h2 class="text-xl font-bold text-gray-900 mb-3">Последние поездки</h2>
          <ul class="space-y-2 text-sm text-gray-700">
            <li v-for="trip in lastTrips" :key="trip.id" class="flex justify-between gap-3">
              <span>{{ trip.route }}</span>
              <span class="text-gray-500">{{ trip.cost }} · {{ trip.date }}</span>
            </li>
          </ul>
        </section>
      </section>
    </main>
  </body>
</template>

<script setup>
const cars = [
  {
    name: 'Hyundai Solaris',
    segment: 'Эконом',
    transmission: 'Автомат',
    fuel: 'Бензин',
    description: 'Городской седан для повседневных поездок и деловых встреч.',
    rateMinute: 10,
    rateHour: 350,
    rateDay: 1900,
    range: 450,
  },
  {
    name: 'Kia Rio X-Line',
    segment: 'Комфорт',
    transmission: 'Автомат',
    fuel: 'Бензин',
    description: 'Универсал с увеличенным клиренсом для города и пригорода.',
    rateMinute: 12,
    rateHour: 420,
    rateDay: 2200,
    range: 480,
  },
  {
    name: 'Skoda Octavia',
    segment: 'Комфорт',
    transmission: 'Автомат',
    fuel: 'Дизель',
    description: 'Просторный салон и увеличенный багажник для семейных поездок.',
    rateMinute: 14,
    rateHour: 480,
    rateDay: 2600,
    range: 650,
  },
  {
    name: 'Tesla Model 3',
    segment: 'Электро',
    transmission: 'Автомат',
    fuel: 'Электро',
    description: 'Электроседан с быстрым разгоном и доступом к зарядной сети.',
    rateMinute: 18,
    rateHour: 650,
    rateDay: 3900,
    range: 380,
  },
  {
    name: 'BMW 3 Series',
    segment: 'Бизнес',
    transmission: 'Автомат',
    fuel: 'Бензин',
    description: 'Бизнес-седан для деловых поездок и встреч с клиентами.',
    rateMinute: 20,
    rateHour: 720,
    rateDay: 4300,
    range: 520,
  },
  {
    name: 'Renault Kaptur',
    segment: 'Комфорт',
    transmission: 'Автомат',
    fuel: 'Бензин',
    description: 'Кроссовер для поездок по городу и за его пределами.',
    rateMinute: 13,
    rateHour: 460,
    rateDay: 2500,
    range: 500,
  },
]

const lastTrips = [
  { id: 1, route: 'Центр → БЦ «Премьер»', cost: '310 ₽', date: 'вчера' },
  { id: 2, route: 'ЖД вокзал → Аэропорт', cost: '820 ₽', date: '2 дня назад' },
  { id: 3, route: 'Дом → ТРЦ «Север»', cost: '260 ₽', date: '4 дня назад' },
]
</script>
