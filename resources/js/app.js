import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3"
import { InertiaProgress } from '@inertiajs/progress'
import { ZiggyVue } from 'ziggy/vue'
import AdminTemplate from './Shared/Admin/Template'
import Layout from './Shared/Front/Template'

createInertiaApp({
	resolve: name => {
		let page = require(`./Pages/${name}`).default
	
		if (name.startsWith('Admin')) {
			page.layout = AdminTemplate
		}
		else if (name.startsWith('Auth')) {
			page.layout = null
		}
		else 
		{
			page.layout = Layout
		}
	
		return page
	},
  	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.component("Link", Link)
			.component("Head", Head)
			.mixin({ methods: { route } })
			.mount(el)
	},

	title: title => `My App - ${title}`
})

InertiaProgress.init();