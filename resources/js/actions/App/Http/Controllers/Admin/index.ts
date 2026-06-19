import WebProductoController from './WebProductoController'
import WebPedidoController from './WebPedidoController'
import WebClienteController from './WebClienteController'

const Admin = {
    WebProductoController: Object.assign(WebProductoController, WebProductoController),
    WebPedidoController: Object.assign(WebPedidoController, WebPedidoController),
    WebClienteController: Object.assign(WebClienteController, WebClienteController),
}

export default Admin