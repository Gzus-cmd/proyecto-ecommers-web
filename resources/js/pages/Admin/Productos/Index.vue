<script setup lang="ts">
import { router, Link, Head } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import debounce from 'lodash/debounce'
import { 
    Search, Plus, Edit3, Trash2, 
    Eye, Info, FlaskConical, PackageSearch, 
    ExternalLink, AlertCircle 
} from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppStatusBadge from '@/components/app/AppStatusBadge.vue'
import AppDetailItem from '@/components/app/AppDetailItem.vue'
import DeleteConfirmModal from '@/components/DeleteConfirmModal.vue'

import * as WebProductoController from '@/actions/App/Http/Controllers/Admin/WebProductoController'


defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Tienda Online', href: '#' },
            { title: 'Catálogo de Productos', href: '#' },
        ],
    },
});

const props = defineProps<{
    productos: any[]
    filters: { search?: string }
}>()


const search = ref(props.filters?.search ?? '')
const eliminando = ref(false)


const mostrarModalEliminar = ref(false)
const mostrarModalTecnico = ref(false)


const productoSeleccionado = ref<any>(null)
const maestroSeleccionado = ref<any>(null)


const applyFilters = () => {
    router.get(
        WebProductoController.index.url(),
        { search: search.value },
        { preserveState: true, replace: true }
    )
}
watch(search, debounce(() => applyFilters(), 400))


const verFichaTecnica = (p: any) => {
    maestroSeleccionado.value = p.maestro;
    mostrarModalTecnico.value = true;
};

const abrirModalEliminar = (p: any) => {
    productoSeleccionado.value = p;
    mostrarModalEliminar.value = true;
};

const confirmarEliminacion = () => {
    if (!productoSeleccionado.value) return;
    
    eliminando.value = true;
    router.delete(WebProductoController.destroy.url(productoSeleccionado.value.sku), {
        onSuccess: () => {
            mostrarModalEliminar.value = false;
        },
        onFinish: () => {
            eliminando.value = false;
            productoSeleccionado.value = null;
        }
    });
};
</script>

