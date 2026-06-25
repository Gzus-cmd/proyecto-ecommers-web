<script setup lang="ts">
import { router, Link, Head } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import debounce from 'lodash/debounce'
import { 
    Search, Eye, ShoppingBag, Calendar, 
    Truck, MapPin, DollarSign, Package,
    ArrowUpRight, Clock
} from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppStatusBadge from '@/components/app/AppStatusBadge.vue'

import * as WebPedidoController from '@/actions/App/Http/Controllers/Admin/WebPedidoController'


defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Gestión Comercial', href: '#' },
            { title: 'Pedidos Online', href: '#' },
        ],
    },
});

const props = defineProps<{
    pedidos: any // Paginado
    filters: { search?: string }
}>()


const search = ref(props.filters?.search ?? '')
const applyFilters = () => {
    router.get(
        WebPedidoController.index.url(),
        { search: search.value },
        { preserveState: true, replace: true }
    )
}
watch(search, debounce(() => applyFilters(), 400))

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(value);
}

const mapearLabelPaginacion = (label: string) => {
    return label.replace('&laquo; Previous', '←').replace('Next &raquo;', '→');
}
</script>

<template>
    <Head title="Pedidos Online" />

    <AppPageShell title="Monitoreo de Ventas Web" variant="full">


        <AppPageHeader 
            title="Pedidos Recibidos" 
            :subtitle="`Gestionando ${pedidos.total} transacciones realizadas a través de la tienda.`"
        >
            <template #actions>
                <div class="flex gap-4">

                    <div class="px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-3">
                        <DollarSign class="size-4 text-emerald-500" />
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black uppercase text-emerald-600/70 tracking-widest leading-none">Flujo Web</span>
                            <span class="text-xs font-black text-emerald-500 leading-none mt-1">Sincronizado</span>
                        </div>
                    </div>
                </div>
            </template>
        </AppPageHeader>


        <AppSectionCard>
            <div class="relative max-w-xl">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground/50">
                    <Search class="size-4" />
                </span>
                <input
                    v-model="search"
                    type="text"
                    placeholder="Buscar por cliente, DNI o número de pedido..."
                    class="w-full h-12 pl-12 pr-4 py-2 text-sm rounded-2xl border-border bg-background/50 text-foreground focus:ring-2 focus:ring-primary/40 outline-none transition"
                />
            </div>
        </AppSectionCard>


        <AppSectionCard fill noPadding title="Historial de Transacciones">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border text-sm text-left border-collapse">
                    <thead class="bg-muted/40 text-muted-foreground font-black uppercase text-[10px] tracking-[0.2em] border-b border-border">
                        <tr>
                            <th class="px-8 py-5">Orden / Fecha</th>
                            <th class="px-8 py-5">Cliente</th>
                            <th class="px-8 py-5 text-center">Logística</th>
                            <th class="px-8 py-5 text-right">Monto Total</th>
                            <th class="px-8 py-5 text-center">Estado</th>
                            <th class="px-8 py-5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50 text-foreground">
                        <tr v-if="pedidos.data.length === 0">
                            <td colspan="6" class="py-32 text-center text-muted-foreground italic">
                                <ShoppingBag class="size-12 mx-auto mb-4 opacity-10" />
                                <p>No se han registrado pedidos todavía.</p>
                            </td>
                        </tr>
                        <tr v-for="p in pedidos.data" :key="p.id" class="hover:bg-primary/2 transition-colors group">

                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-black text-primary text-sm tracking-tighter">#{{ String(p.id).padStart(6, '0') }}</span>
                                    <div class="flex items-center gap-1.5 text-muted-foreground text-[10px] font-bold mt-1">
                                        <Clock class="size-3" /> {{ new Date(p.created_at).toLocaleDateString() }}
                                    </div>
                                </div>
                            </td>


                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-lg bg-navy-900 border border-white/5 flex items-center justify-center font-black text-primary text-[10px]">
                                        {{ p.cliente.nombres[0] }}{{ p.cliente.apellidos[0] }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-foreground uppercase text-xs">{{ p.cliente.apellidos }}, {{ p.cliente.nombres }}</span>
                                        <span class="text-[10px] text-muted-foreground font-mono">DNI: {{ p.cliente.dni }}</span>
                                    </div>
                                </div>
                            </td>


                            <td class="px-8 py-6 text-center">
                                <div v-if="p.sede" class="inline-flex items-center gap-2 px-2.5 py-1 bg-blue-500/10 text-blue-500 rounded-full border border-blue-500/20">
                                    <MapPin class="size-3" />
                                    <span class="text-[9px] font-black uppercase tracking-tighter">Recojo: {{ p.sede.nombre }}</span>
                                </div>
                                <div v-else class="inline-flex items-center gap-2 px-2.5 py-1 bg-orange-500/10 text-orange-500 rounded-full border border-orange-500/20">
                                    <Truck class="size-3" />
                                    <span class="text-[9px] font-black uppercase tracking-tighter">Delivery a Domicilio</span>
                                </div>
                            </td>


                            <td class="px-8 py-6 text-right font-black text-white text-base italic">
                                {{ formatCurrency(p.total) }}
                            </td>


                            <td class="px-8 py-6 text-center">
                                <AppStatusBadge :status="p.estado.nombre" />
                            </td>


                            <td class="px-8 py-6 text-right">
                                <Link 
                                    :href="WebPedidoController.show.url(p.id)"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary text-primary-foreground hover:opacity-90 transition-all text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary/20"
                                >
                                    <ArrowUpRight class="size-3" /> Ver Detalle
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <template #footer>
                <div class="flex items-center justify-between">
                    <span class="text-[9px] font-black uppercase tracking-widest text-muted-foreground">
                        Sincronizado con Almacén Central
                    </span>
                    <div class="flex gap-2">
                        <template v-for="link in pedidos.links" :key="link.label">
                            <Link 
                                v-if="link.url"
                                :href="link.url"
                                v-html="mapearLabelPaginacion(link.label)"
                                :class="[
                                    'px-3 py-1.5 rounded-lg text-xs font-black transition-all border',
                                    link.active ? 'bg-primary border-primary text-white' : 'bg-background border-border text-muted-foreground hover:bg-muted'
                                ]"
                            />
                        </template>
                    </div>
                </div>
            </template>
        </AppSectionCard>

    </AppPageShell>
</template>