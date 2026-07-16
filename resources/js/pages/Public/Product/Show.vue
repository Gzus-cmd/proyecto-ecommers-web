<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
    ShoppingCart, Truck, MapPin, 
    Plus, Minus, Info, ChevronRight, Activity, 
    ShieldCheck, CornerDownRight, Heart
} from 'lucide-vue-next';
import { useCart } from '@/composables/useCart';


const props = defineProps<{
    producto: any;
    relacionados: any[];
}>();


const { addToCart } = useCart();


const quantity = ref(1);
const activeTab = ref('description');


const handleAddToCart = () => {
    addToCart(props.producto, quantity.value);
};


const buyRelated = (prod: any) => {
    addToCart(prod, 1);
};
</script>

<template>
    <Head :title="`${producto.nombre_comercial} | PharmaVictoria`" />

    <div class="max-w-7xl mx-auto px-6 py-12">
        

        <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-12 italic">
            <Link href="/" class="hover:text-[#072D44] transition-colors">Inicio</Link>
            <span class="opacity-30">/</span>
            <Link href="/catalogo" class="hover:text-[#072D44] transition-colors">Medicamentos</Link>
            <span class="opacity-30">/</span>
            <span class="text-[#5790AB] font-bold tracking-widest">{{ producto.categoria_nombre }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 mb-24">
            

            <div class="lg:col-span-7">
                <div class="aspect-square bg-white rounded-[4rem] p-12 md:p-20 flex items-center justify-center border border-gray-100 shadow-xl shadow-[#072D44]/5 relative overflow-hidden group">
                    <img :src="producto.imagen_url" class="w-full h-full object-contain transition-transform duration-1000 group-hover:scale-110" />
                    
                    <div v-if="producto.requiere_receta" class="absolute top-10 left-10 bg-rose-500 text-white text-[9px] font-black px-6 py-2.5 rounded-full uppercase tracking-[0.2em] shadow-xl shadow-rose-500/30 italic flex items-center gap-2">
                        <Info class="size-3" /> Requiere Receta Médica
                    </div>

                    <button class="absolute top-10 right-10 p-4 bg-white/80 backdrop-blur rounded-full text-gray-300 hover:text-rose-500 hover:scale-110 transition-all border border-gray-100">
                        <Heart class="size-5" />
                    </button>
                </div>
            </div>


            <div class="lg:col-span-5 flex flex-col justify-center">
                <div class="flex items-center gap-2 mb-4">
                    <Activity class="size-4 text-[#5790AB]" />
                    <span class="text-[#5790AB] font-black uppercase text-[11px] tracking-[0.4em] italic">
                        {{ producto.nombre_generico }}
                    </span>
                </div>

                <h1 class="text-5xl font-black text-[#072D44] leading-[1.05] mb-4 italic tracking-tighter uppercase">
                    {{ producto.nombre_comercial }}
                </h1>
                
                <div class="flex items-center gap-3 mb-10">
                    <p class="text-gray-400 font-bold text-xl">{{ producto.presentacion_web }}</p>
                    <div class="h-1.5 w-1.5 rounded-full bg-gray-200"></div>
                    <span class="text-[10px] font-black text-[#5790AB] uppercase tracking-widest">SKU: {{ producto.sku }}</span>
                </div>


                <div class="bg-[#F8FAFC] p-8 rounded-[2.5rem] border border-gray-100 mb-10">
                    <div class="flex items-baseline gap-4">
                        <span class="text-6xl font-black text-[#072D44] tracking-tighter italic">
                            S/ {{ producto.precio_web }}
                        </span>
                        <span class="text-gray-400 text-xs font-black uppercase tracking-widest italic opacity-60">Impuestos incl.</span>
                    </div>
                </div>


                <div class="flex flex-col sm:flex-row items-center gap-6 mb-12">

                    <div class="flex items-center bg-white border border-gray-200 rounded-[1.8rem] p-1.5 h-16 w-full sm:w-auto shadow-sm">
                        <button @click="quantity > 1 && quantity--" class="size-14 flex items-center justify-center hover:bg-[#F8FAFC] rounded-2xl transition-all active:scale-90 text-[#072D44]">
                            <Minus class="size-4" />
                        </button>
                        <span class="w-14 text-center font-black text-2xl text-[#072D44] tabular-nums">{{ quantity }}</span>
                        <button @click="quantity++" class="size-14 flex items-center justify-center hover:bg-[#F8FAFC] rounded-2xl transition-all active:scale-90 text-[#072D44]">
                            <Plus class="size-4" />
                        </button>
                    </div>
                    

                    <button @click="handleAddToCart" class="flex-1 w-full bg-[#072D44] text-white h-16 rounded-[1.8rem] font-black uppercase text-xs tracking-[0.2em] hover:bg-[#5790AB] transition-all shadow-2xl shadow-[#072D44]/20 active:scale-95 flex items-center justify-center gap-3 italic">
                        <ShoppingCart class="size-5" />
                        Añadir al Carrito
                    </button>
                </div>


                <div class="space-y-4 p-8 border border-gray-100 rounded-[2.5rem] bg-white">
                    <div class="flex items-center gap-5">
                        <div class="size-10 bg-[#5790AB]/10 rounded-xl flex items-center justify-center text-[#5790AB]">
                            <Truck class="size-5" />
                        </div>
                        <div>
                            <p class="text-xs font-black text-[#072D44] uppercase tracking-widest italic">Envío Prioritario</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Entrega estimada: 24 Horas</p>
                        </div>
                    </div>
                    <div class="h-px bg-gray-50 w-full"></div>
                    <div class="flex items-center gap-5">
                        <div class="size-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500">
                            <ShieldCheck class="size-5" />
                        </div>
                        <div>
                            <p class="text-xs font-black text-emerald-600 uppercase tracking-widest italic">Stock Verificado</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Validado por Almacén Central</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="mb-32">
            <div class="flex border-b border-gray-100 mb-12 gap-12 overflow-x-auto no-scrollbar">
                <button v-for="tab in ['description', 'dosage', 'warnings', 'storage']" 
                        :key="tab"
                        @click="activeTab = tab"
                        :class="['pb-6 text-[10px] font-black uppercase tracking-[0.3em] transition-all border-b-2 whitespace-nowrap', 
                        activeTab === tab ? 'border-[#072D44] text-[#072D44]' : 'border-transparent text-gray-300 hover:text-[#072D44]']">
                    {{ tab === 'description' ? 'Descripción' : (tab === 'dosage' ? 'Dosificación' : (tab === 'warnings' ? 'Advertencias' : 'Almacenamiento')) }}
                </button>
            </div>

            <div class="max-w-4xl min-h-[150px]">
                <Transition name="fade" mode="out-in">
                    <div :key="activeTab" class="text-gray-500 leading-[1.8] text-lg font-medium italic">
                        <div v-if="activeTab === 'description'">{{ producto.descripcion }}</div>
                        <div v-if="activeTab === 'dosage'">{{ producto.dosificacion }}</div>
                        <div v-if="activeTab === 'warnings'" class="p-10 bg-rose-50 rounded-[3rem] border border-rose-100 text-rose-900 flex gap-6 items-start">
                            <Info class="size-8 shrink-0 text-rose-500" />
                            <p class="font-bold leading-relaxed">{{ producto.advertencias }}</p>
                        </div>
                        <div v-if="activeTab === 'storage'">{{ producto.almacenamiento }}</div>
                    </div>
                </Transition>
            </div>
        </div>


        <section v-if="relacionados && relacionados.length" class="pb-20">
            <div class="flex items-end justify-between mb-12 px-4">
                <div>
                    <h2 class="text-3xl font-black text-[#072D44] uppercase tracking-tighter italic">Recomendaciones Clínicas</h2>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mt-1">Productos de la misma categoría</p>
                </div>
                <Link href="/catalogo" class="text-[10px] font-black uppercase tracking-widest text-[#5790AB] border-b-2 border-[#5790AB]/20 pb-1 hover:text-[#072D44] hover:border-[#072D44] transition-all italic">Ver Catálogo Completo</Link>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div v-for="rel in relacionados" :key="rel.sku" 
                     class="group bg-white rounded-[2.5rem] border border-gray-100 p-6 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col shadow-sm">
                    
                    <Link :href="`/producto/${rel.slug}`" class="aspect-square bg-[#F8FAFC] rounded-[2rem] mb-6 flex items-center justify-center p-8 overflow-hidden relative border border-gray-50 group-hover:bg-white transition-colors duration-500">
                         <img :src="rel.imagen_url" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700" />
                         <div class="absolute inset-0 bg-[#072D44]/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </Link>

                    <div class="flex-1 flex flex-col">
                        <span class="text-[9px] font-black text-[#5790AB] uppercase tracking-[0.2em] mb-2 italic">{{ rel.categoria_nombre }}</span>
                        
                        <Link :href="`/producto/${rel.slug}`">
                            <h3 class="text-base font-black text-[#072D44] leading-tight italic uppercase tracking-tighter line-clamp-2 h-10 hover:text-[#5790AB] transition-colors mb-4">{{ rel.nombre_comercial }}</h3>
                        </Link>

                        <div class="mt-auto flex items-center justify-between pt-6 border-t border-gray-50">
                            <span class="text-2xl font-black text-[#072D44] tracking-tighter italic">S/{{ rel.precio_web }}</span>
                            <button @click="buyRelated(rel)" class="bg-[#072D44] hover:bg-[#5790AB] text-white p-3.5 rounded-2xl shadow-xl transition-all shadow-[#072D44]/10 active:scale-90">
                                <ShoppingCart class="size-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.fade-enter-active, .fade-leave-active { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
.fade-enter-from, .fade-leave-to { opacity: 0; transform: translateY(10px); }

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
</style>