<script setup lang="ts">
import { router, Head } from '@inertiajs/vue3'
import { 
    ShoppingBag, User, MapPin, Truck, 
    Calendar, Package, CreditCard, Hash,
    ArrowLeft, CheckCircle2, AlertCircle
} from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppStatusBadge from '@/components/app/AppStatusBadge.vue'
import AppDetailItem from '@/components/app/AppDetailItem.vue'
import AppWatermark from '@/components/app/AppWatermark.vue'

import * as WebPedidoController from '@/actions/App/Http/Controllers/Admin/WebPedidoController'

const props = defineProps<{
    pedido: any
    estados: any[]
}>()

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Gestión Comercial', href: '#' },
            { title: 'Pedidos', href: WebPedidoController.index.url() },
            { title: 'Detalle de Orden', href: '#' },
        ],
    },
});

const updateStatus = (estadoId: number) => {
    router.patch(WebPedidoController.updateStatus.url(props.pedido.id), {
        estado_id: estadoId
    }, { preserveScroll: true });
}

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(value);
}
</script>

<template>
    <Head :title="'Pedido #' + pedido.id" />

    <AppPageShell :title="'Orden #' + String(pedido.id).padStart(6, '0')" variant="wide">
        
        <AppPageHeader 
            title="Detalle del Pedido" 
            :subtitle="'Recibido el ' + new Date(pedido.created_at).toLocaleString()"
            :backUrl="WebPedidoController.index.url()"
        >
            <template #actions>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-black uppercase text-muted-foreground mr-2">Cambiar Estado:</span>
                    <button 
                        v-for="est in estados" 
                        :key="est.id"
                        @click="updateStatus(est.id)"
                        :class="[
                            'px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-tighter transition-all border',
                            pedido.estado_id === est.id 
                                ? 'bg-primary border-primary text-white shadow-lg' 
                                : 'bg-navy-900/50 border-white/5 text-muted-foreground hover:border-primary/40'
                        ]"
                    >
                        {{ est.nombre }}
                    </button>
                </div>
            </template>
        </AppPageHeader>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            

            <div class="lg:col-span-8 space-y-6">
                
                <AppSectionCard noPadding title="Productos Solicitados">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-muted/10 text-[9px] font-black uppercase text-muted-foreground/60 tracking-widest border-b border-border/50">
                            <tr>
                                <th class="px-6 py-4">Ítem / SKU Técnico</th>
                                <th class="px-6 py-4 text-center">Cant.</th>
                                <th class="px-6 py-4 text-right">Unitario</th>
                                <th class="px-6 py-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/30">
                            <tr v-for="item in pedido.detalles" :key="item.id" class="group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="size-10 rounded-lg bg-navy-950 border border-white/5 overflow-hidden shrink-0">
                                            <img v-if="item.producto.imagen_url" :src="item.producto.imagen_url" class="object-cover w-full h-full" />
                                            <Package v-else class="m-2 text-white/10" />
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-white uppercase text-xs">{{ item.producto.nombre_comercial }}</span>
                                            <span class="text-[10px] text-primary font-mono font-bold tracking-tighter">
                                                SKU: {{ item.sku_producto }} 
                                                <span class="text-muted-foreground font-normal ml-1">({{ item.producto.maestro.nombre_tecnico }})</span>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center font-black text-white">x{{ item.cantidad }}</td>
                                <td class="px-6 py-4 text-right text-muted-foreground">{{ formatCurrency(item.precio_unitario) }}</td>
                                <td class="px-6 py-4 text-right font-black text-primary">{{ formatCurrency(item.subtotal) }}</td>
                            </tr>
                        </tbody>
                    </table>


                    <div class="bg-navy-900/30 p-8 border-t border-border/50">
                        <div class="flex flex-col items-end gap-2">
                            <div class="flex justify-between w-full max-w-50 text-xs">
                                <span class="text-muted-foreground uppercase font-bold">Subtotal:</span>
                                <span class="text-white font-mono">{{ formatCurrency(pedido.subtotal) }}</span>
                            </div>
                            <div class="flex justify-between w-full max-w-50 text-xs">
                                <span class="text-muted-foreground uppercase font-bold">IGV (18%):</span>
                                <span class="text-white font-mono">{{ formatCurrency(pedido.impuesto) }}</span>
                            </div>
                            <div class="flex justify-between w-full max-w-62.5 mt-4 pt-4 border-t border-primary/20">
                                <span class="text-primary font-black uppercase tracking-widest">Total Pagado:</span>
                                <span class="text-2xl font-black text-gold-500 font-mono">{{ formatCurrency(pedido.total) }}</span>
                            </div>
                        </div>
                    </div>
                </AppSectionCard>

                <div class="p-4 bg-primary/5 rounded-2xl border border-primary/10 flex items-center gap-4">
                    <AlertCircle class="size-5 text-primary" />
                    <p class="text-xs text-primary/80 italic">
                        Verifique que los lotes en el Almacén Central coincidan con los SKUs listados antes de procesar el envío.
                    </p>
                </div>
            </div>


            <div class="lg:col-span-4 space-y-6">
                

                <AppSectionCard title="Cliente Activo">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="size-12 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center font-black text-primary">
                            {{ pedido.cliente.nombres[0] }}{{ pedido.cliente.apellidos[0] }}
                        </div>
                        <div class="flex flex-col">
                            <span class="font-black text-white uppercase text-sm leading-tight">{{ pedido.cliente.nombres }} {{ pedido.cliente.apellidos }}</span>
                            <span class="text-[10px] text-muted-foreground font-mono">DNI: {{ pedido.cliente.dni }}</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <AppDetailItem label="Correo Electrónico" :value="pedido.cliente.email" />
                        <AppDetailItem label="Teléfono de Contacto" :value="pedido.cliente.telefono || 'No registrado'" />
                    </div>
                </AppSectionCard>


                <AppSectionCard class="relative overflow-hidden">
                    <AppWatermark :text="pedido.sede ? 'RECOJO' : 'DELIV'" />
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-primary mb-4 flex items-center gap-2">
                        <MapPin class="size-4" /> Información de Entrega
                    </h3>


                    <div v-if="pedido.sede" class="space-y-4 relative z-10">
                        <div class="p-3 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                            <p class="text-[9px] font-black text-blue-400 uppercase mb-1">Punto de Recojo Autorizado</p>
                            <p class="text-sm font-bold text-white">{{ pedido.sede.nombre }}</p>
                        </div>
                        <AppDetailItem label="Dirección de Sede" :value="pedido.sede.direccion" />
                    </div>


                    <div v-else class="space-y-4 relative z-10">
                        <div class="p-3 bg-orange-500/10 border border-orange-500/20 rounded-xl">
                            <p class="text-[9px] font-black text-orange-400 uppercase mb-1">Envío a Domicilio</p>
                            <p class="text-sm font-bold text-white">Puerta a Puerta</p>
                        </div>

                        <div v-if="pedido.cliente.direcciones && pedido.cliente.direcciones.length > 0">
                            <p class="text-xs text-white leading-relaxed">{{ pedido.cliente.direcciones[0].direccion_completa }}</p>
                            <p class="text-[10px] text-muted-foreground uppercase">{{ pedido.cliente.direcciones[0].distrito }}, {{ pedido.cliente.direcciones[0].ciudad }}</p>
                        </div>
                    </div>
                </AppSectionCard>

            </div>
        </div>
    </AppPageShell>
</template>