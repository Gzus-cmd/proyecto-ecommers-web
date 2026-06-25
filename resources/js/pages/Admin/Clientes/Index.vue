<script setup lang="ts">
import { router, Link, Head } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import debounce from 'lodash/debounce'
import { 
    Search, Eye, UserX, UserCheck, 
    Mail, Phone, CreditCard, ShoppingBag,
    Users as UsersIcon, ChevronRight,Edit3
} from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppStatusBadge from '@/components/app/AppStatusBadge.vue'

import * as WebClienteController from '@/actions/App/Http/Controllers/Admin/WebClienteController'


defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Gestión Comercial', href: '#' },
            { title: 'Base de Clientes', href: '#' },
        ],
    },
});

const props = defineProps<{
    clientes: any 
    filters: { search?: string }
}>()


const search = ref(props.filters?.search ?? '')
const applyFilters = () => {
    router.get(
        WebClienteController.index.url(),
        { search: search.value },
        { preserveState: true, replace: true }
    )
}
watch(search, debounce(() => applyFilters(), 400))


const toggleStatus = (cliente: any) => {
    router.patch(WebClienteController.toggle.url(cliente.id), {
        activo: !cliente.activo
    }, {
        preserveScroll: true
    });
};

const mapearLabelPaginacion = (label: string) => {
    return label
        .replace('&laquo; Previous', '←')
        .replace('Next &raquo;', '→');
}
</script>

<template>
    <Head title="Gestión de Clientes" />

    <AppPageShell title="Base de Datos de Clientes" variant="full">


        <AppPageHeader 
            title="Clientes Web" 
            :subtitle="`Administre las cuentas de los ${clientes.total} usuarios registrados en la tienda.`"
        >
            <template #actions>
                <div class="px-4 py-2 bg-navy-900/50 rounded-xl border border-white/5 flex items-center gap-3">
                    <UsersIcon class="size-4 text-primary" />
                    <span class="text-[10px] font-black uppercase tracking-widest text-white">
                        {{ clientes.total }} Registrados
                    </span>
                </div>
            </template>
        </AppPageHeader>


        <AppSectionCard>
            <div class="relative max-w-xl">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground/60">
                    <Search class="size-4" />
                </span>
                <input
                    v-model="search"
                    type="text"
                    placeholder="Buscar por DNI, apellidos o correo electrónico..."
                    class="w-full h-12 pl-12 pr-4 py-2 text-sm rounded-2xl border-border bg-background/50 text-foreground focus:ring-2 focus:ring-primary/40 outline-none transition shadow-inner"
                />
            </div>
        </AppSectionCard>


        <AppSectionCard fill noPadding title="Listado General de Clientes">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border text-sm text-left border-collapse">
                    <thead class="bg-muted/40 text-muted-foreground font-black uppercase text-[10px] tracking-[0.2em] border-b border-border">
                        <tr>
                            <th class="px-8 py-5">Identidad / DNI</th>
                            <th class="px-8 py-5">Información de Contacto</th>
                            <th class="px-8 py-5 text-center">Actividad</th>
                            <th class="px-8 py-5 text-center">Estado</th>
                            <th class="px-8 py-5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50 text-foreground">
                        <tr v-if="clientes.data.length === 0">
                            <td colspan="5" class="py-32 text-center">
                                <p class="text-muted-foreground font-medium italic">No se encontraron clientes registrados.</p>
                            </td>
                        </tr>
                        <tr v-for="c in clientes.data" :key="c.id" class="hover:bg-primary/2 transition-colors group">

                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="size-10 rounded-full bg-navy-900 border border-white/5 flex items-center justify-center font-black text-primary text-xs uppercase">
                                        {{ c.nombres[0] }}{{ c.apellidos[0] }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-foreground text-sm uppercase tracking-tighter group-hover:text-primary transition-colors">
                                            {{ c.apellidos }}, {{ c.nombres }}
                                        </span>
                                        <div class="flex items-center gap-1.5 text-muted-foreground font-mono text-[10px]">
                                            <CreditCard class="size-3" /> {{ c.dni }}
                                        </div>
                                    </div>
                                </div>
                            </td>


                            <td class="px-8 py-6">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 text-xs font-medium">
                                        <Mail class="size-3 text-muted-foreground" /> {{ c.email }}
                                    </div>
                                    <div v-if="c.telefono" class="flex items-center gap-2 text-xs text-muted-foreground">
                                        <Phone class="size-3" /> {{ c.telefono }}
                                    </div>
                                </div>
                            </td>


                            <td class="px-8 py-6 text-center">
                                <div class="inline-flex flex-col items-center px-3 py-1 bg-navy-900/40 rounded-xl border border-white/5">
                                    <span class="font-black text-sm text-gold-500">{{ c.pedidos_count }}</span>
                                    <span class="text-[8px] uppercase font-black opacity-40 tracking-widest">Pedidos</span>
                                </div>
                            </td>


                            <td class="px-8 py-6 text-center">
                                <AppStatusBadge :status="c.activo" />
                            </td>


                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                   
                                    <Link 
                                        :href="WebClienteController.show.url(c.id)"
                                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all group"
                                    >
                                        <Eye class="size-3.5 group-hover:scale-110 transition-transform" />
                                        <span class="text-[10px] font-black uppercase tracking-widest">Ver Cliente</span>
                                    </Link>

                                        <Link 
                                            :href="WebClienteController.edit.url(c.id)"
                                            class="p-2 rounded-lg bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white transition-all"
                                            title="Editar Perfil"
                                        >
                                            <Edit3 class="size-4" />
                                        </Link>


                                    <button 
                                        @click="toggleStatus(c)"
                                        :class="[
                                            'p-2 rounded-lg transition-colors',
                                            c.activo ? 'hover:bg-red-500/10 text-muted-foreground hover:text-red-500' : 'hover:bg-emerald-500/10 text-muted-foreground hover:text-emerald-500'
                                        ]"
                                        :title="c.activo ? 'Desactivar Cliente' : 'Activar Cliente'"
                                    >
                                        <UserX v-if="c.activo" class="size-4" />
                                        <UserCheck v-else class="size-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer con Paginación -->
            <template #footer>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">
                        Página {{ clientes.current_page }} de {{ clientes.last_page }}
                    </span>
                    <div class="flex gap-2">
                        <template v-for="link in clientes.links" :key="link.label">
                            <Link 
                                v-if="link.url"
                                :href="link.url"
                                v-html="mapearLabelPaginacion(link.label)"
                                :class="[
                                    'px-3 py-1.5 rounded-lg text-xs font-black transition-all border',
                                    link.active ? 'bg-primary border-primary text-white shadow-lg shadow-primary/20' : 'bg-background border-border text-muted-foreground hover:bg-muted'
                                ]"
                            />
                        </template>
                    </div>
                </div>
            </template>
        </AppSectionCard>

    </AppPageShell>
</template>