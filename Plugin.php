<?php namespace Waka\Phpw;

use Backend;
use Lang;
use System\Classes\PluginBase;
use App;
use Illuminate\Foundation\AliasLoader;

/**
 * Worder Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = [
        'Waka.Wutils',
        'Waka.Productor'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Worder',
            'description' => 'No description provided yet...',
            'author' => 'Waka',
            'icon' => 'icon-leaf',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        // App::bind(\PhpOffice\PhpWord\TemplateProcessor::class, \Waka\Phpw\Classes\Replacement\TemplateProcessors::class);
        $loader = AliasLoader::getInstance();
        $loader->alias(\PhpOffice\PhpWord\TemplateProcessor::class, \Waka\Phpw\Classes\Replacements\TemplateProcessor::class);
        //
        $driverManager = App::make('waka.productor.drivermanager');
        $driverManager->registerDriver('worder', function () {
            return new \Waka\Phpw\Classes\Worder();
        });
    }

    public function registerFormWidgets(): array
    {
        return [
            'Waka\Phpw\FormWidgets\ShowAttributes' => 'showattributes',
        ];
    }

    /**
     * Register model to clean.
     *
     * @return void
     */
    public function registerModelToClean()
    {
        return [
            'cleanSoftDelete' => [
                \Waka\Phpw\Models\Document::class => 0,
            ],
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
       
    }

    public function bootPackages()
    {
        // Get the namespace of the current plugin to use in accessing the Config of the plugin
        $pluginNamespace = str_replace('\\', '.', strtolower(__NAMESPACE__));

        // Instantiate the AliasLoader for any aliases that will be loaded
        $aliasLoader = AliasLoader::getInstance();

        // Get the packages to boot
        $packages = Config::get($pluginNamespace . '::packages');

        // Boot each package
        foreach ($packages as $name => $options) {
            // Setup the configuration for the package, pulling from this plugin's config
            if (!empty($options['config']) && !empty($options['config_namespace'])) {
                Config::set($options['config_namespace'], $options['config']);
            }

            // Register any Service Providers for the package
            if (!empty($options['providers'])) {
                foreach ($options['providers'] as $provider) {
                    App::register($provider);
                }
            }

            // Register any Aliases for the package
            if (!empty($options['aliases'])) {
                foreach ($options['aliases'] as $alias => $path) {
                    $aliasLoader->alias($alias, $path);
                }
            }
        }
    }


    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'waka.phpw.admin.base' => [
                'tab' => 'Waka - Worder',
                'label' => 'Administrateur de Worder',
            ],
             'waka.phpw.admin.super' => [
                'tab' => 'Waka - Worder',
                'label' => 'Super Administrateur de Worder',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [];
    }
    public function registerSettings()
    {
        return [
            'documents' => [
                'label' => Lang::get('waka.phpw::lang.menu.documents'),
                'description' => Lang::get('waka.phpw::lang.menu.documents_description'),
                'category' => Lang::get('waka.wutils::lang.menu.model_category'),
                'icon' => 'icon-file-word-o',
                'url' => Backend::url('waka/phpw/documents'),
                'permissions' => ['waka.worder.admin.*'],
                'order' => 10,
            ],
            // 'bloc_types' => [
            //     'label' => Lang::get('waka.phpw::lang.menu.bloc_type'),
            //     'description' => Lang::get('waka.phpw::lang.menu.bloc_type_description'),
            //     'category' => Lang::get('waka.phpw::lang.menu.settings_category'),
            //     'icon' => 'icon-th-large',
            //     'url' => Backend::url('waka/phpw/bloctypes'),
            //     'permissions' => ['waka.worder.admin'],
            //     'order' => 1,
            // ],
        ];
    }
}
