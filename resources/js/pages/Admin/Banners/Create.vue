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
    categorias: any[]
    productosGrouped: any 
}>()


const LIMITS = {
    minWidth: 1200,
    minHeight: 500,
    maxSizeMB: 2
}

const form = useForm({
    producto_sku: '',
    producto_nombre: '', 
    titulo: '',
    descripcion: '',
    imagen: null as File | null,
    fecha_fin: ''
})


const showModal = ref(false)

const categoriaSeleccionada = ref('')


if (props.categorias && props.categorias.length > 0) {
    categoriaSeleccionada.value = props.categorias[0].slug
}

const productosFiltrados = computed(() => {
    if (!props.productosGrouped || !categoriaSeleccionada.value) return []
    return props.productosGrouped[categoriaSeleccionada.value] || []
})

const seleccionarProducto = (p: any) => {
    form.producto_sku = p.sku
    form.producto_nombre = p.nombre_comercial
    showModal.value = false
}


const imagePreview = ref<string | null>(null)
const uploadError = ref<string | null>(null)

const handleImageUpload = (e: any) => {
    const file = e.target.files[0]
    if (!file) return
    if (file.size / (1024 * 1024) > LIMITS.maxSizeMB) {
        uploadError.value = `Máximo ${LIMITS.maxSizeMB}MB.`; resetImage(); return
    }
    const img = new Image()
    img.src = URL.createObjectURL(file)
    img.onload = () => {
        if (img.width >= LIMITS.minWidth && img.height >= LIMITS.minHeight) {
            uploadError.value = null; form.imagen = file; imagePreview.value = img.src
        } else {
            uploadError.value = `Mínimo 1200x500px requerido. Detectado: ${img.width}x${img.height}px`;
            resetImage()
        }
    }
}
const resetImage = () => { form.imagen = null; imagePreview.value = null }

const submit = () => {
    form.post(WebBannerController.store.url(), {
        forceFormData: true,
        onSuccess: () => form.reset()
    })
}
</script>

<template>
    <Head title="Nuevo Banner" />

    <AppPageShell title="Marketing Digital">
        <form @submit.prevent="submit" class="max-w-7xl mx-auto space-y-14 pb-32 px-6">
            

            <AppSectionCard title="Producto Vinculado" subtitle="Seleccione el producto del catálogo maestro">
                <div class="py-4">
                    <button 
                        type="button" @click="showModal = true"
                        class="w-full h-24 bg-navy-900/40 border-2 border-dashed border-white/10 rounded-[2.5rem] flex items-center justify-between px-10 hover:border-primary/50 hover:bg-primary/5 transition-all group"
                    >
                        <div class="flex items-center gap-8">
                            <div class="p-4 bg-primary/10 rounded-2xl text-primary group-hover:scale-110 transition-transform">
                                <Database class="size-8" />
                            </div>
                            <div class="text-left">
                                <p class="text-[11px] font-black uppercase tracking-[0.3em] text-primary/60 mb-1">Inventario Central</p>
                                <p class="text-xl font-bold text-white tracking-tight">
                                    {{ form.producto_nombre || 'Haga clic para seleccionar producto...' }}
                                </p>
                            </div>
                        </div>
                        <div v-if="form.producto_sku" class="flex items-center gap-4 bg-emerald-500/10 px-6 py-3 rounded-2xl border border-emerald-500/20">
                            <CheckCircle2 class="size-6 text-emerald-500" />
                        </div>
                        <MousePointerClick v-else class="size-6 text-muted-foreground opacity-30 group-hover:opacity-100" />
                    </button>
                </div>
            </AppSectionCard>


            <AppSectionCard title="Diseño Gráfico y Textos" subtitle="Configure el impacto visual del banner">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 py-8">
                    <div class="lg:col-span-6 space-y-6">
                        <label class="relative block group cursor-pointer">
                            <div :class="['aspect-12/5 rounded-[3.5rem] border-2 border-dashed flex flex-col items-center justify-center transition-all overflow-hidden shadow-2xl', uploadError ? 'border-red-500 bg-red-500/5' : 'border-white/10 bg-navy-900/60 hover:border-primary/40']">
                                <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover" />
                                <div v-else class="text-center p-12">
                                    <ImageIcon class="size-16 text-muted-foreground group-hover:text-primary mb-4 mx-auto" />
                                    <p class="text-base font-black text-white uppercase tracking-widest">Cargar Arte</p>
                                    <p class="text-[10px] text-muted-foreground uppercase opacity-40">Min 1200 x 500 px</p>
                                </div>
                            </div>
                            <input type="file" @change="handleImageUpload" class="hidden" accept="image/*" />
                        </label>
                        <div v-if="uploadError" class="p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex items-center gap-4 text-red-500">
                            <AlertTriangle class="size-5 shrink-0" />
                            <p class="text-sm font-bold uppercase">{{ uploadError }}</p>
                        </div>
                    </div>

                    <div class="lg:col-span-6 flex flex-col justify-center space-y-10">
                        <div>
                            <label class="text-[11px] font-black uppercase text-primary mb-4 block italic">Título Campaña (Máx 45)</label>
                            <input v-model="form.titulo" type="text" maxlength="45" class="w-full bg-navy-950 border-white/10 rounded-2xl h-16 px-8 text-xl font-black text-white focus:ring-primary uppercase tracking-tighter shadow-inner" />
                            <div class="flex justify-end mt-2"><span class="text-[10px] font-black text-muted-foreground/30 uppercase">{{ form.titulo.length }}/45</span></div>
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-primary mb-4 block italic">Descripción (Máx 120)</label>
                            <textarea v-model="form.descripcion" rows="4" maxlength="120" class="w-full bg-navy-950 border-white/10 rounded-[2.5rem] p-8 text-base text-white resize-none shadow-inner"></textarea>
                            <div class="flex justify-end mt-2"><span class="text-[10px] font-black text-muted-foreground/30 uppercase">{{ form.descripcion.length }}/120</span></div>
                        </div>
                    </div>
                </div>
            </AppSectionCard>


            <AppSectionCard title="Configuración de Salida">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-12 py-10">
                    <div class="w-full lg:w-112.5">
                        <label class="text-[11px] font-black uppercase text-primary mb-5 flex items-center gap-3 italic"><Calendar class="size-5" /> Fecha de Finalización</label>
                        <input v-model="form.fecha_fin" type="date" required class="w-full bg-navy-950 border-white/10 rounded-2xl h-16 px-10 text-lg font-black text-white focus:ring-amber-500 shadow-inner" />
                    </div>
                    <div class="flex items-center gap-12">
                        <Link :href="WebBannerController.index.url()" class="text-xs font-black uppercase text-muted-foreground hover:text-white transition-all underline underline-offset-12">Descartar</Link>
                        <button type="submit" :disabled="form.processing || !!uploadError || !form.producto_sku || !form.fecha_fin || !form.imagen" class="bg-primary text-primary-foreground px-20 h-20 rounded-[2.5rem] font-black uppercase text-xs tracking-[0.4em] flex items-center gap-5 shadow-[0_20px_50px_rgba(var(--primary-rgb),0.3)] hover:scale-105 active:scale-95 transition-all disabled:opacity-20 disabled:grayscale">
                            <Save class="size-6" /> Publicar Banner
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
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: var(--primary); }

input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
    opacity: 0.5;
    cursor: pointer;
    transform: scale(2);
    margin-right: 20px;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>