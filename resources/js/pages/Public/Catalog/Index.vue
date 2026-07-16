<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3';
import { useCart } from '@/composables/useCart';
import { reactive, watch } from 'vue';
import * as CatalogController from '@/actions/App/Http/Controllers/Public/CatalogController';
import * as HomeController from '@/actions/App/Http/Controllers/Public/HomeController';
import * as ProductController from '@/actions/App/Http/Controllers/Public/ProductController';

import { 
    ChevronLeft, ChevronRight, Bookmark, ShoppingCart, 
    Filter, Search 
} from 'lucide-vue-next';
import debounce from 'lodash/debounce';

const props = defineProps<{
    productos: any,
    categorias: any[], 
    filters: any
}>();


const form = reactive({
    categoria: props.filters?.categoria || '',
    sort: props.filters?.sort || 'name_asc',
    min_price: props.filters?.min_price || '',
    max_price: props.filters?.max_price || '',
    in_stock: props.filters?.in_stock === undefined ? true : String(props.filters.in_stock) === 'true'
});


const updateUrl = (cambios: any = {}) => {
    Object.assign(form, cambios);
    router.get('/catalogo', { ...form }, { preserveState: true, replace: true, preserveScroll: true });
};

const applyFiltersDebounced = debounce(() => updateUrl(), 500);


watch(() => [form.sort, form.in_stock], () => updateUrl());
watch(() => props.filters.categoria, (newSlug) => { form.categoria = newSlug || ''; }, { immediate: true });


const cleanLabel = (label: string) => label.replace('&laquo; Previous', '').replace('Next &raquo;', '');

const { addToCart } = useCart();
</script>

