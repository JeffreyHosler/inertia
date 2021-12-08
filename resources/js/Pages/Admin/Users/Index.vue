<template>
	<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    	<div class="max-w-none mx-auto">
			<div class="bg-white overflow-hidden sm:rounded-lg sm:shadow">
				<Card title="Users">
					<template v-slot:buttonslot>
						<input type="text" v-model="search" class="focus:ring-indigo-500 focus:border-indigo-500 rounded-md sm:text-sm border-gray-300 mr-5" placeholder="Search">
						<button type="button" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
							Add User
						</button>
					</template>
				</Card>
				<div class="flex flex-col">
					<div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
						<div class="align-middle inline-block min-w-full sm:px-6 lg:px-8">
							<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
								<table class="min-w-full divide-y divide-gray-200">
									<thead class="bg-gray-50">
										<tr>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											First Name
											</th>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											Last Name
											</th>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											Username
											</th>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											Email
											</th>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											Role
											</th>
											<th scope="col" class="relative px-6 py-3">
											<span class="sr-only">Edit</span>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(user, index) in users.data" :key="user.id" :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
											<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
											{{ user.first_name }}
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
											{{ user.last_name }}
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
											{{ user.name }}
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
											{{ user.email }}
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
											--
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
											<a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	import Card from '@components/Card'
	import { ref, watch } from 'vue'
	import { Inertia } from '@inertiajs/inertia'
	import { debounce, route } from '@js/utils/utils'

	defineProps({
		users: {
			type: Object,
			required: true
		}
	})

	/* handles searching users */
	let search = ref(null)
	watch(search, debounce((val) => {
		Inertia.get(route('admin.users'), { search: search.value }, { preserveState: true, replace: true });
	}, 400))

</script>