<template>
    <Head title="Catálogo Web" />

    <AppPageShell title="Gestión de Catálogo Web" variant="full">

       
        <AppPageHeader 
            title="Productos en Tienda" 
            :subtitle="`Administre la visibilidad y precios de ${productos.length} productos publicados.`"
        >
            <template #actions>
                <Link
                    :href="WebProductoController.create.url()"
                    class="bg-primary text-primary-foreground px-6 py-2.5 rounded-xl font-black shadow-lg hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2 text-xs uppercase tracking-widest"
                >
                    <Plus class="size-4" /> Vincular desde Central
                </Link>
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
                    placeholder="Buscar por nombre comercial, genérico o SKU..."
                    class="w-full h-12 pl-12 pr-4 py-2 text-sm rounded-2xl border-border bg-background/50 text-foreground focus:ring-2 focus:ring-primary/40 outline-none transition shadow-inner"
                />
            </div>
        </AppSectionCard>

        
        <AppSectionCard fill noPadding title="Listado de Productos Publicados">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border text-sm text-left border-collapse">
                    <thead class="bg-muted/40 text-muted-foreground font-black uppercase text-[10px] tracking-[0.2em] border-b border-border">
                        <tr>
                            <th class="px-8 py-5">Producto / SKU</th>
                            <th class="px-8 py-5 text-center">Ficha Técnica (Central)</th>
                            <th class="px-8 py-5 text-right">Precio Web</th>
                            <th class="px-8 py-5 text-center">Stock Disponible</th>
                            <th class="px-8 py-5 text-center">Estado</th>
                            <th class="px-8 py-5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50 text-foreground">
                        <tr v-if="productos.length === 0">
                            <td colspan="6" class="py-32 text-center">
                                <PackageSearch class="size-12 mx-auto mb-4 opacity-10" />
                                <p class="text-muted-foreground font-medium italic">No se encontraron productos vinculados.</p>
                            </td>
                        </tr>
                        <tr v-for="p in productos" :key="p.sku" class="hover:bg-primary/2 transition-colors group">
                           
                            <td class="px-8 py-6">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-black text-foreground text-sm uppercase tracking-tighter group-hover:text-primary transition-colors">
                                        {{ p.nombre_comercial }}
                                    </span>
                                    <span class="font-mono text-[10px] text-muted-foreground bg-muted w-fit px-1.5 rounded border border-border/50">
                                        {{ p.sku }}
                                    </span>
                                </div>
                            </td>

                          
                            <td class="px-8 py-6 text-center">
                                <button @click="verFichaTecnica(p)" class="group/btn">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-navy-900/40 rounded-xl border border-white/5 group-hover/btn:border-primary/50 transition-all">
                                        <span class="text-[10px] text-white/60 font-bold italic group-hover/btn:text-primary">
                                            {{ p.maestro.nombre_tecnico }}
                                        </span>
                                        <Info class="size-3 text-primary/30 group-hover/btn:text-primary" />
                                    </div>
                                </button>
                            </td>

                           
                            <td class="px-8 py-6 text-right font-black text-primary text-base italic">
                                S/ {{ p.precio_web }}
                            </td>

                            
                            <td class="px-8 py-6 text-center">
                                <div class="flex flex-col items-center">
                                    <span :class="['font-black text-sm', p.maestro.stock_total > 10 ? 'text-emerald-500' : 'text-red-500']">
                                        {{ p.maestro.stock_total }}
                                    </span>
                                    <span class="text-[8px] uppercase font-black opacity-40 tracking-widest">unidades</span>
                                </div>
                            </td>

                            
                            <td class="px-8 py-6 text-center">
                                <AppStatusBadge :status="p.disponible" />
                            </td>

                            
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end gap-5">
                                  
                                    <Link 
                                        :href="WebProductoController.show.url(p.sku)"
                                        class="p-2 hover:bg-primary/10 rounded-lg text-muted-foreground hover:text-primary transition-colors"
                                        title="Ver Ficha Completa"
                                    >
                                        <Eye class="size-4" />
                                    </Link>

                                    
                                    <Link 
                                        :href="WebProductoController.edit.url(p.sku)" 
                                        class="text-amber-500 font-black uppercase text-[10px] tracking-widest hover:underline flex items-center gap-1.5"
                                    >
                                        <Edit3 class="size-3.5" /> Editar
                                    </Link>
                                    
                                   
                                    <button 
                                        @click="abrirModalEliminar(p)"
                                        class="text-red-500 font-black uppercase text-[10px] tracking-widest hover:underline flex items-center gap-1.5"
                                    >
                                        <Trash2 class="size-3.5" /> Quitar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </AppSectionCard>


        <div v-if="mostrarModalTecnico && maestroSeleccionado" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div class="bg-card w-full max-w-lg rounded-3xl border border-border shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                <div class="p-6 border-b border-border bg-muted/20 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-primary/10 rounded-lg text-primary">
                            <FlaskConical class="size-5" />
                        </div>
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-foreground/80">Datos Técnicos de Central</h3>
                    </div>
                    <button @click="mostrarModalTecnico = false" class="text-muted-foreground hover:text-white transition-colors">✕</button>
                </div>
                <div class="p-8 space-y-8">
                    <AppDetailItem label="Nombre Oficial en Almacén" :value="maestroSeleccionado.nombre_tecnico" class="text-xl" highlight />
                    
                    <div class="grid grid-cols-2 gap-8 border-t border-border/40 pt-6">
                        <AppDetailItem label="Principio Activo" :value="maestroSeleccionado.principio_activo" />
                        <AppDetailItem label="Categoría" :value="maestroSeleccionado.categoria" />
                    </div>

                    <div class="p-4 bg-navy-950 rounded-2xl border border-primary/20 flex items-start gap-4">
                        <AlertCircle class="size-5 text-primary shrink-0 mt-0.5" />
                        <div>
                            <p class="text-[10px] font-black uppercase text-primary tracking-widest mb-1">Nota de Trazabilidad</p>
                            <p class="text-xs text-muted-foreground leading-relaxed">
                                Este registro comercial está vinculado permanentemente al SKU <span class="text-white font-bold">{{ maestroSeleccionado.sku }}</span>. Los cambios técnicos se gestionan desde el Almacén Central.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-muted/10 flex justify-end">
                    <button 
                        @click="mostrarModalTecnico = false" 
                        class="px-8 py-3 bg-foreground text-background rounded-xl font-black uppercase text-[10px] tracking-[0.2em] hover:opacity-90 transition-all"
                    >
                        Entendido
                    </button>
                </div>
            </div>
        </div>


        <DeleteConfirmModal 
            :show="mostrarModalEliminar"
            :itemName="productoSeleccionado?.nombre_comercial"
            type="publicación de la tienda"
            :processing="eliminando"
            @close="mostrarModalEliminar = false"
            @confirm="confirmarEliminacion"
        />

    </AppPageShell>
</template>