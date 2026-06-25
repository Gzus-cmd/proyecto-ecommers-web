<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { 
    User, Mail, Phone, CreditCard, 
    MapPin, ShoppingBag, Calendar,
    ChevronRight, ArrowLeft
} from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppStatusBadge from '@/components/app/AppStatusBadge.vue'
import AppDetailItem from '@/components/app/AppDetailItem.vue'
import AppWatermark from '@/components/app/AppWatermark.vue'

import * as WebClienteController from '@/actions/App/Http/Controllers/Admin/WebClienteController'

const props = defineProps<{ cliente: any }>()

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Gestión Comercial', href: '#' },
            { title: 'Clientes', href: WebClienteController.index.url() },
            { title: 'Perfil de Cliente', href: '#' },
        ],
    },
});
</script>

<template>
    <Head :title="'Cliente: ' + cliente.apellidos" />

    <AppPageShell :title="cliente.nombres + ' ' + cliente.apellidos" variant="wide">
        
        <AppPageHeader 
            title="Ficha del Cliente" 
            :subtitle="'Registrado desde el ' + cliente.fecha_registro"
            :backUrl="WebClienteController.index.url()"
        />

            <template #actions>
                <Link 
                    :href="WebClienteController.edit.url(cliente.id)"
                    class="bg-amber-500 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-amber-500/20 hover:bg-amber-600 transition-all flex items-center gap-2"
                >
                    <Edit3 class="size-3.5" /> Editar Perfil
                </Link>
            </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            

            <div class="lg:col-span-4 space-y-6">
                <AppSectionCard class="relative overflow-hidden">
                    <AppWatermark text="USER" />
                    
                    <div class="relative z-10 flex flex-col items-center text-center pb-6 border-b border-border/50">
                        <div class="size-24 rounded-full bg-navy-900 border-4 border-primary/20 flex items-center justify-center mb-4 shadow-2xl">
                            <span class="text-3xl font-black text-primary uppercase italic">
                                {{ cliente.nombres[0] }}{{ cliente.apellidos[0] }}
                            </span>
                        </div>
                        <AppStatusBadge :status="cliente.activo" />
                        <h2 class="mt-4 text-xl font-black text-white uppercase tracking-tighter">
                            {{ cliente.apellidos }}
                        </h2>
                        <p class="text-primary font-bold text-sm italic">{{ cliente.nombres }}</p>
                    </div>

                    <div class="pt-6 space-y-4">
                        <AppDetailItem label="Documento DNI" :value="cliente.dni" mono highlight />
                        <AppDetailItem label="Correo Electrónico" :value="cliente.email" />
                        <AppDetailItem label="Teléfono / Celular" :value="cliente.telefono" />
                    </div>
                </AppSectionCard>


                <AppSectionCard title="Direcciones de Entrega">
                    <div class="space-y-4">
                        <div v-for="dir in cliente.direcciones" :key="dir.id" 
                             class="p-4 rounded-xl bg-muted/20 border border-border/50 hover:border-primary/30 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[9px] font-black uppercase tracking-widest text-primary">{{ dir.alias }}</span>
                                <span v-if="dir.es_principal" class="text-[8px] bg-primary/20 text-primary px-2 py-0.5 rounded-full font-black uppercase">Principal</span>
                            </div>
                            <p class="text-xs text-white font-medium">{{ dir.direccion_completa }}</p>
                            <p class="text-[10px] text-muted-foreground mt-1">{{ dir.distrito }}, {{ dir.ciudad }}</p>
                        </div>
                        <div v-if="cliente.direcciones.length === 0" class="text-center py-4 text-muted-foreground italic text-xs uppercase">
                            Sin direcciones registradas
                        </div>
                    </div>
                </AppSectionCard>
            </div>


            <div class="lg:col-span-8 space-y-6">
                <AppSectionCard noPadding title="Historial de Pedidos Realizados">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-muted/10 text-[9px] font-black uppercase text-muted-foreground/60 tracking-widest border-b border-border/50">
                                <tr>
                                    <th class="px-6 py-4">ID Pedido</th>
                                    <th class="px-6 py-4">Fecha</th>
                                    <th class="px-6 py-4 text-center">Estado</th>
                                    <th class="px-6 py-4 text-right">Monto Total</th>
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border/30">
                                <tr v-for="pedido in cliente.pedidos" :key="pedido.id" class="hover:bg-primary/2 transition-colors group">
                                    <td class="px-6 py-4 font-mono font-black text-primary">#{{ String(pedido.id).padStart(6, '0') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-white font-bold">
                                            <Calendar class="size-3 text-muted-foreground" />
                                            {{ new Date(pedido.created_at).toLocaleDateString() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <AppStatusBadge :status="pedido.estado.nombre" />
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-white">
                                        S/ {{ pedido.total }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <Link href="#" class="text-muted-foreground hover:text-primary transition-colors">
                                            <ChevronRight class="size-4" />
                                        </Link>
                                    </td>
                                </tr>
                                <tr v-if="cliente.pedidos.length === 0">
                                    <td colspan="5" class="px-6 py-20 text-center text-muted-foreground italic uppercase text-xs tracking-widest">
                                        Este cliente aún no ha realizado pedidos
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </AppSectionCard>
            </div>
        </div>
    </AppPageShell>
</template>