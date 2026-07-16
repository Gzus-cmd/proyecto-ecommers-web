<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import * as LucideIcons from 'lucide-vue-next'; 
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useCart } from '@/composables/useCart';
import * as CatalogController from '@/actions/App/Http/Controllers/Public/CatalogController';
// Usaremos este para los enlaces de los productos
import * as ProductController from '@/actions/App/Http/Controllers/Public/ProductController';

interface Categoria { id: number; nombre: string; slug: string; icono_lucide: string; }
interface Banner { 
    id: number; 
    titulo: string; 
    descripcion: string; 
    imagen_url: string; 
    producto_sku: string; 
}

const props = defineProps<{ 
    categories: Categoria[]; 
    featuredProducts: any[]; 
    banners: Banner[];
}>();

const resolveIcon = (name: string) => (LucideIcons as any)[name] || LucideIcons.Package;
const formatCurrency = (val: number) => new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(val);

const currentSlide = ref(0);
let timer: any = null;

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % props.banners.length;
};

onMounted(() => {
    if (props.banners.length > 1) {
        timer = setInterval(nextSlide, 8000); 
    }
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});

const { addToCart } = useCart();
</script>

<template>
    <Head title="PharmaVictoria | Tu Salud en Buenas Manos" />

    <PublicLayout>
        <!-- 1. HERO CAROUSEL -->
        <section class="max-w-7xl mx-auto px-4 py-8 mt-6">
            <div v-if="banners.length > 0" class="relative w-full h-125 md:h-137.5 rounded-[4rem] overflow-hidden bg-[#072D44] shadow-2xl">
                <TransitionGroup name="hero-fade">
                    <div 
                        v-for="(banner, index) in banners" 
                        :key="banner.id"
                        v-show="currentSlide === index"
                        class="absolute inset-0 w-full h-full flex items-center px-10 md:px-24"
                        :class="index % 2 === 0 ? 'justify-start' : 'justify-end'"
                    >
                        <img :src="banner.imagen_url" class="absolute top-0 w-full h-full object-cover z-0 transition-all duration-1000" :class="index % 2 === 0 ? 'right-0 md:w-3/5 object-right' : 'left-0 md:w-3/5 object-left'" />
                        <div class="absolute inset-0 z-10 transition-all duration-1000" :class="index % 2 === 0 ? 'bg-linear-to-r from-[#072D44] via-[#072D44]/90 to-transparent' : 'bg-linear-to-l from-[#072D44] via-[#072D44]/90 to-transparent'"></div>

                        <div class="relative z-20 max-w-xl text-white flex flex-col" :class="index % 2 === 0 ? 'text-left items-start' : 'text-right items-end'">
                            <div class="relative inline-flex items-center gap-3 bg-amber-500 text-navy-950 text-[10px] font-black px-5 py-2.5 rounded-full uppercase tracking-[0.2em] mb-8 w-fit shadow-xl overflow-hidden">
                                <div class="absolute inset-0 bg-linear-to-r from-transparent via-white/40 to-transparent -translate-x-full animate-shimmer"></div>
                                <LucideIcons.Timer class="size-3.5 animate-spin" style="animation-duration: 4s" /> 
                                <span>Ofertas de Temporada</span>
                            </div>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black leading-[1.1] uppercase tracking-tighter mb-6 italic">{{ banner.titulo }}</h1>
                            <p class="text-white/70 text-base md:text-lg mb-10 font-medium leading-relaxed line-clamp-2">{{ banner.descripcion }}</p>
                            <Link :href="CatalogController.index.url()" class="bg-white text-[#072D44] w-fit px-12 py-5 rounded-2xl font-black uppercase text-xs tracking-widest transition-all hover:bg-[#9CCDDB] shadow-2xl active:scale-95">
                                Explorar Catálogo
                            </Link>
                        </div>
                    </div>
                </TransitionGroup>
                <div v-if="banners.length > 1" class="absolute bottom-10 left-1/2 -translate-x-1/2 z-30 flex gap-4 items-center">
                    <button v-for="(_, i) in banners" :key="i" @click="currentSlide = i" :class="['transition-all duration-500 rounded-full', currentSlide === i ? 'w-10 h-2.5 bg-amber-500 shadow-lg' : 'w-2.5 h-2.5 bg-white/20 hover:bg-white/40']"></button>
                </div>
            </div>
            <div v-else class="w-full h-125 bg-navy-900 rounded-[4rem] border border-white/5 flex items-center justify-center">
                <LucideIcons.ImageIcon class="size-16 text-white/5" />
            </div>
        </section>

        <!-- 2. CATEGORÍAS -->
        <section class="max-w-7xl mx-auto px-4 py-20 mt-10">
            <h2 class="text-4xl font-black uppercase text-[#072D44] mb-12 italic tracking-tighter">Explorar Categorías</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <Link v-for="cat in categories" :key="cat.id"
                    :href="`/catalogo?categoria=${cat.slug}`" 
                    class="group bg-white p-10 rounded-[3rem] border border-gray-100 flex flex-col items-center gap-6 hover:shadow-2xl hover:-translate-y-2 transition-all shadow-sm">
                    <div class="size-20 bg-gray-50 rounded-2xl flex items-center justify-center text-[#072D44] group-hover:bg-[#072D44] group-hover:text-white transition-all shadow-inner">
                        <component :is="resolveIcon(cat.icono_lucide)" class="size-10" />
                    </div>
                    <span class="text-xs font-black uppercase tracking-widest text-gray-500 group-hover:text-[#072D44] text-center leading-tight">{{ cat.nombre }}</span>
                </Link>
            </div>
        </section>

        <!-- 3. PRODUCTOS DESTACADOS (CON ENLACES ACTIVADOS) -->
        <section class="max-w-7xl mx-auto px-4 py-10 pb-32">
            <h2 class="text-3xl font-black uppercase text-[#072D44] mb-16 text-center italic tracking-tight">Destacados de la semana</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <div v-for="prod in featuredProducts" :key="prod.sku" class="bg-white p-8 rounded-[3.5rem] border border-gray-100 hover:shadow-2xl transition-all group flex flex-col shadow-sm">
                    

                    <Link :href="`/producto/${prod.slug}`"  class="aspect-square bg-[#F8FAFC] rounded-[2.5rem] mb-8 overflow-hidden p-10 flex items-center justify-center relative border border-gray-100">
                        <img :src="prod.imagen_url" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700" />
                        <span class="absolute top-4 left-4 bg-rose-500 text-white text-[10px] font-black px-3 py-1.5 rounded-xl shadow-lg uppercase">-{{ prod.percentage }}%</span>
                    </Link>

                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-black text-[#5790AB] uppercase tracking-widest">{{ prod.categoria_nombre }}</span>
                            

                            <Link :href="ProductController.show.url(prod.slug)">
                                <h3 class="font-black text-[#072D44] uppercase text-lg leading-tight mt-2 italic line-clamp-2 h-12 hover:text-pv-accent transition-colors">
                                    {{ prod.nombre_comercial }}
                                </h3>
                            </Link>
                        </div>
                        <div class="pt-8 mt-8 border-t border-gray-50 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-3xl font-black text-[#072D44]">S/{{ prod.precio_web }}</span>
                            </div>
                            <button @click="addToCart(prod)" class="bg-[#072D44] hover:bg-emerald-500 text-white p-4 rounded-2xl shadow-xl transition-all active:scale-90">
                                <LucideIcons.Plus class="size-6" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>