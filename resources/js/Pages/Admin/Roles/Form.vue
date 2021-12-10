<template>
	<Card title="Roles Form" />
	<form class="space-y-8 divide-y divide-gray-200 p-5" @submit.prevent="submit">
		<div class="space-y-8 divide-y divide-gray-200">
			<div>
				<div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
					<div class="sm:col-span-4">
						<Input 
							v-model="form.name"
							id="name"
							label="Name"
							:error="form.errors.name"
						/>
					</div>
				</div>

				<div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
					<div class="sm:col-span-4">
						<label
							for="permissions"
							class="block text-sm font-medium text-gray-700"
						>
							Permissions
						</label>
						<div class="mt-1">
							<VueMultiselect
								v-model="form.permissions"
								:options="permissions"
								label="name" 
								track-by="id"
								:multiple="true" 
								:close-on-select="false"
								value="id"
								tag-placeholder="Add new permisisons"
								:taggable="true" 
								@tag="addPermissions"
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
							></VueMultiselect>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="pt-5">
			<div class="flex justify-end">
				<Link :href="route('admin.roles')" as="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
	role: {
		type: Object,
		required: true,
	},
	permissions: {
		type: Object
	}
});

let form = useForm({
	name: props.role.name ?? "",
	permissions: props.role.permissions ?? []
})


const submit = () => {
	let permissionsIds = form.permissions.map(permission => permission.id)
	form.transform((data) => ({
		...data,
		_method: props.role.id ? 'PATCH' : 'POST',
		perms: permissionsIds.filter(permission => permission > 0),
		newperms: form.permissions.filter(permission => permission.id < 0)
  	}))
  	.post(route('admin.roles.save', { role: props.role.id ?? null}))
}

/**
 * Add a new permission to the permissions object to add 
 * 
 * @param {String}
 */
const addPermissions = (newTag) => {
	/* we are adding a new permission. so lets get a negative id to mape it to the component */
	const sortedProps = form.permissions.sort((a, b) => (a.id > b.id) ? 1 : -1)
	let fakeId = ! sortedProps.length || sortedProps[0].id >= 0 ? -1 : sortedProps[0].id - 1

	form.permissions.push({
		id: fakeId,
		name: newTag
	})
}
</script>
