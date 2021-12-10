<template>
	<div
		aria-live="assertive"
		class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-999999"
		v-if="$page.props.flash"
	>
		<div class="w-full flex flex-col items-center space-y-4 sm:items-end">
			<transition
				enter-active-class="transform ease-out duration-300 transition"
				enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
				enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
				leave-active-class="transition ease-in duration-100"
				leave-from-class="opacity-100"
				leave-to-class="opacity-0"
				v-for="(flash, index) in $page.props.flash" :key="index"
			>
				<div
					:class="`max-w-sm w-full bg-${textColor(flash)}-500 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden`"
				>
					<div class="p-4">
						<div class="flex items-start">
							<div class="flex-shrink-0">
								<CheckCircleIcon
									class="h-6 w-6 text-white"
									aria-hidden="true"
									v-if="flash.level == 'success'"
								/>
								<ExclamationCircleIcon
									class="h-6 w-6 text-white"
									aria-hidden="true"
									v-if="flash.level == 'warning'"
								/>
								<BanIcon
									class="h-6 w-6 text-white"
									aria-hidden="true"
									v-if="flash.level == 'danger'"
								/>
							</div>
							<div class="ml-3 w-0 flex-1 pt-0.5">
								<p class="text-sm font-medium text-white">
									{{ flash.message }}
								</p>
							</div>
							<div class="ml-4 flex-shrink-0 flex">
								<button
									@click="$page.props.flash.splice(index, 1)"
									:class="`bg-${textColor(flash)}-500 rounded-md inline-flex text-white hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500`"
								>
									<span class="sr-only">Close</span>
									<XIcon
										class="h-5 w-5"
										aria-hidden="true"
									/>
								</button>
							</div>
						</div>
					</div>
				</div>
			</transition>
		</div>
	</div>
</template>

<script setup>
import { CheckCircleIcon, ExclamationCircleIcon, BanIcon } from "@heroicons/vue/outline";
import { XIcon } from "@heroicons/vue/solid";

const textColor = (flash) => { 
	switch (flash.level) {
		case 'success':
			return 'green'
			break;
	
		case 'danger':
			return 'red'
			break;

		case 'warning':
			return 'yellow'
			break;

		case 'info':
			return 'blue'
			break;
	}
}
</script>