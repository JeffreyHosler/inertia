import {
    BellIcon,
    CalendarIcon,
    ChartBarIcon,
    FolderIcon,
    HomeIcon,
    InboxIcon,
    UsersIcon,
    XIcon,
} from "@heroicons/vue/outline";

const routes = [
    { name: "Dashboard", route: "admin.dashboard", icon: HomeIcon },
    {
        name: "Users",
        route: "admin.users",
        icon: UsersIcon,
    },
];

export { routes };
