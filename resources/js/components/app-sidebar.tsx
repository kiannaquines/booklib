import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { SharedData, type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { BookCopy, BookOpen, LayoutGrid, Microscope, Palette, Printer, RockingChair, UserCheck, UserRoundSearch } from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
        icon: LayoutGrid,
    },
    {
        title: 'Books',
        href: route('books.index'),
        icon: BookOpen,
    },
    {
        title: 'Equipment',
        href: route('equipments.index'),
        icon: Microscope,
    },
    {
        title: 'Study Space',
        href: route('study-spaces.index'),
        icon: BookCopy,
    },
    {
        title: 'Equipment Reservations',
        href: route('equipment-reservations.index'),
        icon: Printer,
    },
    {
        title: 'Book Reservations',
        href: route('book-reservations.index'),
        icon: BookOpen,
    },
    {
        title: 'Seat Reservations',
        href: route('seat-reservations.index'),
        icon: RockingChair
    },
    {
        title: 'Users',
        href: route('users.index'),
        icon: UserRoundSearch,
    },
    // users route
    {
        title: 'My Book Reservation',
        href: route('student.myBookReservation'),
        icon: LayoutGrid,
    },
    {
        title: 'My Equipment Reservation',
        href: route('student.myEquipmentReservation'),
        icon: LayoutGrid,
    },
    {
        title: 'My Seat Reservation',
        href: route('student.mySeatReservation'),
        icon: LayoutGrid,
    },
    {
        title: 'Book Reservation',
        href: route('student.bookReservation'),
        icon: BookOpen,
    },
    {
        title: 'Seat Reservation',
        href: route('student.seatReservation'),
        icon: BookOpen,
    },
    {
        title: 'Equipment Reservation',
        href: route('student.equipmentReservation'),
        icon: Microscope,
    }
];

const footerNavItems: NavItem[] = [
    {
        title: 'Profile',
        href: '/settings/profile',
        icon: UserCheck,
    },
    {
        title: 'Password',
        href: '/settings/password',
        icon: BookOpen,
    },
    {
        title: 'Appearance',
        href: '/settings/appearance',
        icon: Palette,
    }
];

export function AppSidebar() {

    const { auth } = usePage<SharedData>().props
    const role = Array.isArray(auth.user?.roles) ? auth.user.roles[0]?.name : 'user'

    const adminOnly = [
        "Dashboard",
        "Books",
        "Equipment",
        "Study Space",
        "Equipment Reservations",
        "Book Reservations",
        "Users",
        "Seat Reservations"
    ];

    const userOnly = [
        "Book Reservation",
        "Equipment Reservation",
        "My Book Reservation",
        "My Equipment Reservation",
        "My Seat Reservation",
        "Seat Reservation"
    ];

    const visibleModules = mainNavItems.filter(item => {
        if (role === "admin") {
            return !userOnly.includes(item.title);
        }

        if (role === "user") {
            return userOnly.includes(item.title);
        }

        return !adminOnly.includes(item.title);
    });

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={role === "admin" ? route('dashboard') : route('student.myBookReservation')} prefetch>
                                <AppLogo header={role === "admin" ? "BookLib Admin Panel v0.1" : "BookLib Student Panel v0.1"} />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={visibleModules} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
