<template>
	<Card title="User Form" />
	<form class="space-y-8 divide-y divide-gray-200 p-5" @submit.prevent="submit">
		<div class="space-y-8 divide-y divide-gray-200">
			<div>
				<div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
					<div class="sm:col-span-4">
						<Input 
							v-model="form.first_name"
							id="first_name"
							label="First Name"
							:error="form.errors.first_name"
						/>
					</div>
				</div>

				<div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
					<div class="sm:col-span-4">
						<Input 
							v-model="form.last_name"
							id="last_name"
							label="Last Name"
							:error="form.errors.last_name"
						/>
					</div>
				</div>

				<div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
					<div class="sm:col-span-4">
						<Input 
							v-model="form.username"
							id="username"
							label="User Name"
							:error="form.errors.username"
						/>
					</div>
				</div>

				<div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
					<div class="sm:col-span-4">
						<Input 
							v-model="form.email"
							id="email"
							label="Email"
							type="email"
							:error="form.errors.email"
						/>
					</div>
				</div>

				<div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
					<div class="sm:col-span-4">
						<Input 
							v-model="form.password"
							id="password"
							label="Password"
							type="password"
							:error="form.errors.password"
						/>
					</div>
				</div>

				<div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
					<div class="sm:col-span-4">
						<Input 
							v-model="form.password_confirmation"
							id="password_confirmation"
							label="Confirm Password"
							type="password"
							:error="form.errors.password_confirmation"
						/>
					</div>
				</div>

				<div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
					<div class="sm:col-span-4">
						<label
							for="roles"
							class="block text-sm font-medium text-gray-700"
						>
							Roles
						</label>
						<div class="mt-1">
							<VueMultiselect
								v-model="form.roles"
								:options="roles"
								label="name" 
								track-by="id"
								:multiple="true" 
								:close-on-select="false"
								value="id"
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
							></VueMultiselect>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="pt-5">
			<div class="flex justify-end">
				<Link :href="route('admin.users')" as="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
					Cancel
				</Link>
				<button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
					Save
				</button>
			</div>
		</div>
	</form>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script setup>
import Card from "@components/Card"
import Input from "@components/Forms/Input"
import VueMultiselect from "vue-multiselect";
import { useForm } from "@inertiajs/inertia-vue3"

let props = defineProps({
	user: {
		type: Object,
		required: true,
	},
	roles: {
		type: Object,
		required: true,
	},
});

let form = useForm({
	first_name: props.user.first_name ?? "",
	last_name: props.user.last_name ?? "",
	password: "",
	password_confirmation: "",
	email: props.user.email ?? "",
	username: props.user.name ?? "",
	roles: props.user.roles ?? [],
})


const submit = () => {
	let roleIds = form.roles.map(role => role.id)
	form.transform((data) => ({
		...data,
		_method: props.user.id ? 'PATCH' : 'POST',
		roles: roleIds,
  	}))
  	.post(route('admin.users.save', { user: props.user.id ?? null}))
}
</script>
