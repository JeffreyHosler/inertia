import {
    BellIcon,
    CalendarIcon,
    ChartBarIcon,
    FolderIcon,
    HomeIcon,
    InboxIcon,
    UsersIcon,
    XIcon,
	AcademicCapIcon
} from "@heroicons/vue/outline";

const routes = [
    { 
		name: "Dashboard", 
		route: "admin.dashboard", 
		icon: HomeIcon 
	},
    {
        name: "Users",
        route: "admin.users",
        icon: UsersIcon,
    },
	{
        name: "Roles",
        route: "admin.roles",
        icon: AcademicCapIcon,
    },
];

export { routes };
