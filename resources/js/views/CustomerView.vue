<script setup>
import { onMounted, ref, onUpdated } from 'vue';
import { fetchCustomer } from '../api';

const customers = ref(null);
const customerSearch = ref('');

// customers.value = await fetchCustomer();
onMounted(async () => {
  console.log('mounted');

  customers.value = await fetchCustomer(customerSearch.value);
});

// onCreated(() => {
//   console.log('created');
// });
onUpdated(() => {
  console.log('Updated');
  // console.log(customerSearch);
});

const handleCustomerSearchChange = async () => {
  const searchText = customerSearch.value;

  console.log('search text changed to: ' + searchText);

  customers.value = await fetchCustomer(searchText)
}

</script>

<template>
  <div
    class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
      <h2 class="mb-6 text-xl font-semibold text-black dark:text-white">Customers</h2>

      <div class="flex">
        <input 
          type="text" 
          placeholder="Type to search..."
          v-model="customerSearch"
          @input="handleCustomerSearchChange"
          class="w-100 rounded border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary mb-5" />
        <button class="bg-blue-500 text-white rounded-r p-3 h-full">Search</button>
      </div>
    </div>

    <div class="flex flex-col">
      <div class="grid grid-cols-4 sm:grid-cols-4 rounded-sm bg-gray-2 dark:bg-meta-4">
        <div class="p-2.5 xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Id</h5>
        </div>
        <div class="p-2.5 text-center xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Name</h5>
        </div>
        <div class="p-2.5 text-center xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Email</h5>
        </div>
        <div class="p-2.5 text-end sm:block xl:p-5 justify-end">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Actions</h5>
        </div>
      </div>

      <div v-show="!customers" class="text-center">
        <span class="loading loading-spinner loading-lg my-10"></span>
      </div>

      <div v-if="customers">
        <div v-for="customer in customers?.data" :key="customer.id"
          :class="`grid grid-cols-4 sm:grid-cols-4 ${customer.id === customers?.data?.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'}`">

          <div class="flex p-2.5 xl:p-5">
            <p class="text-black dark:text-white">{{ customer.id }}</p>
          </div>

          <div class="flex items-center p-2.5 xl:p-5">
            <p class="text-meta-3">{{ customer.name }}</p>
          </div>

          <div class="items-center p-2.5 sm:flex xl:p-5">
            <p class="text-black dark:text-white">{{ customer.email }}</p>
          </div>

          <div class="items-center justify-end p-2.5 sm:flex xl:p-5">
            <p class="text-meta-5">Edit</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>