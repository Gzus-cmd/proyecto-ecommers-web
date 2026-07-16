<script setup lang="ts">
import { router, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useCart } from '@/composables/useCart';
import { 
    Search, ShoppingCart, User, MapPin, 
    LogOut, X, Package, Trash2, ArrowRight, ShoppingBag 
} from 'lucide-vue-next';
import '../../css/public-store.css';

/** 
 * DEFINICIÓN DE TIPOS
 */
interface UserAccount {
    id: number;
    name: string;
    email: string;
}

interface PageProps {
    auth: {
        user: UserAccount | null;
        roles: string[];
        permissions: string[];
    };
    [key: string]: any;
}

// Inicialización
const page = usePage<PageProps>();
const { cart, count, total, removeFromCart } = useCart();

// Control del Carrito Lateral
const showCart = ref(false);

const getFirstName = (fullName: string | undefined) => {
    return fullName ? fullName.split(' ')[0] : 'Cuenta';
};

const goToCheckout = () => {
    showCart.value = false; 
    router.get('/checkout'); 
};
</script>

<template>
    <div class="theme-public-store min-h-screen flex flex-col antialiased bg-[#F8FAFC]">

        <!-- HEADER -->
        <header class="bg-white border-b border-gray-100 sticky top-0 z-[100] shadow-sm/5">
            <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between gap-8">
                
                <!-- Logo -->
                <Link href="/" class="flex items-center gap-2 shrink-0 group">
                    <div class="w-10 h-10 bg-[#072D44] rounded-xl flex items-center justify-center text-white font-black italic group-hover:scale-105 transition-transform duration-300 shadow-lg shadow-[#072D44]/10">
                        PV
                    </div>
                    <span class="text-2xl font-black uppercase tracking-tighter text-[#072D44]">
                        Pharma<span class="text-[#5790AB] font-bold">Victoria</span>
                    </span>
                </Link>

                <!-- Buscador -->
                <div class="hidden md:flex flex-1 max-w-md mx-8 relative">
                    <Search class="absolute left-4 top-1/2 -translate-y-1/2 size-4 text-gray-400" />
                    <input type="text" placeholder="Buscar medicamentos..." 
                           class="w-full h-11 bg-[#F1F3F5] border-none rounded-2xl pl-10 text-sm text-[#072D44] placeholder:text-gray-400 focus:ring-2 focus:ring-[#5790AB]/20 transition-all outline-none font-medium" />
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center gap-6">
                    <div class="hidden lg:flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 italic">
                        <MapPin class="size-4 text-[#5790AB]" />
                        <span>Sede Central</span>
                    </div>

                    <!-- Usuario -->
                    <div class="flex items-center gap-4 border-l border-gray-100 pl-6">
                        <template v-if="page.props.auth.user">
                            <Link href="/mi-cuenta/perfil" class="flex items-center gap-3 group transition-opacity hover:opacity-80">
                                <div class="hidden sm:flex flex-col items-end leading-tight">
                                    <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Mi Panel</span>
                                    <span class="text-xs font-bold text-[#072D44]">Hola, {{ getFirstName(page.props.auth.user.name) }}</span>
                                </div>
                                <div class="size-10 bg-[#5790AB]/10 rounded-full flex items-center justify-center text-[#5790AB] group-hover:bg-[#5790AB] group-hover:text-white transition-colors duration-300">
                                    <User class="size-5" />
                                </div>
                            </Link>
                            <Link href="/logout" method="post" as="button" class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                                <LogOut class="size-4" />
                            </Link>
                        </template>
                        <template v-else>
                            <Link href="/login" class="flex items-center gap-2 text-[#072D44] hover:text-[#5790AB] transition-colors group">
                                <span class="hidden sm:inline text-xs font-black uppercase tracking-widest">Ingresar</span>
                                <div class="size-10 bg-gray-50 rounded-full flex items-center justify-center border border-gray-100 group-hover:border-[#5790AB]/20">
                                    <User class="size-5" />
                                </div>
                            </Link>
                        </template>
                    </div>

                    <!-- BOTÓN CARRITO -->
                    <div @click="showCart = true" class="relative text-[#072D44] cursor-pointer group">
                        <div class="size-12 bg-gray-50 rounded-full flex items-center justify-center border border-transparent group-hover:border-gray-200 transition-all">
                            <ShoppingCart class="size-6 group-hover:scale-110 transition-transform" />
                            <span v-if="count > 0" class="absolute -top-1 -right-1 bg-[#072D44] text-white text-[10px] size-5 rounded-full flex items-center justify-center font-black border-2 border-white shadow-lg animate-in zoom-in duration-300">
                                {{ count }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- PANEL LATERAL DEL CARRITO (SIDEBAR) -->
        <div v-if="showCart" class="fixed inset-0 z-[1000] flex justify-end">
            <!-- Backdrop Oscuro -->
            <div class="absolute inset-0 bg-[#072D44]/60 backdrop-blur-md transition-opacity" @click="showCart = false"></div>
            
            <!-- Contenido del Sidebar -->
            <div class="relative w-full max-w-md bg-white shadow-2xl flex flex-col h-full animate-in slide-in-from-right duration-500">
                <!-- Header del Carrito -->
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-[#F8FAFC]">
                    <div>
                        <h3 class="text-2xl font-black text-[#072D44] uppercase italic tracking-tighter">Mi Carrito</h3>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ count }} productos seleccionados</p>
                    </div>
                    <button @click="showCart = false" class="p-3 hover:bg-white rounded-full transition-colors border border-transparent hover:border-gray-200">
                        <X class="size-6 text-[#072D44]" />
                    </button>
                </div>

                <!-- Lista de Productos -->
                <div class="flex-1 overflow-y-auto p-8 space-y-6">
                    <div v-for="item in cart" :key="item.sku" class="flex gap-5 items-center bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm/5 hover:border-[#5790AB]/20 transition-all group">
                        <div class="size-20 bg-[#F8FAFC] rounded-2xl flex items-center justify-center overflow-hidden p-3 shrink-0 border border-gray-50">
                            <img :src="item.imagen" class="w-full h-full object-contain" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start gap-2">
                                <h4 class="text-xs font-black text-[#072D44] uppercase leading-tight italic truncate">
                                    {{ item.nombre }}
                                </h4>
                                <button @click="removeFromCart(item.sku)" class="text-gray-300 hover:text-red-500 transition-colors p-1 shrink-0">
                                    <Trash2 class="size-4" />
                                </button>
                            </div>
                            <div class="flex justify-between items-end mt-4">
                                <p class="text-[11px] font-bold text-[#5790AB] italic">
                                    S/ {{ item.precio }} x {{ item.quantity }}
                                </p>
                                <span class="text-sm font-black text-[#072D44]">
                                    S/ {{ (item.precio * item.quantity).toFixed(2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Estado Vacío -->
                    <div v-if="cart.length === 0" class="flex flex-col items-center justify-center h-full text-center space-y-4 opacity-40">
                        <ShoppingBag class="size-16 text-gray-300" />
                        <p class="text-gray-500 italic text-sm font-medium uppercase tracking-widest">Su bolsa está vacía</p>
                        <button @click="showCart = false" class="text-xs font-black text-[#5790AB] uppercase tracking-widest hover:underline italic">Regresar a la tienda</button>
                    </div>
                </div>

                <!-- Footer del Carrito -->
                <div class="p-10 border-t border-gray-100 bg-[#F8FAFC]">
                    <div class="flex justify-between items-center mb-8">
                        <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Total de compra</span>
                        <span class="text-4xl font-black text-[#072D44] italic tracking-tighter">S/ {{ total.toFixed(2) }}</span>
                    </div>
                    <button 
                        @click="goToCheckout"
                        class="w-full h-16 bg-[#072D44] text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-[#5790AB] transition-all shadow-xl shadow-[#072D44]/20 flex items-center justify-center gap-3"
                    >
                        Proceder al Pago <ArrowRight class="size-4" />
                    </button>
                </div>
            </div>
        </div>

        <!-- CONTENIDO DE PÁGINA -->
        <main class="flex-1 relative">
            <slot />
        </main>

        <!-- FOOTER -->
        <footer class="bg-white border-t border-gray-100 py-12 mt-auto">
            <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex flex-col items-center md:items-start gap-2 text-[#072D44]">
                    <span class="text-xl font-black uppercase tracking-tighter">Pharma<span class="text-[#5790AB]">Victoria</span></span>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">Excelencia Farmacéutica Digital</p>
                </div>
                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-widest text-center">© 2024 PharmaVictoria. Profesionales Colegiados.</p>
                <div class="flex gap-8 text-[10px] font-black uppercase tracking-widest text-gray-400 italic">
                    <a href="#" class="hover:text-[#072D44]">Ayuda</a>
                    <a href="#" class="hover:text-[#072D44]">Privacidad</a>
                    <a href="#" class="hover:text-[#072D44]">Términos</a>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Evitar scroll del body cuando el carrito esté abierto */
:global(body.overflow-hidden) {
    overflow: hidden;
}

/* Animación suave para la entrada lateral */
.animate-in {
    animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideIn {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
</style>