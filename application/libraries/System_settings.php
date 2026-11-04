<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;

class System_settings
{
    private static ?array $settings = null;
    private $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->loadSettings();
    }

    private function loadSettings(): void
    {
        // 1. Si ya se cargó en la memoria durante la petición actual, no hacer nada
        if (self::$settings !== null) {
            return;
        }

        // 2. Intentar cargar desde la caché de archivos de CodeIgniter (1 hora de TTL)
        $this->ci->load->driver('cache', ['adapter' => 'file', 'backup' => 'dummy']);
        $cached = $this->ci->cache->get('system_v2_settings');

        if ($cached && is_array($cached)) {
            self::$settings = $cached;
            return;
        }

        // 3. Si no está en caché, consultar la API de Laravel
        try {
            $client = new Client([
                'base_uri' => rtrim(getenv('SYSTEM_V2_URL'), '/') . '/',
                'timeout'  => 3.0,
            ]);

            $apiResponse = $client->request('GET', 'api/v1/settings');
            $body = json_decode($apiResponse->getBody()->getContents(), true);

            self::$settings = $body['data'] ?? [];

            // Guardar en la caché por 15 segundos
            $this->ci->cache->save('system_v2_settings', self::$settings, 20);

        } catch (\Exception $e) {
            $errorMessage = 'Error quering system settings: ' . $e->getMessage();
            log_message('error', $errorMessage);
            exit($errorMessage);
        }
    }

    public function getAppLogoUrl(): ?string
    {
        return self::$settings['system']['app_logo_url'] ?? null;
    }

    public function getFaviconUrl(): ?string
    {
        return self::$settings['system']['favicon_url'] ?? null;
    }

    public function getDocumentLogoUrl(): ?string
    {
        return self::$settings['system']['document_logo_url'] ?? null;
    }

    public function getDocumentLogoRealPath(): ?string
    {
        return self::$settings['system']['document_logo_real_path'] ?? null;
    }

    public function getPinMarkerUrl(): ?string
    {
        return self::$settings['system']['pin_marker_url'] ?? null;
    }

    public function getEnableManualApprovementForConciliations(): bool
    {
        return self::$settings['status_management']['enable_manual_approvement_for_conciliations'];
    }

    public function getNoPendingMaterialsInCreForAsBuilt(): bool
    {
        return self::$settings['status_management']['no_pending_materials_in_cre_for_as_built'];
    }

    public function getEmailFooterText(): string
    {
        return self::$settings['system']['email_footer_text'] ?? 'System.Admin';
    }

    public function isDetailedTreeTrimmingEnabled(): bool
    {
        return self::$settings['system']['enable_detailed_tree_trimming'];
    }

    public function all(): array
    {
        return self::$settings ?? [];
    }
}