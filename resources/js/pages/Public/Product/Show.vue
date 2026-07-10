<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
    ShoppingCart, Truck, MapPin, 
    Plus, Minus, Info, ChevronRight 
} from 'lucide-vue-next';
import * as ProductController from '@/actions/App/Http/Controllers/Public/ProductController';

const props = defineProps<{
    producto: any;
    relacionados: any[];
}>();

const quantity = ref(1);
const activeTab = ref('description');

const formatCurrency = (val: number) => new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(val);
</script>

<template>
    <Head :title="`${producto.nombre_comercial} | PharmaVictoria`" />

    <div class="max-w-7xl mx-auto px-6 py-12">
        
        <!-- 1. BREADCRUMBS -->
        <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-12">
            <Link href="/" class="hover:text-pv-navy transition-colors">Inicio</Link>
            <span class="opacity-30">/</span>
            <Link href="/catalogo" class="hover:text-pv-navy transition-colors">Medicamentos</Link>
            <span class="opacity-30">/</span>
            <span class="text-pv-accent">{{ producto.categoria_nombre }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 mb-24">
            
            <!-- 2. VISUALIZACIÓN DE PRODUCTO -->
            <div class="lg:col-span-7">
                <div class="aspect-square bg-white rounded-[3.5rem] p-16 flex items-center justify-center border border-gray-100 shadow-xl shadow-pv-navy/5 relative overflow-hidden group">
                    <img :src="producto.imagen_url" class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-105" style="padding: 5%;" />
                    
                    <div v-if="producto.requiere_receta" class="absolute top-8 left-8 bg-red-500 text-white text-[9px] font-black px-5 py-2 rounded-full uppercase tracking-widest shadow-lg shadow-red-500/20">
                        Requiere Receta Médica
                    </div>
                </div>
            </div>

            <!-- 3. INFO Y COMPRA REFINADA -->
            <div class="lg:col-span-5 flex flex-col justify-center">
                <span class="text-pv-accent font-black uppercase text-[11px] tracking-[0.3em] mb-4">
                    {{ producto.nombre_generico }}
                </span>
                <h1 class="text-5xl font-black text-pv-navy leading-[1.1] mb-4 italic tracking-tighter">
                    {{ producto.nombre_comercial }}
                </h1>
                <p class="text-gray-400 font-bold text-xl mb-10">{{ producto.presentacion_web }}</p>

                <div class="flex items-baseline gap-4 mb-12">
                    <span class="text-6xl font-black text-pv-navy tracking-tighter">
                        {{ formatCurrency(producto.precio_web) }}
                    </span>
                    <span class="text-gray-400 text-xs font-black uppercase tracking-widest opacity-50">Incluye IGV</span>
                </div>

                <!-- CONTROLES DE COMPRA (Mejorado: Contraste y Escala) -->
                <div class="flex flex-col sm:flex-row items-center gap-6 mb-12">
                    
                    <!-- Selector de Cantidad Robusto -->
                    <div class="flex items-center bg-white border border-gray-200 rounded-2xl p-1 shadow-sm h-16 w-full sm:w-auto">
                        <button 
                            @click="quantity > 1 && quantity--" 
                            class="size-14 flex items-center justify-center hover:bg-gray-50 rounded-xl transition-all active:scale-90 text-pv-navy group"
                        >
                            <Minus class="size-4 group-hover:text-pv-accent" />
                        </button>
                        
                        <span class="w-14 text-center font-black text-2xl text-pv-navy tabular-nums">
                            {{ quantity }}
                        </span>
                        
                        <button 
                            @click="quantity++" 
                            class="size-14 flex items-center justify-center hover:bg-gray-50 rounded-xl transition-all active:scale-90 text-pv-navy group"
                        >
                            <Plus class="size-4 group-hover:text-pv-accent" />
                        </button>
                    </div>
                    
                    <!-- Botón Añadir al Carrito (Primario) -->
                    <button class="flex-1 w-full bg-[#072D44] text-white h-16 rounded-2xl font-black uppercase text-xs tracking-[0.2em] hover:bg-[#064469] transition-all shadow-2xl shadow-[#072D44]/30 active:scale-95 flex items-center justify-center gap-3">
                        <ShoppingCart class="size-5" />
                        Añadir al Carrito
                    </button>
                </div>

                <!-- INFO DE ENTREGA -->
                <div class="space-y-4 p-8 bg-gray-50/50 rounded-[2.5rem] border border-gray-100">
                    <div class="flex items-center gap-5">
                        <div class="size-10 bg-white rounded-xl flex items-center justify-center shadow-sm border border-gray-100">
                            <Truck class="size-5 text-pv-accent" />
                        </div>
                        <div>
                            <p class="text-xs font-black text-pv-navy uppercase tracking-widest">Envío a Domicilio</p>
                            <p class="text-[11px] text-gray-500 font-medium">Llega en 24 - 48 horas laborales.</p>
                        </div>
                    </div>
                    
                    <div class="h-px bg-gray-200/50 w-full"></div>
                    
                    <div class="flex items-center gap-5">
                        <div class="size-10 bg-white rounded-xl flex items-center justify-center shadow-sm border border-gray-100">
                            <MapPin class="size-5 text-pv-accent" />
                        </div>
                        <div>
                            <p class="text-xs font-black text-pv-navy uppercase tracking-widest">Recojo en Tienda</p>
                            <p v-if="producto.disponible_recojo" class="text-[11px] text-emerald-500 font-black uppercase">Disponible hoy en Sede Central</p>
                            <p v-else class="text-[11px] text-gray-400 font-medium">Consultar stock en sedes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. PESTAÑAS -->
        <div class="mb-32">
            <div class="flex border-b border-gray-100 mb-12 gap-12 overflow-x-auto no-scrollbar">
                <button v-for="tab in ['description', 'dosage', 'warnings', 'storage']" 
                        :key="tab"
                        @click="activeTab = tab"
                        :class="['pb-6 text-[10px] font-black uppercase tracking-[0.3em] transition-all border-b-2 whitespace-nowrap', 
                        activeTab === tab ? 'border-pv-navy text-pv-navy' : 'border-transparent text-gray-300 hover:text-pv-navy']">
                    {{ tab === 'description' ? 'Descripción' : (tab === 'dosage' ? 'Dosificación' : (tab === 'warnings' ? 'Advertencias' : 'Almacenamiento')) }}
                </button>
            </div>

            <div class="max-w-4xl min-h-[200px]">
                <Transition name="fade" mode="out-in">
                    <div :key="activeTab" class="text-gray-500 leading-[1.8] text-lg font-medium">
                        <div v-if="activeTab === 'description'">{{ producto.descripcion }}</div>
                        <div v-if="activeTab === 'dosage'">{{ producto.dosificacion }}</div>
                        <div v-if="activeTab === 'warnings'" class="p-8 bg-red-50/50 rounded-[2.5rem] border border-red-100 text-red-900 flex gap-6 items-start">
                            <div class="size-12 bg-red-500 text-white rounded-2xl flex items-center justify-center shrink-0 shadow-lg shadow-red-500/20">
                                <Info class="size-6" />
                            </div>
                            <p>{{ producto.advertencias }}</p>
                        </div>
                        <div v-if="activeTab === 'storage'">{{ producto.almacenamiento }}</div>
                    </div>
                </Transition>
            </div>
        </div>

        <!-- 5. RELACIONADOS -->
        <section v-if="relacionados.length" class="pb-20">
            <div class="flex items-end justify-between mb-12 px-2">
                <h2 class="text-3xl font-black text-pv-navy uppercase tracking-tighter italic">También te podría interesar</h2>
                <Link href="/catalogo" class="text-[10px] font-black uppercase tracking-widest text-pv-accent hover:text-pv-navy transition-colors">Ver todo el catálogo</Link>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div v-for="rel in relacionados" :key="rel.sku" 
                     class="group bg-white rounded-[2.5rem] border border-gray-50 p-6 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col shadow-sm">
                    <Link :href="ProductController.show.url(rel.slug)" class="aspect-square bg-gray-50 rounded-[2rem] mb-6 flex items-center justify-center p-8 overflow-hidden">
                         <img :src="rel.imagen_url" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700" />
                    </Link>
                    <Link :href="ProductController.show.url(rel.slug)">
                        <h3 class="text-lg font-black text-pv-navy leading-tight italic uppercase tracking-tighter line-clamp-2 h-12 overflow-hidden hover:text-pv-accent transition-colors mb-4">{{ rel.nombre_comercial }}</h3>
                    </Link>
                    <div class="mt-auto flex items-center justify-between pt-6 border-t border-gray-50">
                        <span class="text-2xl font-black text-pv-navy tracking-tighter italic">S/{{ rel.precio_web }}</span>
                        <button class="bg-emerald-500 hover:bg-pv-navy text-white p-3 rounded-2xl shadow-xl transition-all shadow-emerald-500/10 active:scale-90"><ShoppingCart class="size-5" /></button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>