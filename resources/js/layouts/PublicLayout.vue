<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Search, ShoppingCart, User, MapPin } from 'lucide-vue-next';
import '../../css/public-store.css'; 
</script>

<template>
    <div class="theme-public-store min-h-screen antialiased">

        <header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm/5">
            <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between gap-8">
                
                <Link href="/" class="flex items-center gap-2 shrink-0 group">
                    <div class="w-10 h-10 bg-[#072D44] rounded-xl flex items-center justify-center text-white font-black italic group-hover:scale-105 transition-transform">
                        PV
                    </div>
                    <span class="text-2xl font-black uppercase tracking-tighter text-[#072D44]">
                        Pharma<span class="text-[#5790AB] font-bold">Victoria</span>
                    </span>
                </Link>

                <div class="hidden md:flex flex-1 max-w-md mx-8 relative">
                    <Search class="absolute left-4 top-1/2 -translate-y-1/2 size-4 text-gray-400" />
                    <input type="text" placeholder="Search medicines, health products..." 
                           class="w-full h-11 bg-[#F1F3F5] border-none rounded-2xl pl-10 text-sm text-[#072D44] placeholder:text-gray-400 focus:ring-2 focus:ring-[#5790AB]/20 transition-all" />
                </div>

                <div class="flex items-center gap-6">
                    <div class="hidden lg:flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400">
                        <MapPin class="size-4 text-[#5790AB]" />
                        <span>Sede Central</span>
                    </div>
                    <Link href="/login" class="text-[#072D44] hover:opacity-70 transition-opacity">
                        <User class="size-6" />
                    </Link>
                    <div class="relative text-[#072D44]">
                        <ShoppingCart class="size-6" />
                        <span class="absolute -top-2 -right-2 bg-[#072D44] text-white text-[10px] size-4 rounded-full flex items-center justify-center font-bold">0</span>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <slot />
        </main>

        <footer class="bg-white border-t border-gray-100 py-12 mt-20">
            <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
                <span class="text-lg font-black uppercase tracking-tighter text-[#072D44]">PharmaVictoria</span>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-widest text-center">© 2024 Licensed Pharmacy Professionals.</p>
                <div class="flex gap-6 text-[10px] font-black uppercase tracking-widest text-gray-400">
                    <a href="#" class="hover:text-pv-navy transition-colors">Help</a>
                    <a href="#" class="hover:text-pv-navy transition-colors">Privacy</a>
                    <a href="#" class="hover:text-pv-navy transition-colors">Contact</a>
                </div>
            </div>
        </footer>
    </div>
</template>