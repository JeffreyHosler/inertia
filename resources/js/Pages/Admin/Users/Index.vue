<template>
	<Card title="Users">
		<template v-slot:buttonslot>
			<input
				type="text"
				v-model="search"
				class="focus:ring-indigo-500 focus:border-indigo-500 rounded-md sm:text-sm border-gray-300 mr-5"
				placeholder="Search"
			>
			<Link
				:href="route('admin.users.form')"
				class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
			>
			Add User
			</Link>
		</template>
	</Card>
	<div class="flex flex-col">
		<div class="sm:-mx-6 lg:-mx-8">
			<div class="align-middle inline-block min-w-full sm:px-6 lg:px-8">
				<div class="shadow border-b border-gray-200 sm:rounded-lg">
					<table class="min-w-full divide-y divide-gray-200">
						<thead class="bg-gray-50">
							<tr>
								<th
									scope="col"
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
								>
									First Name
								</th>
								<th
									scope="col"
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
								>
									Last Name
								</th>
								<th
									scope="col"
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
								>
									Username
								</th>
								<th
									scope="col"
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
								>
									Email
								</th>
								<th
									scope="col"
									class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
								>
									Role
								</th>
								<th
									scope="col"
									class="relative px-6 py-3"
								>
									<span class="sr-only">Edit</span>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="(user, index) in users.data"
								:key="user.id"
								:class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
							>
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
									<span class="relative z-25 inline-flex shadow-sm rounded-md">
										<Link
											as="button"
											class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-1000 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
											:href="route('admin.users.form', { user: user.id })"
										>
											Edit
										</Link>
										<Menu
											as="span"
											class="-ml-px relative block"
										>
											<MenuButton class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-1000 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 z-500">
												<span class="sr-only">Open options</span>
												<ChevronDownIcon
													class="h-5 w-5"
													aria-hidden="true"
												/>
											</MenuButton>
											<transition
												enter-active-class="transition ease-out duration-100"
												enter-from-class="transform opacity-0 scale-95"
												enter-to-class="transform opacity-100 scale-100"
												leave-active-class="transition ease-in duration-75"
												leave-from-class="transform opacity-100 scale-100"
												leave-to-class="transform opacity-0 scale-95"
											>
												<MenuItems class="origin-top-right absolute right-0 mt-2 -mr-1 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
													<div class="py-1">
														<MenuItem v-slot="{ active }">
															<Link
																:key='user.id'
																:href="route('admin.users.delete', { user: user.id })"
																:class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']"
																method="DELETE"
																preserve-state
															>
																Delete
															</Link>
														</MenuItem>
													</div>
												</MenuItems>
											</transition>
										</Menu>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
					<Pagination :data="users" />
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import Card from "@components/Card";
import Pagination from "@components/Pagination";

import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { debounce } from "@js/utils/utils";
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/solid'

defineProps({
	users: {
		type: Object,
		required: true,
	},
});

/* handles searching users */
let search = ref(null);
watch(
	search,
	debounce((val) => {
		Inertia.get(
			route("admin.users"),
			{
				search: search.value,
			},
			{
				preserveState: true,
				replace: true,
			}
		);
	}, 400)
);
</script>