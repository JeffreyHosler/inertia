<template>
	<label
		:for="id"
		:class="labelClass"
	>
		{{label}}
	</label>
	<div class="mt-1 flex rounded-md shadow-sm">
		<input
			:value="modelValue"
			@input="$emit('update:modelValue', $event.target.value)"
			:type="type"
			:id="id"
			:autocomplete="id"
			:class="inputClass"
		/>
	</div>
	<div class="mt-1 text-red-500 text-xs" v-if="error" v-text="error"></div>

</template>

<script setup>
	import { toRefs } from 'vue' 

	let props = defineProps({
		label: {
			type: String,
			required: true,
			description: "The text of the lavel"
		},
		type: {
			type: String,
			required: false,
			description: "What type of input is it",
			default: 'text',
		},
		id: {
			type: String,
			required: true,
			description: "ID to bind stuff",
		},
		modelValue: {
            type: String,
            default: '',
            required: true,
			description: "Two way data binding the input field",
        },
		error: {
            type: String,
            default: '',
            required: false,
			description: "The validation error",
        },
		inputClass: {
			type: String,
			default: 'flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300',
			required: false,
		},
		labelClass: {
			type: String,
			default: 'block text-sm font-medium text-gray-7000',
			required: false,
		}
	})
</script>