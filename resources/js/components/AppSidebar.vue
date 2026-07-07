<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { 
    LayoutGrid, Package, ShoppingCart, Users, 
    Globe, ShieldCheck, Settings2, UserCog,
    Image as ImageIcon
} from 'lucide-vue-next';

import AppLogo from '@/components/AppLogo.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { useAuth } from '@/composables/useAuth'; 
import {
    Sidebar, SidebarContent, SidebarFooter, SidebarHeader,
    SidebarMenu, SidebarMenuButton, SidebarMenuItem,
} from '@/components/ui/sidebar';

import type { NavItem } from '@/types';
import { dashboard } from '@/routes'; 

// Importación de Controladores (Wayfinder)
import * as WebProductoController from '@/actions/App/Http/Controllers/Admin/WebProductoController';
import * as WebClienteController from '@/actions/App/Http/Controllers/Admin/WebClienteController';
import * as WebPedidoController from '@/actions/App/Http/Controllers/Admin/WebPedidoController';
import * as UserController from '@/actions/App/Http/Controllers/Admin/UserController';
import * as WebBannerController from '@/actions/App/Http/Controllers/Admin/WebBannerController';

const { can } = useAuth(); 

interface NavSection {
    label: string;
    items: NavItem[];
}

const navigationSections = computed<NavSection[]>(() => [
    {
        label: 'Resumen',
        items: [
            { title: 'Ver Sitio Web', href: '/', icon: Globe},
            { title: 'Panel de Control', href: dashboard(), icon: LayoutGrid },
        ],
    },
    {
        label: 'Gestión Comercial',
        items: [

            ...(can('maestros.view') || can('maestros.update') ? [{ 
                title: 'Catálogo de Productos',
                href: WebProductoController.index.url(),
                icon: Package 
            }] : []),

                ...(can('banners.view') ? [{ 
                title: 'Banners del Home',
                href: WebBannerController.index.url(),
                icon: ImageIcon 
            }] : []),


            ...(can('pedidos.view') ? [{ 
                title: 'Pedidos Online',
                href: WebPedidoController.index.url(),
                icon: ShoppingCart 
            }] : []),


            ...(can('clientes.view') ? [{ 
                title: 'Base de Clientes',
                href: WebClienteController.index.url(),
                icon: Users 
            }] : []),
        ].filter(Boolean), 
    },
    {
        label: 'Seguridad y Sistema',
        items: [

            ...(can('users.manage') ? [{ 
                title: 'Gestión de Operadores',
                href: UserController.index.url(),
                icon: ShieldCheck 
            }] : []),
        ].filter(Boolean),
    }
]);
</script>

<template>
    <Sidebar collapsible="icon" variant="inset" class="border-r border-white/5">

        <SidebarHeader class="p-4">
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child class="hover:bg-primary/10 transition-colors">
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>


        <SidebarContent>
            <NavMain :sections="navigationSections" />
        </SidebarContent>


        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
</template>