<template>
	Hello Users
	<Nav/>
</template>

<script>
import Nav from '../Shared/Nav'


export default {
	components: {
		Nav
	},
	props: {
		name: String	
	},
}
</script>
