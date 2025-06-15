import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BookCopy, BookOpen, Folder, LayoutGrid, Microscope, Palette, Printer, UserCheck, UserRoundSearch } from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Books',
        href: '/books',
        icon: BookOpen,
    },
    {
        title: 'Equipment',
        href: '/equipment',
        icon: Microscope,
    },
    {
        title: 'Study Space',
        href: '/study-space',
        icon: BookCopy,
    },
    {
        title: 'Equipment Reservations',
        href: '/equipment-reservations',
        icon: Printer,
    },
    {
        title: 'Book Reservations',
        href: '/book-reservations',
        icon: BookOpen,
    },
    {
        title: 'Users',
        href: '/users',
        icon: UserRoundSearch,
    },
    {
        title: 'Reports',
        href: '/reports',
        icon: Printer,
    },
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
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
