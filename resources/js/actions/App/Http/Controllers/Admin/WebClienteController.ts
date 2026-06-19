import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\WebClienteController::index
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/clientes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebClienteController::index
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebClienteController::index
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::index
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::create
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/clientes/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebClienteController::create
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebClienteController::create
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::create
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::store
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/clientes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\WebClienteController::store
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebClienteController::store
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::show
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
export const show = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/clientes/{cliente}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebClienteController::show
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
show.url = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { cliente: args }
    }

    if (Array.isArray(args)) {
        args = {
            cliente: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        cliente: args.cliente,
    }

    return show.definition.url
            .replace('{cliente}', parsedArgs.cliente.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebClienteController::show
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
show.get = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::show
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
show.head = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::edit
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}/edit'
*/
export const edit = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/clientes/{cliente}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebClienteController::edit
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}/edit'
*/
edit.url = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { cliente: args }
    }

    if (Array.isArray(args)) {
        args = {
            cliente: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        cliente: args.cliente,
    }

    return edit.definition.url
            .replace('{cliente}', parsedArgs.cliente.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebClienteController::edit
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}/edit'
*/
edit.get = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::edit
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}/edit'
*/
edit.head = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::update
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
export const update = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/clientes/{cliente}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Admin\WebClienteController::update
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
update.url = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { cliente: args }
    }

    if (Array.isArray(args)) {
        args = {
            cliente: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        cliente: args.cliente,
    }

    return update.definition.url
            .replace('{cliente}', parsedArgs.cliente.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebClienteController::update
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
update.put = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::update
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
update.patch = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Admin\WebClienteController::destroy
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
export const destroy = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/clientes/{cliente}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\WebClienteController::destroy
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
destroy.url = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { cliente: args }
    }

    if (Array.isArray(args)) {
        args = {
            cliente: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        cliente: args.cliente,
    }

    return destroy.definition.url
            .replace('{cliente}', parsedArgs.cliente.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebClienteController::destroy
* @see app/Http/Controllers/Admin/WebClienteController.php:0
* @route '/admin/clientes/{cliente}'
*/
destroy.delete = (args: { cliente: string | number } | [cliente: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const WebClienteController = { index, create, store, show, edit, update, destroy }

export default WebClienteController