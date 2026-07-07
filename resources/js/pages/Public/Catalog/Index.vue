<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';
import * as CatalogController from '@/actions/App/Http/Controllers/Public/CatalogController';
import * as HomeController from '@/actions/App/Http/Controllers/Public/HomeController';
import { ChevronLeft, ChevronRight, Bookmark, ShoppingCart, Filter } from 'lucide-vue-next';
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
</script>

<template>
    <Head title="Medicamentos | PharmaVictoria" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <nav class="flex text-[10px] font-black uppercase tracking-[0.2em] mb-6 gap-2">
            <Link :href="HomeController.index.url()" class="text-gray-400 hover:text-pv-navy transition-colors">Inicio</Link>
            <span class="text-gray-300">/</span> <span class="text-pv-navy font-bold">Medicamentos</span>
        </nav>

        <header class="mb-12">
            <h1 class="text-6xl font-black text-pv-navy tracking-tighter italic">Medicamentos</h1>
            <p class="text-gray-500 mt-2 italic text-sm">Productos certificados con stock real verificado.</p>
        </header>

        <div class="flex flex-col lg:flex-row gap-10">

            <aside class="w-full lg:w-72 shrink-0">
                <div class="sticky top-24 bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-xl shadow-pv-navy/5">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-black text-pv-navy text-xs uppercase tracking-widest flex items-center gap-2"><Filter class="size-4" /> Filtros</h3>
                        <button @click="updateUrl({categoria: '', min_price: '', max_price: ''})" class="text-[9px] font-black text-pv-accent hover:text-pv-navy uppercase transition-colors">Limpiar</button>
                    </div>

                    <div class="space-y-10">

                        <section>
                            <h4 class="font-black text-pv-navy text-[10px] uppercase mb-5 italic flex items-center"><span class="w-1.5 h-1.5 bg-pv-accent rounded-full mr-2"></span> Categorías</h4>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" :checked="form.categoria === ''" @change="updateUrl({categoria: ''})" name="cat" class="size-4 text-pv-navy border-gray-200" />
                                    <span class="text-xs font-bold" :class="form.categoria === '' ? 'text-pv-navy font-black' : 'text-gray-400'">Todas</span>
                                </label>
                                <label v-for="cat in categorias" :key="cat.slug" class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" :checked="form.categoria === cat.slug" @change="updateUrl({categoria: cat.slug})" name="cat" class="size-4 text-pv-navy border-gray-200" />
                                    <span class="text-xs font-bold transition-colors uppercase tracking-tight" :class="form.categoria === cat.slug ? 'text-pv-navy font-black' : 'text-gray-400'">{{ cat.nombre }}</span>
                                </label>
                            </div>
                        </section>


                        <section>
                            <h4 class="font-black text-pv-navy text-[10px] uppercase mb-5 italic flex items-center"><span class="w-1.5 h-1.5 bg-pv-accent rounded-full mr-2"></span> Rango de Precio</h4>
                            <div class="flex items-center gap-2">
                                <input v-model="form.min_price" @input="applyFiltersDebounced" type="number" placeholder="Mín" class="w-full h-10 px-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-bold outline-none" />
                                <input v-model="form.max_price" @input="applyFiltersDebounced" type="number" placeholder="Máx" class="w-full h-10 px-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-bold outline-none" />
                            </div>
                        </section>


                        <section>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" v-model="form.in_stock" class="size-5 border-gray-100 rounded-lg accent-pv-navy" />
                                <span class="text-[10px] font-black text-pv-navy uppercase tracking-widest">Solo en Stock</span>
                            </label>
                        </section>
                    </div>
                </div>
            </aside>


            <main class="flex-1">

                <div class="bg-white border border-gray-100 rounded-4xl p-5 mb-8 flex flex-col md:flex-row justify-between items-center gap-6 shadow-sm">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Mostrando <span class="text-pv-navy">{{ productos.from || 0 }}-{{ productos.to || 0 }}</span> de {{ productos.total }}</p>
                    <div class="flex items-center gap-4">
                        <span class="text-[9px] font-black text-gray-400 uppercase italic">Ordenar:</span>
                        <select v-model="form.sort" class="bg-[#072D44] text-white rounded-xl px-6 py-2.5 text-[10px] font-black outline-none cursor-pointer uppercase tracking-widest">
                            <option value="name_asc">A - Z</option>
                            <option value="price_asc">Menor Precio</option>
                            <option value="price_desc">Mayor Precio</option>
                        </select>
                    </div>
                </div>




                <div v-if="productos.data.length" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    <div v-for="prod in productos.data" :key="prod.sku" 
                        class="group bg-white rounded-[2.5rem] border border-gray-50 p-6 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col shadow-sm">
                        

                        <div class="aspect-square bg-[#F8FAFC] rounded-4xl mb-6 flex items-center justify-center p-8 overflow-hidden relative">

                            <img :src="prod.imagen_url" 
                                class="w-full h-full object-contain transform transition-transform duration-700 group-hover:scale-110" 
                                :alt="prod.nombre_comercial" />
                            

                            <button class="absolute top-5 right-5 p-2.5 bg-white/90 backdrop-blur rounded-full shadow-sm hover:bg-white transition-all group/fav">

                                <Bookmark class="size-4 text-pv-navy/40 group-hover/fav:text-pv-navy transition-colors" />
                            </button>
                        </div>


                        <div class="flex-1 flex flex-col">
                            <span class="text-[9px] font-black text-pv-accent uppercase tracking-widest mb-2">{{ prod.categoria_nombre }}</span>

                            <h2 class="text-lg font-black text-pv-navy leading-tight italic uppercase tracking-tighter group-hover:text-pv-accent transition-colors line-clamp-2 h-12 overflow-hidden mb-1">
                                {{ prod.nombre_comercial }}
                            </h2>
                            
                            <p class="text-[10px] text-gray-400 font-medium italic line-clamp-1">
                                {{ prod.nombre_generico }} — {{ prod.concentracion }}
                            </p>
                            

                            <div class="mt-8 flex items-center justify-between pt-6 border-t border-gray-50">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-gray-300 font-black uppercase tracking-widest">Precio Online</span>
                                    <span class="text-3xl font-black text-pv-navy tracking-tighter italic">S/{{ prod.precio_web }}</span>
                                </div>
                                <button class="bg-emerald-500 hover:bg-[#072D44] text-white p-4 rounded-2xl shadow-xl transition-all active:scale-95 group/cart shadow-emerald-500/20">
                                    <ShoppingCart class="size-6 group-hover/cart:rotate-12 transition-transform" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div v-if="productos.links.length > 3" class="mt-24 flex justify-center items-center gap-2">
                    <template v-for="(link, k) in productos.links" :key="k">
                        <Link v-if="link.url" :href="link.url" class="size-12 flex items-center justify-center text-sm font-bold rounded-xl border transition-all" :class="link.active ? 'bg-[#072D44] border-[#072D44] text-white shadow-lg':'bg-white border-gray-100 text-gray-600 hover:bg-gray-50'">
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
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
</style>