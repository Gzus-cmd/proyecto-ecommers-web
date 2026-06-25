<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Trash2, Edit3, FlaskConical, Package, Info, DollarSign, Globe } from 'lucide-vue-next'
import { ref } from 'vue'

import AppLayout from '@/layouts/AppLayout.vue'
import AppDetailItem from '@/components/app/AppDetailItem.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppStatusBadge from '@/components/app/AppStatusBadge.vue'
import AppWatermark from '@/components/app/AppWatermark.vue'
import * as WebProductoController from '@/actions/App/Http/Controllers/Admin/WebProductoController'

const props = defineProps<{ producto: any }>()
</script>

<template>
    <Head :title="producto.nombre_comercial" />

    <AppPageShell :title="producto.nombre_comercial" variant="wide">
        
        <AppPageHeader 
            title="Detalle del Producto Web" 
            :backUrl="WebProductoController.index.url()"
        >
            <template #actions>
                <Link :href="WebProductoController.edit.url(props.producto.sku)" 
                      class="bg-amber-500/10 text-amber-600 border border-amber-500/20 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-500 hover:text-white transition-all flex items-center gap-2">
                    <Edit3 class="size-3.5" /> Editar Publicación
                </Link>
            </template>
        </AppPageHeader>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            

            <div class="lg:col-span-8 space-y-6">
                <AppSectionCard class="relative overflow-hidden">
                    <AppWatermark text="E-COMM" />
                    
                    <div class="relative z-10 flex flex-col md:flex-row gap-8">

                        <div class="w-full md:w-1/3">
                            <div class="aspect-square rounded-2xl border border-border bg-muted/20 overflow-hidden shadow-inner flex items-center justify-center">
                                <img v-if="producto.imagen_url" :src="producto.imagen_url" class="object-cover w-full h-full" />
                                <Package v-else class="size-16 text-muted-foreground/20" />
                            </div>
                        </div>


                        <div class="flex-1">
                            <div class="flex gap-2 mb-4">
                                <AppStatusBadge :status="producto.disponible" />
                                <AppStatusBadge v-if="producto.requiere_receta" status="Sí" />
                            </div>

                            <h1 class="text-4xl font-black text-foreground uppercase tracking-tighter leading-none mb-2">
                                {{ producto.nombre_comercial }}
                            </h1>
                            <p class="text-lg text-primary font-bold italic mb-6">
                                {{ producto.nombre_generico }}
                            </p>

                            <div class="grid grid-cols-2 gap-6 border-t border-border/50 pt-6">
                                <AppDetailItem label="SKU de Trazabilidad" :value="producto.sku" mono highlight />
                                <AppDetailItem label="Precio en Tienda" highlight>
                                    <span class="text-2xl font-black text-gold-500">S/ {{ producto.precio_web }}</span>
                                </AppDetailItem>
                            </div>
                        </div>
                    </div>
                </AppSectionCard>


                <AppSectionCard v-if="producto.descripcion">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-4 flex items-center gap-2">
                        <Globe class="size-4" /> Descripción Comercial
                    </h3>
                    <p class="text-foreground/80 leading-relaxed text-sm bg-muted/5 p-4 rounded-xl border border-border/50">
                        {{ producto.descripcion }}
                    </p>
                </AppSectionCard>
            </div>


            <div class="lg:col-span-4 space-y-6">
                <AppSectionCard title="Ficha Técnica (Central)">
                    <div class="space-y-4">
                        <AppDetailItem label="Nombre Técnico" :value="producto.maestro.nombre_tecnico" />
                        <AppDetailItem label="Principio Activo" :value="producto.maestro.principio_activo" />
                        <AppDetailItem label="Categoría Central" :value="producto.maestro.categoria" />
                        <div class="grid grid-cols-2 gap-4">
                            <AppDetailItem label="Concentración" :value="producto.concentracion" />
                            <AppDetailItem label="Forma" :value="producto.forma_farmaceutica" />
                        </div>
                    </div>
                </AppSectionCard>

                <AppSectionCard noPadding title="Stock en Almacén">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-muted/10 text-[9px] font-black uppercase text-muted-foreground/60 tracking-widest border-b border-border/50">
                            <tr>
                                <th class="px-6 py-4">Lote / Vencimiento</th>
                                <th class="px-6 py-4 text-right">Cant.</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/30">
                            <tr v-for="lote in producto.maestro.lotes" :key="lote.id">
                                <td class="px-6 py-4">
                                    <div class="font-mono font-bold">{{ lote.numero_lote }}</div>
                                    <div class="text-[9px] opacity-50">{{ lote.fecha_vencimiento }}</div>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-primary">
                                    {{ lote.cantidad_actual }} uds.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </AppSectionCard>
            </div>
        </div>
    </AppPageShell>
</template>