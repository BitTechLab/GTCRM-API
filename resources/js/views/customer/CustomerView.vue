<script setup lang="ts">
import { onMounted, onUpdated, ref } from 'vue';
import CustomerModal from './CustomerModal.vue';
import PaginateList from '@/components/PaginateList.vue';
import LoadingEffect from '@/components/effect/LoadingEffect.vue';
import ErrorMessage from '@/components/ErrorMessage.vue';
import DeleteModal from '@/components/DeleteModal.vue';
import { useCustomerStore } from '@/stores/customer';
import { useRoute, useRouter } from 'vue-router';
import { SORT_DIRECTION_DESC, SORT_DIRECTION_ASC } from '@/const'

const store = useCustomerStore();
const route = useRoute();
const router = useRouter();
const deleteId = ref(0);
const search = ref(route.query?.search);

const headers = {
  id: {
    label: 'ID',
    sort: true,
  },
  name: {
    label: 'Name',
    sort: true,
  },
  email: {
    label: 'Email Address',
    sort: true,
  },
  status: {
    label: 'Status',
    sort: true,
  },
  action: {
    label: 'Action',
  }
}

onMounted(async () => {
  handleFetchCustomer();
});

onUpdated(async () => {
  handleFetchCustomer();
})

const handleFetchCustomer = () => {
  let hasChange = false;
  const checkParams = ['page', 'search', 'sort', 'direction'];

  for (let checkParam of checkParams) {
    if (store[checkParam] !== route.query?.[checkParam]) {
      store[checkParam] = route.query[checkParam];
      hasChange = true;
    }
  }

  if (hasChange) {
    store.fetchCustomers();
  }
}

const handleSearch = () => {
  router.push({ name: 'customer', query: { search: search.value } });
}

const handleShowDelete = (id: number) => {
  deleteId.value = id;
  store.showDelete = true;
}
</script>

<template>
  <div class="flex flex-col md:flex-row md:items-center md:justify-between">
    <h2 class="mb-6 text-xl font-semibold text-black dark:text-white">{{ $t('header.customer')}}</h2>

    <div class="flex">
      <input type="text" :placeholder="$t('placeholder.search')" v-model="search" @keyup.enter="handleSearch"
        class="w-100 rounded border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary mb-5" />
      <button class="bg-blue-500 text-white rounded-r p-3 h-full" @click="handleSearch">{{
        $t('action.search') }}</button>

      <button @click="store.addCustomer" type="button"
        class="bg-blue-500 text-white rounded p-3 h-full ml-2 inline-flex">
        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
            clip-rule="evenodd"></path>
        </svg>
        {{ $t('action.addNewCustomer') }}</button>
    </div>
  </div>

  <div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
      <thead
        class="text-xs text-gray-700 border-b border-gray uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th v-for="(header, key) in headers" :key="key" scope="col" class="px-6 py-4">
            <RouterLink v-if="header.sort"
              :to="{ path: 'customer', query: { ...route.query, sort: key, direction: ((store.sort === key && store.direction === SORT_DIRECTION_ASC) ? SORT_DIRECTION_DESC : SORT_DIRECTION_ASC) } }"
              class="flex flex-row text-md">
              <span>{{ $t(`label.${key}`) }}</span>

              <svg v-if="store.sort !== key" class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M12.832 3.445a1 1 0 0 0-1.664 0l-4 6A1 1 0 0 0 8 11h8a1 1 0 0 0 .832-1.555l-4-6Zm-1.664 17.11a1 1 0 0 0 1.664 0l4-6A1 1 0 0 0 16 13H8a1 1 0 0 0-.832 1.555l4 6Z" clip-rule="evenodd"/>
              </svg>

              <svg v-if="store.sort === key && store.direction === SORT_DIRECTION_DESC" class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M5.575 13.729C4.501 15.033 5.43 17 7.12 17h9.762c1.69 0 2.618-1.967 1.544-3.271l-4.881-5.927a2 2 0 0 0-3.088 0l-4.88 5.927Z" clip-rule="evenodd"/>
              </svg>
              
              <svg v-if="store.sort === key && store.direction !== SORT_DIRECTION_DESC" class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M18.425 10.271C19.499 8.967 18.57 7 16.88 7H7.12c-1.69 0-2.618 1.967-1.544 3.271l4.881 5.927a2 2 0 0 0 3.088 0l4.88-5.927Z" clip-rule="evenodd"/>
              </svg>
            </RouterLink>

            <span v-if="!header.sort">
              {{ $t(`label.${key}`) }}
            </span>
          </th>
        </tr>
      </thead>
      <tbody>

        <tr v-if="store.loading">
          <td colspan="5">
            <LoadingEffect :loading="store.loading" />
          </td>
        </tr>

        <tr v-if="store.error">
          <td colspan="5">
            <ErrorMessage :error="error" />
          </td>
        </tr>

        <tr v-for="customer in store.customers" :key="customer.id"
          class="bg-white border-b border-gray dark:bg-gray-800">
          <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ customer.id }}
          </th>
          <td class="px-6 py-2">
            {{ customer.name }}
          </td>
          <td class="px-6 py-2">
            {{ customer.email }}
          </td>
          <td class="px-6 py-2">
            <span
              :class="`${customer.status === 'active' ? 'bg-green-400' : 'bg-warning'} px-2 py-1 rounded text-white`">{{
                customer.status }}</span>
          </td>
          <td class="px-6 py-2 items-center">
            <button type="button" @click="store.editCustomer(customer.id)"
              class="editCustomer text-blue-700 border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
              <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                  d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                  clip-rule="evenodd" />
                <path fill-rule="evenodd"
                  d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                  clip-rule="evenodd" />
              </svg>

              <span class="sr-only">Edit</span>
            </button>

            <button type="button" @click="handleShowDelete(customer.id)"
              class="text-red hover:bg-red hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
              <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
              </svg>

              <span class="sr-only">Delete</span>
            </button>
          </td>
        </tr>

      </tbody>
    </table>
  </div>

  <PaginateList baseUrl="customer" :links="store.pagination" />

  <CustomerModal />
  <DeleteModal :show="store.showDelete" :id="deleteId" :handleDelete="store.handleDelete" :loading="store.deleteLoading"
    :errorMessage="store.deleteErrorMessage" />
</template>