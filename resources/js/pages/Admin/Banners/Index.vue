<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

import { 
    Plus, Trash2, Edit3, Calendar, 
    LayoutGrid, Image as ImageIcon, 
    AlertCircle, ShoppingBag, ExternalLink
} from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppStatusBadge from '@/components/app/AppStatusBadge.vue'
import DeleteConfirmModal from '@/components/DeleteConfirmModal.vue'

import * as WebBannerController from '@/actions/App/Http/Controllers/Admin/WebBannerController'

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Marketing', href: '#' },
            { title: 'Banners del Home', href: '#' },
        ],
    },
});

const props = defineProps<{
    banners: any[]
    canCreate: boolean
}>()

const bannerSeleccionado = ref<any>(null)
const mostrarModalEliminar = ref(false)
const eliminando = ref(false)

const abrirModalEliminar = (banner: any) => {
    bannerSeleccionado.value = banner;
    mostrarModalEliminar.value = true;
};

const confirmarEliminacion = () => {
    if (!bannerSeleccionado.value) return;
    eliminando.value = true;
    router.delete(WebBannerController.destroy.url(bannerSeleccionado.value.id), {
        onSuccess: () => { mostrarModalEliminar.value = false; },
        onFinish: () => { eliminando.value = false; bannerSeleccionado.value = null; }
    });
};


const formatDate = (dateString: string) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}
</script>

<template>
    <Head title="Gestión de Banners" />

    <AppPageShell title="Marketing y Promociones" variant="full">
        
        <AppPageHeader 
            title="Banners Publicitarios" 
            :subtitle="`Gestiona las ${banners.length} promociones activas en el carrusel principal.`"
        >
            <template #actions>
                <Link v-if="canCreate" :href="WebBannerController.create.url()"
                    class="bg-primary text-primary-foreground px-6 py-2.5 rounded-xl font-black shadow-lg hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2 text-xs uppercase tracking-widest"
                >
                    <Plus class="size-4" /> Nuevo Banner
                </Link>
                <div v-else class="flex items-center gap-2 px-4 py-2 bg-navy-900/50 rounded-xl border border-white/5 text-muted-foreground text-[10px] font-black uppercase">
                    <AlertCircle class="size-4 text-amber-500" /> Límite alcanzado
                </div>
            </template>
        </AppPageHeader>

        <AppSectionCard title="Carrusel Activo" subtitle="Vista previa de las campañas en el Home">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <div v-for="banner in banners" :key="banner.id" 
                    class="group bg-navy-950/40 border border-white/5 rounded-[2.5rem] overflow-hidden hover:border-primary/30 transition-all duration-500 shadow-2xl flex flex-col"
                >

                    <div class="relative h-56 overflow-hidden bg-navy-900">
                        <img :src="banner.imagen_url" class="w-full h-full object-cover opacity-50 group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-linear-to-t from-navy-950 via-transparent to-transparent"></div>
                        

                        <div class="absolute top-5 left-5 bg-primary text-primary-foreground px-3 py-1 rounded-lg shadow-lg">
                            <span class="text-[9px] font-black uppercase tracking-widest">Prioridad {{ banner.orden }}</span>
                        </div>
                    </div>


                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex justify-between items-start gap-6 mb-6">
                            <div class="flex-1">
                                <h3 class="text-xl font-black text-foreground uppercase italic tracking-tighter mb-2 group-hover:text-primary transition-colors">
                                    {{ banner.titulo }}
                                </h3>
                                <p class="text-xs text-muted-foreground line-clamp-2 leading-relaxed font-medium">
                                    {{ banner.descripcion }}
                                </p>
                            </div>
                            

                            <div class="flex gap-2 shrink-0">
                                <Link 
                                    :href="WebBannerController.edit.url(banner.id)"
                                    class="p-2.5 bg-amber-500/10 text-amber-500 rounded-xl hover:bg-amber-500 hover:text-navy-950 transition-all active:scale-90"
                                    title="Editar Campaña"
                                >
                                    <Edit3 class="size-5" />
                                </Link>
                                <button 
                                    @click="abrirModalEliminar(banner)" 
                                    class="p-2.5 bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all active:scale-90"
                                    title="Eliminar"
                                >
                                    <Trash2 class="size-5" />
                                </button>
                            </div>
                        </div>

                        <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-xl bg-navy-900 border border-white/5 flex items-center justify-center">
                                    <ShoppingBag class="size-5 text-primary/70" />
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[8px] uppercase font-black text-muted-foreground tracking-widest">Producto</span>
                                    <span class="text-[11px] font-bold text-foreground/90 uppercase tracking-tighter">{{ banner.producto.nombre_comercial }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col items-end">
                                <span class="text-[8px] uppercase font-black text-muted-foreground tracking-widest mb-1">Finaliza</span>
                                <div class="flex items-center gap-2 px-3 py-1 bg-navy-900 rounded-lg border border-white/5">
                                    <Calendar class="size-3 text-amber-500" />
                                    <span class="text-[10px] font-black text-foreground uppercase tracking-tighter">
                                        {{ formatDate(banner.fecha_fin) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppSectionCard>

        <DeleteConfirmModal 
            :show="mostrarModalEliminar"
            :itemName="bannerSeleccionado?.titulo"
            type="banner promocional"
            :processing="eliminando"
            @close="mostrarModalEliminar = false"
            @confirm="confirmarEliminacion"
        />

    </AppPageShell>
</template>