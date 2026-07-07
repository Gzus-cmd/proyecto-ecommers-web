<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head, useForm, Link } from '@inertiajs/vue3'
import { 
    Save, ArrowLeft, Image as ImageIcon, Sparkles, 
    AlertTriangle, CheckCircle2, Search, X, Calendar,
    Database, Layers, MousePointerClick
} from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'

import * as WebBannerController from '@/actions/App/Http/Controllers/Admin/WebBannerController'

const props = defineProps<{
    banner: any
    categorias: any[]
    productosGrouped: Record<string, any[]>
}>()


const LIMITS = {
    width: { min: 1100, ideal: 1200, max: 1350 },
    height: { min: 450, ideal: 500, max: 550 },
    maxSizeMB: 2,
    chars: { titulo: 45, desc: 120 } 
}

const form = useForm({
    producto_sku: props.banner.producto_sku,
    producto_nombre: props.banner.producto.nombre_comercial, 
    titulo: props.banner.titulo,
    descripcion: props.banner.descripcion,
    imagen: null as File | null,
    fecha_fin: props.banner.fecha_fin ? props.banner.fecha_fin.split('T')[0] : ''
})


const showModal = ref(false)
const categoriaSeleccionada = ref(props.categorias[0]?.slug || '')

const productosFiltrados = computed(() => {
    return props.productosGrouped[categoriaSeleccionada.value] || []
})

const seleccionarProducto = (p: any) => {
    form.producto_sku = p.sku
    form.producto_nombre = p.nombre_comercial
    showModal.value = false
}


const imagePreview = ref<string | null>(props.banner.imagen_url)
const uploadError = ref<string | null>(null)

const handleImageUpload = (e: any) => {
    const file = e.target.files[0]
    if (!file) return

    if (file.size / (1024 * 1024) > LIMITS.maxSizeMB) {
        uploadError.value = `Archivo muy pesado. Máximo: ${LIMITS.maxSizeMB}MB.`; return
    }

    const img = new Image()
    img.src = URL.createObjectURL(file)
    img.onload = () => {
        if (img.width >= LIMITS.width.min && img.height >= LIMITS.height.min) {
            uploadError.value = null
            form.imagen = file
            imagePreview.value = img.src
        } else {
            uploadError.value = `Imagen pequeña: ${img.width}x${img.height}px. Mínimo: 1200x500px.`;
            form.imagen = null
        }
    }
}

const submit = () => {
    form.post(WebBannerController.update.url(props.banner.id), {
        forceFormData: true, 
        preserveScroll: true,
        onSuccess: () => {

        }
    });
}
</script>

