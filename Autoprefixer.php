<?php
namespace Autoprefixer;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;

class Autoprefixer extends \Shopware\Components\Plugin
{
    private $shopId = 1;

    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Command_After_Run' => 'runAutoprefixer',
        ];
    }

	public function install(InstallContext $context) {
		return true;
	}

	public function update(UpdateContext $context) {
		return true;
	}

	public function activate(ActivateContext $context) {
		return true;
	}

	public function deactivate(DeactivateContext $context) {
		return true;
	}

	public function uninstall(UninstallContext $context) {
		return true;
	}

    public function runAutoprefixer(\Enlight_Event_EventArgs $args)
    {
        if ($args['command']->getName() == 'sw:theme:cache:generate') {
            // get the shop context and fetch the path of the compiled css file
            $repository = Shopware()->Container()->get('models')->getRepository('Shopware\Models\Shop\Shop');

            $shop = $repository->getActiveById($this->shopId);
            $time = Shopware()->Container()->get('theme_timestamp_persistor')->getCurrentTimestamp($this->shopId);

            $pathResolver = Shopware()->Container()->get('theme_path_resolver');
            $file = $pathResolver->getCssFilePath($shop, $time);

            // run autoprefixer on the file
            echo "Running CSS prefixer ...\n";
            require_once $this->getPath().'/vendor/autoload.php';

            $config = Shopware()->Container()->get('shopware.plugin.cached_config_reader')->getByPluginName($this->getName(), $shop);

            $autoprefixer = Shopware()->Container()->get('maxia.autoprefixer');
            $autoprefixer->setBrowsers(array_map('trim', explode(',', $config['browserQuery'])));

            file_put_contents($file, $autoprefixer->compile(file_get_contents($file)));
        }
    }
}
