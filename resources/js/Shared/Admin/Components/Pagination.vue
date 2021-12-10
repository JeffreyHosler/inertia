<template>
	<div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
		<div class="flex-1 flex justify-between sm:hidden">
			<Link :href="data.previous_page_url" v-if="data.previous_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
				Previous
			</Link>
			<Link :href="data.next_page_url" v-if="data.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
				Next
			</Link>
		</div>
		<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
			<div>
				<p class="text-sm text-gray-700">
				Showing
				<span class="font-medium">{{data.from}}</span>
				to
				<span class="font-medium">{{data.to}}</span>
				of
				<span class="font-medium">{{data.total}}</span>
				results
				</p>
			</div>
		
			<div>
				<nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
					<!-- first page button -->
					<Link class='relative inline-flex items-center px-4 py-2 border text-sm font-medium bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
						:href="data.first_page_url"
					>
						FIRST
					</Link>

					<!-- three dot seperator -->
					<span class='cursor-pointer relative inline-flex items-center px-4 py-2 border text-sm font-medium bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
						v-if="startPage != 1"
					>
						...
					</span>

					<Link v-for="(link, index) in pages" :key="index"
						class='relative inline-flex items-center px-4 py-2 border text-sm font-medium'
						:class="[link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' ]"
						:href="link.url"
					>
						<span v-html=link.label></span>
					</Link>

					<!-- three dot seperator -->
					<span class='cursor-pointer relative inline-flex items-center px-4 py-2 border text-sm font-medium bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
						v-if="endPage != data.last_page"
					>
						...
					</span>

					<!-- last page button -->
					<Link
						class='relative inline-flex items-center px-4 py-2 border text-sm font-medium bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
						:href="data.last_page_url"
					>
						LAST
					</Link>
				</nav>
			</div>
		</div>
	</div>
</template>

<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import { computed } from 'vue' 

let props = defineProps({
	data: {
		type: Object,
		required: true
	},
	limit: {
		type: Number,
		default: 2
	}
})

/* get the start page in the paginator */
let startPage = computed(() => {
	const active = props.data.links.find((link) => link.active)
	const page = parseInt(active.label)
	const start = page - props.limit
	
	return (start > 0) ? start : 1
})

/* get the end page in the paginator */
let endPage = computed(() => {
	const active = props.data.links.find((link) => link.active)
	const page = parseInt(active.label)
	const end = page + props.limit
	
	return (end < props.data.last_page) ? end : props.data.last_page
})

/* return pages in that range */
let pages = computed(() => {
	return props.data.links.filter(function(link) {
		const page = parseInt(link.label)
		return !isNaN(page) && ( ( page <= startPage.value && page >= startPage.value ) || ( page > startPage.value && page <= endPage.value ) )
	})
})


</script>