<template>
    <Head title="Medicamentos | PharmaVictoria" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        

        <nav class="flex text-[10px] font-black uppercase tracking-[0.2em] mb-6 gap-2 italic">
            <Link :href="HomeController.index.url()" class="text-gray-400 hover:text-pv-navy transition-colors">Inicio</Link>
            <span class="text-gray-300">/</span> 
            <span class="text-pv-navy font-bold tracking-tighter">Medicamentos</span>
        </nav>


        <header class="mb-12">
            <h1 class="text-6xl font-black text-pv-navy tracking-tighter italic">Medicamentos</h1>
            <p class="text-gray-500 mt-2 italic text-sm">Productos certificados con stock real verificado desde el almacén central.</p>
        </header>

        <div class="flex flex-col lg:flex-row gap-10">
            

            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="sticky top-24 bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-xl shadow-pv-navy/5">
                    
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-black text-pv-navy text-xs uppercase tracking-widest flex items-center gap-2">
                            <Filter class="size-4" /> Filtros
                        </h3>
                        <button @click="updateUrl({categoria: '', min_price: '', max_price: ''})" class="text-[9px] font-black text-pv-accent hover:text-pv-navy uppercase tracking-widest transition-colors">Limpiar</button>
                    </div>

                    <div class="space-y-10">

                        <section>
                            <h4 class="font-black text-pv-navy text-[10px] uppercase mb-5 italic flex items-center">
                                <span class="w-1.5 h-1.5 bg-pv-accent rounded-full mr-2 shadow-sm"></span> 
                                Categorías
                            </h4>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" :checked="form.categoria === ''" @change="updateUrl({categoria: ''})" name="cat_filter" class="size-4 text-pv-navy border-gray-200 focus:ring-pv-accent/30" />
                                    <span class="text-xs font-bold transition-colors" :class="form.categoria === '' ? 'text-pv-navy font-black' : 'text-gray-400'">Todas</span>
                                </label>
                                <label v-for="cat in categorias" :key="cat.slug" class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" :checked="form.categoria === cat.slug" @change="updateUrl({categoria: cat.slug})" name="cat_filter" class="size-4 text-pv-navy border-gray-200 focus:ring-pv-accent/30" />
                                    <span class="text-xs font-bold transition-colors uppercase tracking-tight" :class="form.categoria === cat.slug ? 'text-pv-navy font-black' : 'text-gray-400 group-hover:text-pv-navy'">{{ cat.nombre }}</span>
                                </label>
                            </div>
                        </section>


                        <section>
                            <h4 class="font-black text-pv-navy text-[10px] uppercase mb-5 italic flex items-center">
                                <span class="w-1.5 h-1.5 bg-pv-accent rounded-full mr-2 shadow-sm"></span> 
                                Precio
                            </h4>
                            <div class="flex items-center gap-2">
                                <input v-model="form.min_price" @input="applyFiltersDebounced" type="number" placeholder="Mín" class="w-full h-10 px-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-bold outline-none" />
                                <input v-model="form.max_price" @input="applyFiltersDebounced" type="number" placeholder="Máx" class="w-full h-10 px-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-bold outline-none" />
                            </div>
                        </section>


                        <section>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" v-model="form.in_stock" @change="updateUrl({})" class="size-5 border-gray-100 rounded-lg accent-pv-navy" />
                                <span class="text-xs font-bold text-gray-500 group-hover:text-pv-navy transition-colors">Solo en Stock</span>
                            </label>
                        </section>
                    </div>
                </div>
            </aside>


            <main class="flex-1">

                <div class="bg-white border border-gray-100 rounded-[2rem] p-5 mb-8 flex justify-between items-center shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                        Mostrando <span class="text-pv-navy font-black">{{ productos.from }}-{{ productos.to }}</span> de {{ productos.total }} productos
                    </p>
                    <select v-model="form.sort" @change="updateUrl({})" class="bg-[#072D44] text-white rounded-xl px-5 py-2 text-xs font-black outline-none cursor-pointer uppercase tracking-widest italic">
                        <option value="name_asc">A - Z</option>
                        <option value="price_asc">Menor Precio</option>
                        <option value="price_desc">Mayor Precio</option>
                    </select>
                </div>


                <div v-if="productos.data.length" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    <div v-for="prod in productos.data" :key="prod.sku" 
                        class="group bg-white rounded-[2.5rem] border border-gray-50 p-6 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col shadow-sm">
                        

                        <Link :href="ProductController.show.url(prod.slug)" class="aspect-square bg-[#F8FAFC] rounded-[2rem] mb-6 flex items-center justify-center p-8 overflow-hidden relative">
                             <img :src="prod.imagen_url" class="w-full h-full object-contain transform transition-transform duration-700 group-hover:scale-110" :alt="prod.nombre_comercial" />
                             
                             <button class="absolute top-5 right-5 p-2.5 bg-white/80 backdrop-blur rounded-full shadow-sm hover:bg-white transition-all group/fav">
                                <Bookmark class="size-4 text-pv-navy/40 group-hover/fav:text-pv-navy transition-colors" />
                             </button>
                        </Link>

                        <div class="flex-1 flex flex-col">
                            <span class="text-[9px] font-black text-pv-accent uppercase tracking-widest mb-2">{{ prod.categoria_nombre }}</span>


                            <Link :href="ProductController.show.url(prod.slug)">
                                <h2 class="text-lg font-black text-pv-navy leading-tight italic uppercase tracking-tighter hover:text-pv-accent transition-colors line-clamp-2 h-12 overflow-hidden mb-1">
                                    {{ prod.nombre_comercial }}
                                </h2>
                            </Link>
                            
                            <p class="text-[10px] text-gray-400 font-medium italic line-clamp-1">
                                {{ prod.nombre_generico }} — {{ prod.concentracion }}
                            </p>
                            
                            <div class="mt-8 flex items-center justify-between pt-6 border-t border-gray-50">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-gray-300 font-black uppercase tracking-widest">Precio Online</span>
                                    <span class="text-3xl font-black text-pv-navy tracking-tighter italic">S/{{ prod.precio_web }}</span>
                                </div>
                                <button @click="addToCart(prod)" class="bg-emerald-500 hover:bg-[#072D44] text-white p-4 rounded-2xl shadow-xl transition-all active:scale-95 group/cart shadow-emerald-500/20">
                                    <ShoppingCart class="size-6 group-hover/cart:rotate-12 transition-transform" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div v-if="productos.links.length > 3" class="mt-20 flex justify-center items-center gap-2">
                    <template v-for="(link, k) in productos.links" :key="k">
                        <Link v-if="link.url" :href="link.url" 
                              class="size-12 flex items-center justify-center text-sm font-bold rounded-lg border transition-all"
                              :class="link.active 
                                ? 'bg-[#072D44] border-[#072D44] text-white shadow-lg' 
                                : 'bg-white text-gray-600 border-gray-100 hover:bg-gray-50'">
                            <ChevronLeft v-if="k === 0" class="size-4" />
                            <ChevronRight v-else-if="k === productos.links.length - 1" class="size-4" />
                            <span v-else>{{ cleanLabel(link.label) }}</span>
                        </Link>
                    </template>
                </div>
            </main>
        </div>
    </div>
</template>

<style scoped>
input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

.line-clamp-2 {
  display: -webkit-box;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
</style>