<template>
    <Head title="Editar Promoción" />

    <AppPageShell title="Marketing Digital">
        <form @submit.prevent="submit" class="max-w-7xl mx-auto space-y-8 pb-20 px-6">
            

            <AppSectionCard title="Campaña de Producto" subtitle="Vincule la promoción a un producto con stock crítico">
                <div class="py-2">
                    <button 
                        type="button"
                        @click="showModal = true"
                        class="w-full h-20 bg-navy-900/40 border border-white/10 rounded-4xl flex items-center justify-between px-8 hover:border-primary/50 hover:bg-primary/5 transition-all group"
                    >
                        <div class="flex items-center gap-6">
                            <div class="p-3 bg-primary/10 rounded-xl text-primary group-hover:scale-110 transition-transform">
                                <Database class="size-6" />
                            </div>
                            <div class="text-left">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-primary/60 mb-1">Producto Vinculado</p>
                                <p class="text-lg font-bold text-white leading-none tracking-tighter">
                                    {{ form.producto_nombre }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 text-muted-foreground group-hover:text-primary transition-colors italic">
                            <span class="text-[9px] font-black uppercase tracking-widest">Cambiar</span>
                            <MousePointerClick class="size-4" />
                        </div>
                    </button>
                </div>
            </AppSectionCard>


            <AppSectionCard title="Diseño Gráfico" subtitle="La imagen debe ser nítida y de alta resolución">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 py-4">
                    

                    <div class="lg:col-span-7 space-y-6">
                        <label class="relative block group cursor-pointer">
                            <div 
                                :class="['aspect-12/5 rounded-[2.5rem] border-2 border-dashed flex flex-col items-center justify-center transition-all overflow-hidden shadow-xl', 
                                uploadError ? 'border-red-500 bg-red-500/5' : 'border-white/10 bg-navy-900/60 hover:border-primary/40']"
                            >
                                <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                    <p class="text-white font-black uppercase tracking-widest text-[10px] bg-navy-950 px-4 py-2 rounded-full border border-white/10">Cambiar Arte Visual</p>
                                </div>
                            </div>
                            <input type="file" @change="handleImageUpload" class="hidden" accept="image/*" />
                        </label>
                        
                        <div v-if="uploadError" class="p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex items-center gap-4">
                            <AlertTriangle class="size-5 text-red-500" />
                            <p class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ uploadError }}</p>
                        </div>
                    </div>


                    <div class="lg:col-span-5 flex flex-col justify-center space-y-8">
                        <div>
                            <label class="text-[11px] font-black uppercase text-primary mb-5 block italic opacity-70">
                                Título de la Campaña
                            </label>
                            <input 
                                v-model="form.titulo" 
                                type="text" 
                                class="w-full bg-navy-950 border-white/10 rounded-2xl h-16 px-8 text-lg font-black focus:ring-primary text-white shadow-inner uppercase tracking-tighter" 
                            />
                            <div class="flex justify-end mt-2">
                                <span 
                                    class="text-[10px] font-black uppercase tracking-widest transition-colors"
                                    :class="form.titulo.length > 45 ? 'text-red-500' : 'text-muted-foreground/40'"
                                >
                                    {{ form.titulo.length }} / 45
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-primary mb-3 block italic">Descripción Comercial</label>
                            <textarea v-model="form.descripcion" rows="3" :maxlength="LIMITS.chars.desc"
                                class="w-full bg-navy-950 border-white/10 rounded-[1.2rem] p-5 text-sm font-medium leading-relaxed focus:ring-primary text-white shadow-inner"></textarea>
                            <div class="flex justify-end mt-1.5"><span class="text-[9px] font-black text-muted-foreground/30 uppercase">{{ form.descripcion.length }}/{{ LIMITS.chars.desc }}</span></div>
                        </div>
                    </div>
                </div>
            </AppSectionCard>


            <AppSectionCard title="Configuración de Vigencia">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-10 py-2">
                    <div class="w-full lg:w-96">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-primary mb-3 block items-center gap-2 italic">
                            <Calendar class="size-4" /> Fecha de Finalización
                        </label>
                        <input v-model="form.fecha_fin" type="date" required
                            class="w-full bg-navy-950 border-white/10 rounded-xl h-12 px-6 text-sm font-bold text-white focus:ring-amber-500" />
                    </div>

                    <div class="flex items-center gap-8">
                        <Link :href="WebBannerController.index.url()" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground hover:text-white transition-all underline underline-offset-8">
                            Cancelar
                        </Link>
                        <button 
                            type="submit" 
                            :disabled="form.processing || !!uploadError" 
                            class="bg-primary text-primary-foreground h-14 px-12 rounded-xl font-black uppercase text-[10px] tracking-[0.3em] flex items-center gap-3 shadow-xl hover:scale-105 active:scale-95 transition-all disabled:opacity-20"
                        >
                            <Save class="size-4" /> Guardar Cambios
                        </button>
                    </div>
                </div>
            </AppSectionCard>
        </form>



        <div v-if="showModal" class="fixed inset-0 z-200 flex items-center justify-center p-4 md:p-8 bg-black/95 backdrop-blur-xl">
            <div class="bg-navy-950 w-full max-w-6xl max-h-[90vh] rounded-[2.5rem] border border-white/10 shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in duration-300">
                

                <div class="px-10 py-8 border-b border-white/5 flex justify-between items-center bg-navy-900/40">
                    <div class="flex items-center gap-5">
                        <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                            <Sparkles class="size-6" />
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white uppercase italic tracking-tighter leading-none mb-1">Estrategia FEFO Inteligente</h3>
                            <p class="text-[10px] text-muted-foreground uppercase font-bold tracking-widest opacity-60">Seleccione productos con vencimiento próximo</p>
                        </div>
                    </div>
                    <button @click="showModal = false" class="size-10 bg-white/5 rounded-full flex items-center justify-center hover:bg-red-500/20 transition-all group">
                        <X class="size-5 text-white group-hover:rotate-90 transition-transform" />
                    </button>
                </div>

                <div class="flex flex-1 min-h-0">

                    <div class="w-64 border-r border-white/5 p-6 bg-navy-900/50 flex flex-col gap-6">
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-primary/60 italic px-2">Categorías</p>
                        <div class="space-y-1.5 overflow-y-auto custom-scrollbar pr-2">
                            <button 
                                v-for="cat in categorias" :key="cat.id"
                                @click="categoriaSeleccionada = cat.slug"
                                :class="['w-full text-left px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all', 
                                categoriaSeleccionada === cat.slug ? 'bg-primary text-primary-foreground shadow-lg translate-x-1' : 'text-muted-foreground hover:bg-white/5 hover:text-white']"
                            >
                                {{ cat.nombre }}
                            </button>
                        </div>
                    </div>


                    <div class="flex-1 p-8 overflow-y-auto custom-scrollbar bg-navy-950/20">
                        <div v-if="productosFiltrados.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div v-for="p in productosFiltrados" :key="p.sku" 
                                @click="seleccionarProducto(p)"
                                class="p-5 bg-navy-900 border border-white/5 rounded-2xl hover:border-primary/50 cursor-pointer transition-all group flex flex-col justify-between hover:shadow-xl hover:-translate-y-1"
                            >
                                <div>
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="px-2 py-0.5 bg-amber-500 text-navy-950 text-[8px] font-black rounded uppercase flex items-center gap-1 shadow-lg shadow-amber-500/10">
                                            <AlertTriangle class="size-3" /> CRÍTICO
                                        </span>
                                        <div class="text-right">
                                            <p class="text-[7px] font-black text-muted-foreground uppercase opacity-40 leading-none">Expiración</p>
                                            <p class="text-[10px] font-mono text-white font-bold">{{ p.fecha_vence }}</p>
                                        </div>
                                    </div>

                                    <h4 class="text-sm font-black text-white uppercase italic leading-snug group-hover:text-primary transition-colors tracking-tight line-clamp-2">
                                        {{ p.nombre_comercial }}
                                    </h4>
                                    <p class="text-[9px] font-bold text-muted-foreground/50 tracking-widest uppercase mt-1">Ref: {{ p.sku }}</p>
                                </div>

                                <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-[8px] font-black text-muted-foreground uppercase opacity-30 tracking-widest">Stock Web</span>
                                        <span class="text-xs font-black text-white">{{ p.stock_total }} uds.</span>
                                    </div>
                                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center opacity-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-300">
                                        <Layers class="size-4 text-primary" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div v-else class="flex flex-col items-center justify-center py-20 opacity-10">
                            <ImageIcon class="size-20 mb-4" />
                            <p class="text-xs font-black uppercase tracking-[0.4em]">Sin productos críticos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppPageShell>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 3px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: var(--primary); }

input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
    opacity: 0.5;
    cursor: pointer;
    transform: scale(1.4);
}
</style>