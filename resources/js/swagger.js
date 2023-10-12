import { SwaggerUIBundle } from 'swagger-ui-dist'
import 'swagger-ui/dist/swagger-ui.css';

SwaggerUIBundle({
    dom_id: '#swagger-api',
    url: `${import.meta.env.VITE_APP_URL}:${import.meta.env.VITE_APP_PORT}/api.yaml`,
    presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIBundle.SwaggerUIStandalonePreset
    ],
})