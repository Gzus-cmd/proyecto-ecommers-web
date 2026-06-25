<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { User, Mail, Lock, Shield, Info } from 'lucide-vue-next';

defineProps<{ 
    form: any;
    roles: any[];
    isEditing?: boolean;
}>();
</script>

<template>
    <div class="space-y-8 text-foreground">
        

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <Label for="name" class="text-[10px] uppercase ml-1 tracking-widest text-muted-foreground">Nombre Completo</Label>
                <div class="relative">
                    <User class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-primary/40" />
                    <Input v-model="form.name" id="name" class="pl-10 h-11 border-border/40 bg-background/50" placeholder="Ej: Juan Pérez" />
                </div>
                <InputError :message="form.errors.name" />
            </div>

            <div class="space-y-2">
                <Label for="email" class="text-[10px] uppercase ml-1 tracking-widest text-muted-foreground">Correo Electrónico</Label>
                <div class="relative">
                    <Mail class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-primary/40" />
                    <Input v-model="form.email" id="email" type="email" class="pl-10 h-11 border-border/40 bg-background/50" placeholder="juan@pharmavictoria.com" />
                </div>
                <InputError :message="form.errors.email" />
            </div>
        </div>


        <div class="bg-primary/5 p-6 rounded-2xl border border-primary/10 shadow-inner">
            <div class="flex items-center gap-2 mb-4">
                <Shield class="size-4 text-primary" />
                <span class="text-[10px] font-black uppercase tracking-widest text-primary">Privilegios de Sistema</span>
            </div>
            <Label for="role" class="text-[9px] uppercase ml-1 opacity-60">Seleccione el Rol de Operador</Label>
            <select 
                v-model="form.role"
                id="role"
                class="w-full mt-2 border-border/60 bg-background rounded-xl text-sm h-12 px-4 focus:ring-2 focus:ring-primary/30 outline-none transition uppercase font-black tracking-tighter"
            >
                <option value="" disabled>Elegir un rol...</option>
                <option v-for="role in roles" :key="role.id" :value="role.name">
                    {{ role.name }}
                </option>
            </select>
            <InputError :message="form.errors.role" class="mt-1" />
        </div>


        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-border/30 pb-2">
                <div class="flex items-center gap-2">
                    <Lock class="size-4 text-primary" />
                    <span class="text-[10px] font-black uppercase tracking-widest text-foreground/70">Seguridad</span>
                </div>

                <span v-if="isEditing" class="text-[8px] font-black uppercase bg-amber-500/10 text-amber-500 px-2 py-0.5 rounded border border-amber-500/20 tracking-tighter">
                    Opcional al editar
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <Label for="password" class="text-[10px] uppercase ml-1 tracking-widest">
                        {{ isEditing ? 'Nueva Contraseña' : 'Contraseña' }}
                    </Label>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-muted-foreground/30" />
                        <Input v-model="form.password" id="password" type="password" class="pl-10 h-11 bg-background/40" />
                    </div>
                    <InputError :message="form.errors.password" />
                </div>

                <div class="space-y-2">
                    <Label for="password_confirmation" class="text-[10px] uppercase ml-1 tracking-widest">Confirmar Contraseña</Label>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-muted-foreground/30" />
                        <Input v-model="form.password_confirmation" id="password_confirmation" type="password" class="pl-10 h-11 bg-background/40" />
                    </div>
                </div>
            </div>


            <div v-if="isEditing" class="flex items-center gap-2 p-3 bg-muted/20 rounded-xl border border-border/40">
                <Info class="size-3 text-muted-foreground" />
                <p class="text-[9px] text-muted-foreground uppercase font-medium italic tracking-tight">
                    Deje los campos de contraseña en blanco si no desea realizar cambios en la clave actual.
                </p>
            </div>
        </div>

        <slot name="actions" />
    </div>
</template>