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
          <router-link to="/login" class="text-gray-700 hover:text-blue-600 transition duration-200 ease-in-out">
            Выйти
          </router-link>
        </nav>
      </div>
    </header>

    <main class="px-6 py-8 lg:py-10">
      <section class="max-w-6xl mx-auto mb-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
          <div>
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 pb-2">Оформление заказа</h1>
            <p class="text-gray-700 text-lg leading-relaxed">
              Вы выбрали автомобиль. Укажите тариф и параметры аренды, затем подтвердите заказ.
            </p>
          </div>
          <router-link
            to="/app"
            class="inline-block px-5 py-2 bg-white text-blue-600 font-medium text-xs leading-snug uppercase rounded border border-solid border-gray-300 shadow-sm hover:bg-gray-50 transition duration-150 ease-in-out"
          >
            Назад к выбору
          </router-link>
        </div>
      </section>

      <section class="max-w-6xl mx-auto grid lg:grid-cols-3 gap-6">
        <section class="lg:col-span-2 bg-white border border-solid border-gray-200 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-4 border-b border-solid border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Карта и зона завершения</h2>
            <p class="text-sm text-gray-600 pt-1">
              Карта демонстрационная (Leaflet). В будущем сюда можно добавить реальные зоны и доступные авто.
            </p>
          </div>
          <div class="p-5">
            <div ref="mapEl" class="h-[360px] w-full rounded-xl border border-solid border-gray-200"></div>
          </div>
        </section>

        <aside class="bg-white border border-solid border-gray-200 rounded-2xl shadow-sm p-5">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Автомобиль</h2>

          <div class="mb-4 rounded-xl border border-solid border-gray-200 bg-gray-50 p-4">
            <p class="text-lg font-bold text-gray-900">{{ selectedCar.name }}</p>
            <p class="text-sm text-gray-600 pt-1">
              {{ selectedCar.segment }} · {{ selectedCar.transmission }} · {{ selectedCar.fuel }}
            </p>
            <p class="text-sm text-gray-700 pt-2">{{ selectedCar.description }}</p>
          </div>

          <div class="space-y-3 text-sm text-gray-700">
            <div>
              <label for="tariff" class="block mb-1 text-gray-700">Тариф</label>
              <select
                id="tariff"
                class="block w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-blue-600"
              >
                <option selected>Минутный ({{ selectedCar.rateMinute }} ₽/мин)</option>
                <option>Почасовой ({{ selectedCar.rateHour }} ₽/ч)</option>
                <option>Суточный ({{ selectedCar.rateDay }} ₽/сут)</option>
              </select>
            </div>

            <div>
              <label for="start" class="block mb-1 text-gray-700">Начало аренды</label>
              <input
                id="start"
                type="text"
                class="block w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-blue-600"
                placeholder="Сейчас"
              />
            </div>

            <div>
              <label for="endZone" class="block mb-1 text-gray-700">Планируемая зона завершения</label>
              <input
                id="endZone"
                type="text"
                class="block w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-blue-600"
                placeholder="Например: Центр"
              />
            </div>
          </div>

          <button
            type="button"
            class="mt-5 w-full inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
          >
            Подтвердить заказ
          </button>

          <p class="text-xs text-gray-500 pt-3 leading-relaxed">
            Демо-страница: без реальной оплаты и бронирования. Здесь можно позже добавить расчёт стоимости и проверку зон.
          </p>
        </aside>
      </section>
    </main>
  </body>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import L from 'leaflet'

const route = useRoute()
const mapEl = ref(null)
let mapInstance = null

const cars = [
  {
    id: 'solaris',
    name: 'Hyundai Solaris',
    segment: 'Эконом',
    transmission: 'Автомат',
    fuel: 'Бензин',
    description: 'Городской седан для повседневных поездок и деловых встреч.',
    rateMinute: 10,
    rateHour: 350,
    rateDay: 1900,
  },
  {
    id: 'rio-x',
    name: 'Kia Rio X-Line',
    segment: 'Комфорт',
    transmission: 'Автомат',
    fuel: 'Бензин',
    description: 'Универсал с увеличенным клиренсом для города и пригорода.',
    rateMinute: 12,
    rateHour: 420,
    rateDay: 2200,
  },
  {
    id: 'octavia',
    name: 'Skoda Octavia',
    segment: 'Комфорт',
    transmission: 'Автомат',
    fuel: 'Дизель',
    description: 'Просторный салон и увеличенный багажник для семейных поездок.',
    rateMinute: 14,
    rateHour: 480,
    rateDay: 2600,
  },
  {
    id: 'model-3',
    name: 'Tesla Model 3',
    segment: 'Электро',
    transmission: 'Автомат',
    fuel: 'Электро',
    description: 'Электроседан с быстрым разгоном и доступом к зарядной сети.',
    rateMinute: 18,
    rateHour: 650,
    rateDay: 3900,
  },
  {
    id: 'bmw-3',
    name: 'BMW 3 Series',
    segment: 'Бизнес',
    transmission: 'Автомат',
    fuel: 'Бензин',
    description: 'Бизнес-седан для деловых поездок и встреч с клиентами.',
    rateMinute: 20,
    rateHour: 720,
    rateDay: 4300,
  },
  {
    id: 'kaptur',
    name: 'Renault Kaptur',
    segment: 'Комфорт',
    transmission: 'Автомат',
    fuel: 'Бензин',
    description: 'Кроссовер для поездок по городу и за его пределами.',
    rateMinute: 13,
    rateHour: 460,
    rateDay: 2500,
  },
]

const selectedCar = computed(() => {
  const carId = String(route.params.carId || '')
  return (
    cars.find((c) => c.id === carId) || {
      id: 'unknown',
      name: 'Автомобиль не найден',
      segment: '—',
      transmission: '—',
      fuel: '—',
      description: 'Вернитесь к списку автомобилей и выберите машину для заказа.',
      rateMinute: 0,
      rateHour: 0,
      rateDay: 0,
    }
  )
})

onMounted(() => {
  if (!mapEl.value) return

  const center = [59.9386, 30.3141] // демо-центр (СПб)
  mapInstance = L.map(mapEl.value, {
    center,
    zoom: 12,
    zoomControl: true,
  })

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
  }).addTo(mapInstance)

  L.marker(center).addTo(mapInstance).bindPopup('Демо-точка: центр города').openPopup()
})

onBeforeUnmount(() => {
  if (mapInstance) {
    mapInstance.remove()
    mapInstance = null
  }
})
</script>

